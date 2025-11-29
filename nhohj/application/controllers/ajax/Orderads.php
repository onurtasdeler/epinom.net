<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orderads extends CI_Controller
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
    

    //siparişler ajax liste
    public function getListeMyOrders()
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
                            if ($this->input->post("ad")) {
                                $ad = $this->input->post("ad", true);
                                //$ad= " and field_data like '%".$ad."%' ";
                                $filter .= '<a href="javascript:;"  class="remove-search-filter FilterEtiketIcerik adFilterss" data-id="ad-remove"><span>' . $ad . '<i class="fas fa-times"></i></span></a>';
                            }

                            $sirala = " order by created_at desc";

                            if ($this->input->post("types") == 1) {
                                //BEKLİYOR
                                $status = 0;
                            } else if ($this->input->post("types") == 11) {
                                //Teslim edildi onay bekleniyor
                                $status = 1;
                            } else if ($this->input->post("types") == 3) {
                                //HAZIRLANIYOR
                                $status = 3;
                            } else if ($this->input->post("types") == 4) {
                                //TESLİM EDİLDİ
                                $status = 4;
                            } else if ($this->input->post("types") == 5) {
                                //İPTAL EDİLDİ
                                $status = 5;
                            }


                            if ($ad != "") {
                                if($status==1){
                                    $cek = $this->m_tr_model->query("select * from table_orders_adverts where is_delete=0 and  user_id=".$user->id." and (status=1 or status=2)");
                                }else{
                                    $cek = getTable("table_orders_adverts", array("user_id" => $user->id, "status" => $status));
                                }
                                if ($cek) {

                                    foreach ($cek as $item) {
                                        $cekUr = getTableSingle("table_adverts", array("id" => $item->advert_id));
                                        $pars = json_decode($cekUr->field_data);
                                        foreach ($pars as $par) {
                                            if ($par->lang_id == $this->input->post("lang")) {
                                                if (stristr($par->name, $ad)) {
                                                    $bulunanlar[] = $item->id;
                                                }
                                            }
                                        }
                                    }

                                    if($status==1){
                                        $cek2=$this->m_tr_model->query("select * from table_orders_adverts where is_delete=0 and  user_id = ".$user->id." and sipNo like '%".$ad."%' and (status=1 or status=2)" );
                                    }else{
                                        $cek2=$this->m_tr_model->query("select * from table_orders_adverts where is_delete=0 and  user_id = ".$user->id." and sipNo like '%".$ad."%' and status=".$status );
                                    }

                                    if($cek2){
                                        foreach ($cek2 as $itemss) {
                                            if(array_search($itemss->id,$bulunanlar)){

                                            }else{
                                                $bulunanlar[]=$itemss->id;
                                            }
                                        }
                                    }
                                }
                                if ($bulunanlar) {
                                    $toplam = count($bulunanlar);
                                } else {
                                    $toplam = 0;
                                }

                            } else {
                                if($status==1){
                                    $toplam = $this->m_tr_model->query("select count(*) as say from table_orders_adverts where is_delete=0 and  user_id=" . $user->id . " and (status=1 or status=2) ");
                                }else{
                                    $toplam = $this->m_tr_model->query("select count(*) as say from table_orders_adverts where is_delete=0 and  user_id=" . $user->id . " and status=" . $status);
                                }
                                $toplam = $toplam[0]->say;
                            }


                            if ($toplam >= 1) {
                                $toplam_sayfa = ceil($toplam / 10);
                                if ($sayfa < 1) $sayfa = 1;
                                if ($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;
                                $limit = ($sayfa - 1) * 10;
                                if ($bulunanlar) {

                                    $verilers = "";
                                    for ($i = 0; $i < count($bulunanlar); $i++) {
                                        $verilers .= $bulunanlar[$i] . ",";
                                    }

                                    $verilers = rtrim($verilers, ",");
                                    if($status==1){
                                        $ilanlar = $this->m_tr_model->query("select * from table_orders_adverts where is_delete=0 and  id in (" . $verilers . ") and user_id=" . $user->id . " and (status = 1 or status = 2)  "  . $sirala . " limit " . $limit . ",10");
                                    }else{
                                        $ilanlar = $this->m_tr_model->query("select * from table_orders_adverts where is_delete=0 and  id in (" . $verilers . ") and user_id=" . $user->id . " and status = " . $status . $sirala . " limit " . $limit . ",10");

                                    }
                                } else {
                                    if($status==1){
                                        $ilanlar = $this->m_tr_model->query("select * from table_orders_adverts where is_delete=0 and  user_id=" . $user->id . " and (status =1 or status=2)   " . $sirala . " limit " . $limit . ",10");
                                    }else{
                                        $ilanlar = $this->m_tr_model->query("select * from table_orders_adverts where is_delete=0 and  user_id=" . $user->id . " and status = " . $status . $sirala . " limit " . $limit . ",10");
                                    }
                                }

                                $useragent = $_SERVER['HTTP_USER_AGENT'];
                                $mobil = 0;
                                if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
                                    $mobil = 1;
                                }

                                if ($ilanlar) {
                                    foreach ($ilanlar as $value) {
                                        //$cekUrun=$this->m_tr_model->query("select * from table_adverts where id=".$value->advert_id);
                                        $cekUrun = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $value->advert_id));
                                        if ($cekUrun) {

                                            $ll = getLangValue($cekUrun->id, "table_adverts", $this->input->post("lang"));
                                            $str .= '<div class="box boyutlaIlan">';
                                            $cekImage=getTableSingle("table_adverts_image",array("id" => $cekUrun->selected_image));

                                            $ilanResimler = getTableOrder("table_adverts_upload_image", array("adverts_id" => $cekUrun->id, "status" => 1, "deleted" => 0), "id", "asc");
                                            if ($ilanResimler) {
                                                $say=0;
                                                foreach ($ilanResimler as $re) {
                                                    if($say==0){
                                                        if($re->image==""){
                                                            $katCek=getTableSingle("table_advert_category",array("id" => $cekUrun->category_top_id));
                                                            if($katCek){
                                                                if($katCek->image!=""){
                                                                    $str.='<img  alt=""  src="' . base_url("upload/ilanlar/".$katCek->image)  . '">';
                                                                    break;
                                                                }else{
                                                                    $str.='<img  alt=""  src="' . base_url("assets/images/noimage.jpeg") . '">';
                                                                    break;
                                                                }
                                                            }else{
                                                                $str.='<img  alt=""  src="' . base_url("assets/images/noimage.jpeg") . '">';
                                                                break;

                                                            }
                                                        }else{
                                                            $str.='<img   alt="" src="' . base_url("upload/ilanlar_users/" . $re->image) . '">';
                                                            break;
                                                        }

                                                    }
                                                }
                                            } else {
                                                $secilen = getTableSingle("table_adverts_image", array("id" => $cekUrun->selected_image));
                                                if ($secilen) {
                                                    $str.='<img alt=""  src="' . base_url("upload/ilanlar/default/" . $secilen->image) . '">';
                                                }
                                            }



                                            if ($value->price_discount != 0) {
                                                $hesap = $value->price_discount * $value->quantity;
                                                $price = floor($value->price_discount*100)/100 . " " . getcur() . " x " . $value->quantity . " = " . floor($hesap*100)/100;
                                            } else {
                                                $hesap = $value->price * $value->quantity;
                                                $price = floor($value->price*100)/100 . " " . getcur() . " x " . $value->quantity . " = " . floor($hesap*100)/100;
                                            }
                                            $info = "";
                                            $bg = "";
                                            if ($value->status == 2) {
                                                $bg = "bg-success";
                                            } else if ($value->status == 5) {
                                                $bg = "bg-danger";
                                            } else if ($value->status == 3) {
                                                $bg = "bg-info";
                                            }


                                            if($mobil==1){
                                                $str .= '<div class="right">
                                                    <h5>' . kisalt($ll->name, 35) . ' <span style="color: #c5c5c5;font-size: 8pt;"> - ' . $value->sipNo . '</span></h5>
                                                     <div class="price">
                                                         ' . $price . ' ' . getcur();
                                                $str .= '</div>
                                               
                                             </div>';
                                            }else{
                                                $str .= '<div class="right">
                                                    <h5>' . kisalt($ll->name, 65) . ' <span style="color: #c5c5c5;font-size: 8pt;"> - ' . $value->sipNo . '</span></h5>
                                                     <div class="price">
                                                         ' . $price . ' ' . getcur();
                                                $str .= '</div>
                                                 <div class="date">
                                                    ' . date("Y-m-d H:i", strtotime($value->created_at)) . '
                                                 </div>
                                             </div>';
                                            }



                                            $ilanlarimPage=getLangValue(54,"table_pages",$this->input->post("lang"));
                                            if($status==1){
                                                if($value->status==1){
                                                    $str .= '<a href="'.base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".permalink($value->sipNo).'"  data-id="' . $value->sipNo . '" class="detail bg-warning"><b style="color:#393939"> <i class="mdi mdi-clock"></i> ' . langS(379, 2,$this->input->post("lang")) . '</b></a>';
                                                }else if($value->status==2){
                                                    $str .= '<a href="'.base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".permalink($value->sipNo).'"  data-id="' . $value->sipNo . '" class="detail bg-info"><b>  <i class="mdi mdi-note-search-outline" style="font-size:12pt;"></i> ' . langS(380, 2,$this->input->post("lang")) . '</b></a>';
                                                }
                                            }else{
                                                $str .= '<a onclick="git(\''.base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".permalink($value->sipNo).'\')"  data-id="' . $value->sipNo . '" class="detail ' . $bg . '">' . langS(221, 2,$this->input->post("lang")) . '</a>';
                                            }


                                            if ($value->price_discount == 0) {
                                                $pricess = $value->price;
                                            } else {
                                                $pricess = $value->price_discount;
                                            }

                                            $str .= '
                                                </div>
                                            </div>';
                                        }
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


    //gelen siparişlerim liste
    public function getListeMySellOrders()
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
                            if ($this->input->post("ad")) {
                                $ad = $this->input->post("ad", true);
                                //$ad= " and field_data like '%".$ad."%' ";
                                $filter .= '<a href="javascript:;"  class="remove-search-filter FilterEtiketIcerik adFilterss" data-id="ad-remove"><span>' . $ad . '<i class="fas fa-times"></i></span></a>';
                            }

                            $sirala = " order by created_at desc";

                            if ($this->input->post("types") == 1) {
                                //BEKLİYOR
                                $status = 0;
                            } else if ($this->input->post("types") == 11) {
                                //TAMAMLANDI
                                $status = 1;
                            } else if ($this->input->post("types") == 3) {
                                //HAZIRLANIYOR
                                $status = 3;
                            } else if ($this->input->post("types") == 4) {
                                //TESLİM EDİLDİ
                                $status = 4;
                            } else if ($this->input->post("types") == 5) {
                                //İPTAL EDİLDİ
                                $status = 5;
                            }


                            if ($ad != "") {
                                if($status==1){
                                    $cek = $this->m_tr_model->query("select * from table_orders_adverts where sell_user_id=".$user->id." and (status=1 or status=2)");
                                }else{
                                    $cek = getTable("table_orders_adverts", array("sell_user_id" => $user->id, "status" => $status));
                                }

                                //$cek = getTable("table_orders_adverts", array("sell_user_id" => $user->id, "status" => $status));
                                if ($cek) {
                                    foreach ($cek as $item) {
                                        $cekUr = getTableSingle("table_adverts", array("id" => $item->advert_id , "user_id" => $user->id));
                                        $pars = json_decode($cekUr->field_data);
                                        foreach ($pars as $par) {
                                            if ($par->lang_id == $this->input->post("lang")) {
                                                if (stristr($par->name, $ad)) {
                                                    $bulunanlar[] = $item->id;
                                                }
                                            }
                                        }
                                    }

                                    if($status==1){
                                        $cek2=$this->m_tr_model->query("select * from table_orders_adverts where sell_user_id = ".$user->id." and sipNo like '%".$ad."%' and (status=1 or status=2)" );
                                    }else{
                                        $cek2=$this->m_tr_model->query("select * from table_orders_adverts where sell_user_id = ".$user->id." and sipNo like '%".$ad."%' and status=".$status );
                                    }

                                    //$cek2=$this->m_tr_model->query("select * from table_orders_adverts where sell_user_id = ".$user->id." and sipNo like '%".$ad."%' " );
                                    if($cek2){
                                        foreach ($cek2 as $itemss) {
                                            if(array_search($itemss->id,$bulunanlar)){

                                            }else{
                                                $bulunanlar[]=$itemss->id;
                                            }
                                        }
                                    }
                                }
                                if ($bulunanlar) {
                                    $toplam = count($bulunanlar);
                                } else {
                                    $toplam = 0;
                                }

                            } else {
                                if($status==1){
                                    $toplam = $this->m_tr_model->query("select count(*) as say from table_orders_adverts where sell_user_id=" . $user->id . " and (status=1 or status=2) ");
                                }else{
                                    $toplam = $this->m_tr_model->query("select count(*) as say from table_orders_adverts where sell_user_id=" . $user->id . " and status=" . $status);
                                }

                                //$toplam = $this->m_tr_model->query("select count(*) as say from table_orders_adverts where sell_user_id=" . $user->id . " and status=" . $status . $ad);
                                $toplam = $toplam[0]->say;
                            }


                            if ($toplam >= 1) {
                                $toplam_sayfa = ceil($toplam / 10);
                                if ($sayfa < 1) $sayfa = 1;
                                if ($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;
                                $limit = ($sayfa - 1) * 10;
                                if ($bulunanlar) {
                                    $verilers = "";
                                    for ($i = 0; $i < count($bulunanlar); $i++) {
                                        $verilers .= $bulunanlar[$i] . ",";
                                    }

                                    $verilers = rtrim($verilers, ",");
                                    if($status==1){
                                        $ilanlar = $this->m_tr_model->query("select * from table_orders_adverts where id in ( " . $verilers . " ) and sell_user_id=" . $user->id . " and (status = 1 or status = 2)  "  . $sirala . " limit " . $limit . ",10");
                                    }else{
                                        $ilanlar = $this->m_tr_model->query("select * from table_orders_adverts where id in ( " . $verilers . " ) and sell_user_id=" . $user->id . " and status = " . $status . $sirala . " limit " . $limit . ",10");

                                    }
                                    //$ilanlar = $this->m_tr_model->query("select * from table_orders_adverts where id in (" . $verilers . ") and sell_user_id=" . $user->id . " and status = " . $status . $sirala . " limit " . $limit . ",10");
                                } else {
                                    if($status==1){
                                        $ilanlar = $this->m_tr_model->query("select * from table_orders_adverts where sell_user_id=" . $user->id . " and (status =1 or status=2)   " . $sirala . " limit " . $limit . ",10");
                                    }else{

                                        $ilanlar = $this->m_tr_model->query("select * from table_orders_adverts where sell_user_id=" . $user->id . " and status = " . $status . $sirala . " limit " . $limit . ",10");
                                    }

                                    //$ilanlar = $this->m_tr_model->query("select * from table_orders_adverts where sell_user_id=" . $user->id . " and status = " . $status . $sirala . " limit " . $limit . ",10");
                                }
                                $useragent = $_SERVER['HTTP_USER_AGENT'];
                                $mobil = 0;
                                if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
                                    $mobil = 1;
                                }

                                if ($ilanlar) {
                                    foreach ($ilanlar as $value) {
                                        if($status==3){
                                            $cekUrun = $this->m_tr_model->queryRow("select * from table_adverts where (status=4 or (status=6 and type=1)) and id = ".$value->advert_id);
                                        }else{
                                            $cekUrun = $this->m_tr_model->queryRow("select * from table_adverts where  id = ".$value->advert_id);
                                        }
                                        //$cekUrun = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $value->advert_id, "status" => 4));
                                        if ($cekUrun) {

                                            $ll = getLangValue($cekUrun->id, "table_adverts", $this->input->post("lang"));
                                            $str .= '<div class="box boyutlaIlan">';
                                            $cekImage=getTableSingle("table_adverts_image",array("id" => $cekUrun->selected_image));
                                            $ilanResimler = getTableOrder("table_adverts_upload_image", array("adverts_id" => $cekUrun->id, "status" => 1, "deleted" => 0), "id", "asc");
                                            if ($ilanResimler) {
                                                $say=0;
                                                foreach ($ilanResimler as $re) {
                                                    if($say==0){
                                                        if($re->image==""){
                                                            $katCek=getTableSingle("table_advert_category",array("id" => $cekUrun->category_top_id));
                                                            if($katCek){
                                                                if($katCek->image!=""){
                                                                    $str.='<img  alt=""  src="' . base_url("upload/ilanlar/".$katCek->image)  . '">';
                                                                    break;
                                                                }else{
                                                                    $str.='<img  alt=""  src="' . base_url("assets/images/noimage.jpeg") . '">';
                                                                    break;
                                                                }
                                                            }else{
                                                                $str.='<img  alt=""  src="' . base_url("assets/images/noimage.jpeg") . '">';
                                                                break;

                                                            }
                                                        }else{
                                                            $str.='<img   alt="" src="' . base_url("upload/ilanlar_users/" . $re->image) . '">';
                                                            break;
                                                        }

                                                    }
                                                }
                                            } else {
                                                $secilen = getTableSingle("table_adverts_image", array("id" => $cekUrun->selected_image));
                                                if ($secilen) {
                                                    $str.='<img alt=""  src="' . base_url("upload/ilanlar/default/" . $secilen->image) . '">';
                                                }
                                            }

                                            if ($value->price_discount != 0) {
                                                $hesap = $value->price_discount * $value->quantity;
                                                $price = floor($value->price_discount*100)/100 . " " . getcur() . " x " . $value->quantity . " = " . floor($hesap*100)/100;
                                            } else {
                                                $hesap = $value->price * $value->quantity;
                                                $price = floor($value->price*100)/100 . " " . getcur() . " x " . $value->quantity . " = " . floor($hesap*100)/100;
                                            }
                                            $info = "";
                                            if ($value->special_field != "") {
                                                $cekOzel = $this->m_tr_model->getTableSingle("table_adverts_special", array("p_id" => $value->product_id, "status" => 1, "is_main" => 1));
                                                if ($cekOzel) {
                                                    $info = getLangValue($cekOzel->id, "table_adverts_special",$this->input->post("lang"));
                                                    $infomobil = $info;
                                                    $info = ' - <span class="text-info">' . $info->name . " : " . $value->special_field . "</span>";
                                                }
                                            } else {
                                                $cekOzel = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $value->product_id, "status" => 1));
                                            }
                                            $bg = "";
                                            if ($value->status == 2) {
                                                $bg = "bg-success";
                                            } else if ($value->status == 5) {
                                                $bg = "bg-danger";
                                            } else if ($value->status == 3) {
                                                $bg = "bg-info";
                                            }

                                            if($mobil==1){
                                                $str .= '<div class="right">
                                                    <h5>' . kisalt($ll->name, 45) . ' <span style="color: #c5c5c5;font-size: 8pt;"> - ' . $value->sipNo . '</span></h5>
                                                     <div class="price">
                                                         ' . $price . ' ' . getcur();
                                            }else{
                                                $str .= '<div class="right">
                                                    <h5>' . kisalt($ll->name, 65) . ' <span style="color: #c5c5c5;font-size: 8pt;"> - ' . $value->sipNo . '</span></h5>
                                                     <div class="price">
                                                         ' . $price . ' ' . getcur();
                                            }



                                            if ($mobil == 1) {
                                                $str .= '</div></div>';
                                            } else {
                                                $str .= $info;
                                                $str .= '</div>
                                                 <div class="date">
                                                    ' . date("Y-m-d H:i", strtotime($value->created_at)) . '
                                                 </div>
                                             </div>';
                                            }

                                            $ilanlarimPage=getLangValue(57,"table_pages",$this->input->post("lang"));
                                            if($status==1){
                                                if($value->status==1){
                                                    $str .= '<a href="'.base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".permalink($value->sipNo).'"  data-id="' . $value->sipNo . '" class="detail bg-warning"><b style="color:#393939"> <i class="mdi mdi-clock"></i> ' . langS(382, 2,$this->input->post("lang")) . '</b></a>';
                                                }else if($value->status==2){
                                                    $str .= '<a href="'.base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".permalink($value->sipNo).'"  data-id="' . $value->sipNo . '" class="detail bg-info"><b>  <i class="mdi mdi-note-search-outline" style="font-size:12pt;"></i> ' . langS(380, 2,$this->input->post("lang")) . '</b></a>';
                                                }
                                            }else{
                                                $str .= '<a onclick="git(\''.base_url().gg($this->input->post("lang")).$ilanlarimPage->link."/".permalink($value->sipNo).'\')"  data-id="' . $value->sipNo . '" class="detail ' . $bg . '">' . langS(221, 2,$this->input->post("lang")) . '</a>';
                                            }




                                            if ($value->price_discount == 0) {
                                                $pricess = $value->price;
                                            } else {
                                                $pricess = $value->price_discount;
                                            }





                                            $str .= '
                                                </div>
                                            </div>';
                                        }
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

    public function setOrderStatus(){
        if ($_POST) {
            $this->load->model("m_tr_model");
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                header('Content-Type: application/json');
                if ($this->input->post("adNo", true) && $this->input->post("types", true)) {
                    $token = token_control();
                    if ($token == "2") {
                        echo json_encode(array("err" => "oturum"));
                    } else{
                        $user=getActiveUsers();
                        if($user){
                            if($this->input->post("types", true)==1){
                                if($this->input->post("adNo",true)){
                                    $temizle=$this->security->xss_clean(str_replace("SHT-","",$this->input->post("adNo",true)));
                                    $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $temizle,"status" => 0,"sell_user_id" => $user->id ));
                                    if($kontrol){
                                        $advert=getTableSingle("table_adverts",array("id" => $kontrol->advert_id,"status" => 4));
                                        $alici=getTableSingle("table_users",array("id" => $kontrol->user_id,"status" => 1,"banned" => 0));
                                        if($alici){
                                            if($advert){
                                                $teslim_at=date("Y-m-d H:i:s");
                                                $orderGuncelle=$this->m_tr_model->updateTable("table_orders_adverts",array("status" => 1,
                                                    "teslim_at" => $teslim_at,"teslim_lang" => $_SESSION["lang"]),
                                                    array("id" => $kontrol->id));
                                                if($orderGuncelle){
                                                    $cekAyar=getTableSingle("table_options_sms",array("id" => 1));
                                                    if($cekAyar->modul_aktif==1){
                                                        if($alici->phone!=""){
                                                            try {
                                                                $cekSablon=getTableSingle("table_lang_sms_mail",array("order_id" => 2,"lang_id" => $_SESSION["lang"]));
                                                                $this->load->helper("netgsm_helper");
                                                                $dil=getLangValue($advert->id,"table_adverts",$this->input->post("lang"));
                                                                $ad="";
                                                                if($dil->name==""){
                                                                    $ad=$advert->ad_name;
                                                                }else{
                                                                    $ad=$dil->name;
                                                                }

                                                                $smsSablon=str_replace("{name}",kisalt($ad,20),$cekSablon->value);
                                                                $smsSablon=str_replace("{sipno}",$kontrol->sipNo,$smsSablon);

                                                                $sms=smsGonder($alici->phone,$smsSablon." - B-".rand(100,999));
                                                            }catch (Exception $ex){

                                                            }
                                                        }
                                                    }
                                                    $mailGonder=email_gonder($alici->email,$kontrol->sipNo." No'lu İlan Siparişiniz Teslim Edilmek Üzere İşlendi. Onayınız beklenmektedir.","","",1,base_url("temp-mail/6/test/".$alici->id."/".$kontrol->sipNo));
                                                    $bildirimEkle=$this->m_tr_model->add_new(array(
                                                        "user_id" => $kontrol->user_id,
                                                        "noti_id" => 15,
                                                        "type" => 1,
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "advert_id" => $advert->id,"order_id" => $kontrol->id,
                                                    ),"table_notifications_user");
                                                    addLog("İlan Siparişi Teslim Edilmek Üzere İşaretlendi.", $temizle." no'lu '".$advert->ad_name."' adlı ilan siparişi satıcı tarafından ".$teslim_at." tarihinde teslim edildi olarak işaretlendi. Alıcının onayı bekleniyor.", 1);
                                                    echo json_encode(array("err" => false,"message" => "ok","alici" => $alici->nick_name,"date" => $teslim_at,"name" => $advert->ad_name));
                                                }else{
                                                    addLog("İlan Siparişi Teslimat Hatası.", $temizle." no'lu ilan siparişinde satıcı ilan teslimi sırasında beklenmeyen bir hata meydana geldi.", 2);
                                                    echo json_encode(array("err" => true,"message" => langS(344,2,$this->input->post("lang"))));
                                                }

                                            }else{
                                                echo json_encode(array("err" => "oturum"));
                                            }
                                        }
                                    }else{
                                        echo json_encode(array("err" => "oturum"));
                                    }
                                }else{
                                    echo json_encode(array("err" => "oturum"));
                                }
                            }else{

                            }

                        }else{
                            echo json_encode(array("err" => "oturum"));
                        }
                    }
                }else{
                    addLog("Saldırı Uygulandı.", "setOrderStatus kontrol Liste", 3);
                }
            }else{
                addLog("Saldırı Uygulandı.", "setOrderStatus formControl Liste", 3);
            }
        }else{
            addLog("Saldırı Uygulandı.", "setOrderStatus Post Liste", 3);
        }
    }

    public function orderMessageAddSeller(){
        if ($_POST) {
            $this->load->model("m_tr_model");
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                $user = getActiveUsers();
                if ($user) {
                    if ($this->input->post("types")) {
                        if ($this->input->post("talep")) {
                            $talep = $this->security->xss_clean($this->input->post("talep"));
                            header('Content-Type: application/json');
                            $kkontrol = $this->m_tr_model->getTableSingle("table_orders_adverts", array("sipNo" => $talep,"sell_user_id" => $user->id));
                            if ($kkontrol) {
                                if($kkontrol->status==0){
                                    echo json_encode(array("err" => true, "message" => "none"));
                                }else{
                                    $kontrolAds=getTableSingle("table_adverts",array("id" => $kkontrol->advert_id));
                                    if($kontrolAds){
                                        $cekSohbet = getTableOrder("table_orders_adverts_message", array("advert_id" => $kkontrol->advert_id), "created_at", "asc");
                                        if ($cekSohbet) {
                                            $alici=getTableSingle("table_users",array("id" => $kkontrol->user_id));

                                            foreach ($cekSohbet as $item) {
                                                $tarih1 = new DateTime($item->created_at);
                                                $tarih2 = new DateTime();
                                                $interval = $tarih2->diff($tarih1);
                                                $fark = "";
                                                if ($interval->format('%a') > 0) {
                                                    $fark = " - " . $interval->format('%a ' . langS(274, 2,$this->input->post("lang")) . " " . langS(274, 2,$this->input->post("lang")));
                                                } else {
                                                    $fark = " - " . langS(275, 2,$this->input->post("lang"));
                                                }
                                                if ($item->type == 2) {
                                                    $str .= '<li class="clearfix">
                                                <div class="message-data">';
                                                    if($alici->image==""){
                                                        $str.='<img src="' . base_url("assets/images/profilepic.png") . '" alt="avatar">';
                                                    }else{
                                                        $str.='<img src="' . base_url("upload/users/" . $alici->image) . '" alt="avatar">';
                                                    }
                                                    $str.='<span class="message-data-time">' . date("H:i", strtotime($item->created_at)) . $fark . '</span>
                                                </div>';
                                                    if($item->is_deleted==0){
                                                        $str.='<div class="message my-message">' . $item->message . '</div></li>';
                                                    }else{
                                                        $str.='<div style="background-color: #d7144a;" class="message my-message">'.langS(346,2,$this->input->post("lang")).'</div>';
                                                    }
                                                } else {
                                                    $str .= '<li class="clearfix">
                                                <div class="message-data text-right">
                                                    <span class="message-data-time">' . date("H:i", strtotime($item->created_at)) . $fark . '</span>';
                                                    if($user->image==""){
                                                        $str.='<img src="' . base_url("assets/images/profilepic.png") . '" alt="avatar">';
                                                    }else{
                                                        $str.='<img src="' . base_url("upload/users/" . $user->image) . '" alt="avatar">';
                                                    }


                                                $str.='</div>';
                                                    if($item->is_deleted==0){
                                                        $str.='<div class="message other-message float-right">' . $item->message . '</div>';
                                                    }else{
                                                        $str.='<div style="background-color: #d7144a;" class="message other-message float-right">'.langS(346,2,$this->input->post("lang")).'</div>';
                                                    }
                                            $str.='</li>';
                                                }
                                            }
                                            echo json_encode(array("veri" => $str, "status" => $kkontrol->status));
                                        } else {
                                            if($kkontrol->status==1){
                                                echo json_encode(array("err" => true, "message" => "sendis"));
                                            }else{
                                                echo json_encode(array("err" => true, "message" => "sendiss"));
                                            }

                                        }
                                    }else{
                                        echo json_encode(array("err" => true, "message" => "none"));
                                    }
                                }
                            }else{
                                echo json_encode(array("err" => true, "message" => "oturum"));
                            }
                        } else {
                            echo json_encode(array("err" => true, "message" => "oturum"));
                        }
                    } else {
                        header('Content-Type: application/json');
                        if ($this->input->post("talep") && $this->input->post("mesaj")) {
                            $talep = $this->security->xss_clean($this->input->post("talep"));
                            $mesaj = $this->security->xss_clean($this->input->post("mesaj"));
                            $kkontrol = $this->m_tr_model->getTableSingle("table_orders_adverts", array("sipNo" => $talep,"sell_user_id"  => $user->id));
                            if ($kkontrol) {
                                if ($kkontrol->status != 0 ) {
                                    $kontrolAds=getTableSingle("table_adverts",array("id" => $kkontrol->advert_id));
                                    $sorgula = $this->m_tr_model->getTableOrder("table_orders_adverts_message", array("advert_id" => $kkontrol->advert_id), "id", "desc");
                                    if ($sorgula) {
                                        $s=0;
                                        $us=0;
                                        foreach ($sorgula as $ss) {
                                            if ($s <= 3) {
                                                if ($ss->type != 2) {
                                                    $us++;
                                                }
                                            }
                                            $s++;
                                        }

                                        if ($us < 3) {
                                            $yasakli=0;
                                            if(ClearText($mesaj)==true){
                                                $yasakli=1;
                                            }else{
                                                $yasakli=0;
                                            }
                                            $kaydet = $this->m_tr_model->add_new(array(
                                                "advert_id" => $kkontrol->advert_id,
                                                "seller_id" => $user->id,
                                                "buyer_id" => $kkontrol->user_id,
                                                "type" => 1,
                                                "message" => $mesaj,
                                                "is_deleted" => $yasakli,
                                                "created_at" => date("Y-m-d H:i:s")
                                            ), "table_orders_adverts_message");
                                            if ($kaydet) {
                                                if($yasakli==0){
                                                    $ayarCek=getTableSingle("table_options_sms",array("id" => 1));
                                                    $alici=getTableSingle("table_users",array("id" => $kkontrol->user_id));
                                                    $mailGonder=email_gonder($alici->email,$kkontrol->sipNo." No'lu Siparişinizle alakalı satıcıdan yeni mesajınız var.","","",1,base_url("temp-mail/7/test/".$alici->id."/".$kkontrol->sipNo));
                                                    $bildirimEkle=$this->m_tr_model->add_new(array(
                                                        "user_id" => $alici->id,
                                                        "noti_id" => 16,
                                                        "type" => 1,
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "advert_id" => $kkontrol->advert_id,"order_id" => $kkontrol->id,
                                                    ),"table_notifications_user");
                                                    addLog("Satıcı Canlı Sohbetten Mesaj Gönderdi", $kkontrol->sipNo." no'lu '".$kontrolAds->ad_name."' adlı ilan siparişinin onayı için  satıcı tarafından canlı sohbet üzerinden mesaj gönderildi. Mesaj : ".$mesaj, 1);
                                                }
                                                echo json_encode(array("err" => false,"yasakli" => $yasakli,"message" => langS(278, 2,$this->input->post("lang"))));
                                            } else {
                                                echo json_encode(array("err" => true, "message" => langS(38, 2,$this->input->post("lang"))));
                                            }
                                        } else {
                                            echo json_encode(array("err" => true, "message" => langS(345,2,$this->input->post("lang"))));
                                        }
                                    }else{
                                        $yasakli=0;
                                        if(ClearText($mesaj)){
                                            $yasakli=1;
                                        }else{
                                            $yasakli=0;
                                        }
                                        $kaydet = $this->m_tr_model->add_new(array(
                                            "advert_id" => $kkontrol->advert_id,
                                            "seller_id" => $user->id,
                                            "buyer_id" => $kkontrol->user_id,
                                            "type" => 1,
                                            "message" => $mesaj,
                                            "is_deleted" => $yasakli,
                                            "created_at" => date("Y-m-d H:i:s")
                                        ), "table_orders_adverts_message");
                                        if ($kaydet) {
                                            if($yasakli==0){
                                                $ayarCek=getTableSingle("table_options_sms",array("id" => 1));
                                                if($ayarCek->modul_aktif==1){
                                                    $sablon=getTableSingle("table_lang_sms_mail",array("order_id" => 3,"lang_id" => $_SESSION["lang"]));
                                                    try {
                                                        $alici=getTableSingle("table_users",array("id" => $kkontrol->user_id));
                                                        $this->load->helper("netgsm_helper");
                                                        $smsG=str_replace("{sipno}",$kkontrol->sipNo,$sablon->value);
                                                        $smsG=str_replace("{satici}",$user->nick_name,$smsG);
                                                        $smsBilgi=smsGonder($alici->phone,$smsG." - B".rand(1000,9999));
                                                    }catch (Exception $ex){
                                                        $smsBilgi="Sms Gönderilirken Hata meydana geldi";
                                                    }
                                                }else{
                                                    $smsBilgi="Modül Pasif";
                                                }
                                                $mailGonder=email_gonder($alici->email,$kkontrol->sipNo." No'lu Siparişinizle alakalı satıcıdan yeni mesajınız var.","","",1,base_url("temp-mail/7/test/".$alici->id."/".$kkontrol->sipNo));
                                                $bildirimEkle=$this->m_tr_model->add_new(array(
                                                    "user_id" => $alici->id,
                                                    "noti_id" => 16,
                                                    "type" => 1,
                                                    "created_at" => date("Y-m-d H:i:s"),
                                                    "advert_id" => $kkontrol->advert_id,
                                                    "order_id" => $kkontrol->id,
                                                ),"table_notifications_user");
                                                $guncelle=$this->m_tr_model->updateTable("table_orders_adverts_message",array("sms_control" => $smsBilgi,"mail_control" => $mailGonder),array("id" => $kaydet));
                                                addLog("Satıcı Canlı Sohbetten Mesaj Gönderdi", $kkontrol->sipNo." no'lu '".$kontrolAds->ad_name."' adlı ilan siparişinin onayı için  satıcı tarafından canlı sohbet üzerinden mesaj gönderildi. Mesaj : ".$mesaj, 1);
                                            }
                                            echo json_encode(array("err" => false,"yasakli" => $yasakli,"message" => langS(278, 2,$this->input->post("lang"))));
                                        } else {
                                            echo json_encode(array("err" => true, "message" => langS(38, 2,$this->input->post("lang"))));
                                        }
                                    }
                                }else{
                                    echo json_encode(array("err" => true, "message" => "none"));
                                }
                            } else {
                                echo json_encode(array("err" => true, "message" => "oturum"));
                            }
                        }
                    }

                } else {
                    header('Content-Type: application/json');
                    echo json_encode(array("err" => true, "message" => "oturum"));
                }
            } else {
                addLog("Saldırı Uygulandı.", "orderMessageAdd", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "orderMessageAdd", 3);
        }
    }

    public function orderMessageAddBuyer(){
        if ($_POST) {
            $this->load->model("m_tr_model");
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                $user = getActiveUsers();
                if ($user) {
                    if ($this->input->post("types")) {
                        if ($this->input->post("talep")) {
                            $talep = $this->security->xss_clean($this->input->post("talep"));
                            header('Content-Type: application/json');
                            $kkontrol = $this->m_tr_model->getTableSingle("table_orders_adverts", array("sipNo" => $talep,"user_id" => $user->id));
                            if ($kkontrol) {
                                if($kkontrol->status==0){
                                    echo json_encode(array("err" => true, "message" => "none"));
                                }else{
                                    $kontrolAds=getTableSingle("table_adverts",array("id" => $kkontrol->advert_id));
                                    if($kontrolAds){
                                        $cekSohbet = getTableOrder("table_orders_adverts_message", array("advert_id" => $kkontrol->advert_id), "created_at", "asc");
                                        if ($cekSohbet) {
                                            $satici=getTableSingle("table_users",array("id" => $kkontrol->sell_user_id));
                                            foreach ($cekSohbet as $item) {
                                                $tarih1 = new DateTime($item->created_at);
                                                $tarih2 = new DateTime();
                                                $interval = $tarih2->diff($tarih1);
                                                $fark = "";
                                                if ($interval->format('%a') > 0) {
                                                    $fark = " - " . $interval->format('%a ' . langS(274, 2,$this->input->post("lang")) . " " . langS(274, 2,$this->input->post("lang")));
                                                } else {
                                                    $fark = " - " . langS(275, 2,$this->input->post("lang"));
                                                }
                                                if ($item->type == 1) {
                                                    $str .= '<li class="clearfix">
                                                <div class="message-data">';
                                                    if($satici->image==""){
                                                        $str.='<img src="' . base_url("assets/images/profilepic.png") . '" alt="avatar">';
                                                    }else{
                                                        $str.='<img src="' . base_url("upload/users/".$satici->image) . '" alt="avatar">';
                                                    }

                                                    $str.='<span class="message-data-time">' . date("H:i", strtotime($item->created_at)) . $fark . '</span>
                                                </div>';
                                                    if($item->is_deleted==0){
                                                        $str.='<div class="message my-message">' . $item->message . '</div></li>';
                                                    }else{
                                                        $str.='<div style="background-color: #d7144a;" class="message my-message">'.langS(346,2,$this->input->post("lang")).'</div>';
                                                    }
                                                } else {
                                                    $str .= '<li class="clearfix">
                                                <div class="message-data text-right">
                                                    <span class="message-data-time">' . date("H:i", strtotime($item->created_at)) . $fark . '</span>';
                                                    if($user->image==""){
                                                        $str.='<img src="' . base_url("assets/images/profilepic.png") . '" alt="avatar">';
                                                    }else{
                                                        $str.='<img src="' . base_url("upload/users/".$user->image) . '" alt="avatar">';
                                                    }
                                                $str.='</div>';
                                                    if($item->is_deleted==0){
                                                        $str.='<div class="message other-message float-right">' . $item->message . '</div>';
                                                    }else{
                                                        $str.='<div style="background-color: #d7144a;" class="message other-message float-right">'.langS(346,2,$this->input->post("lang")).'</div>';
                                                    }
                                                    $str.='</li>';
                                                }
                                            }
                                            echo json_encode(array("veri" => $str, "status" => $kkontrol->status));
                                        } else {
                                            echo json_encode(array("err" => true, "message" => "sendis"));
                                        }
                                    }else{
                                        echo json_encode(array("err" => true, "message" => "none"));
                                    }
                                }
                            }else{
                                echo json_encode(array("err" => true, "message" => "oturum"));
                            }
                        } else {
                            echo json_encode(array("err" => true, "message" => "oturum"));
                        }
                    } else {
                        header('Content-Type: application/json');
                        if ($this->input->post("talep") && $this->input->post("mesaj")) {
                            $talep = $this->security->xss_clean($this->input->post("talep"));
                            $mesaj = $this->security->xss_clean($this->input->post("mesaj"));
                            $kkontrol = $this->m_tr_model->getTableSingle("table_orders_adverts", array("sipNo" => $talep,"user_id"  => $user->id));
                            if ($kkontrol) {

                                if ($kkontrol->status != 0 ) {
                                    $kontrolAds=getTableSingle("table_adverts",array("id" => $kkontrol->advert_id));
                                    $sorgula = $this->m_tr_model->getTableOrder("table_orders_adverts_message", array("advert_id" => $kkontrol->advert_id), "id", "desc");
                                    if ($sorgula) {
                                        $s=0;
                                        foreach ($sorgula as $ss) {
                                            if ($s <= 3) {
                                                if ($ss->type != 1) {
                                                    $us++;
                                                }
                                            }
                                            $s++;
                                        }

                                        if ($us < 3) {
                                            $yasakli=0;
                                            if(ClearText($mesaj)==true){
                                                $yasakli=1;
                                            }else{
                                                $yasakli=0;
                                            }
                                            $sorgu=getTableSingle("table_orders_adverts_message",array("advert_id" =>$kkontrol->advert_id,"type" => 2,"buyer_id" => $user->id));
                                            $kaydet = $this->m_tr_model->add_new(array(
                                                "advert_id" => $kkontrol->advert_id,
                                                "buyer_id" => $user->id,
                                                "seller_id" => $kkontrol->sell_user_id,
                                                "type" => 2,
                                                "message" => $mesaj,
                                                "is_deleted" => $yasakli,
                                                "created_at" => date("Y-m-d H:i:s")
                                            ), "table_orders_adverts_message");
                                            if ($kaydet) {
                                                if($yasakli==0){
                                                    if(!$sorgu){
                                                        $ayarCek=getTableSingle("table_options_sms",array("id" => 1));
                                                        if($ayarCek->modul_aktif==1){
                                                            $sablon=getTableSingle("table_lang_sms_mail",array("order_id" => 4,"lang_id" => $_SESSION["lang"]));
                                                            try {
                                                                $alici=getTableSingle("table_users",array("id" => $kkontrol->sell_user_id));
                                                                $this->load->helper("netgsm_helper");
                                                                $smsG=str_replace("{sipno}",$kkontrol->sipNo,$sablon->value);
                                                                $smsG=str_replace("satıcıdan","alıcıdan",str_replace("{satici}",$user->nick_name,$smsG));
                                                                $smsBilgi=smsGonder($alici->phone,$smsG." - B".rand(1000,9999));
                                                            }catch (Exception $ex){
                                                                $smsBilgi="Sms Gönderilirken Hata meydana geldi";
                                                            }
                                                        }else{
                                                            $smsBilgi="Modül Pasif";
                                                        }
                                                    }
                                                    $ayarCek=getTableSingle("table_options_sms",array("id" => 1));
                                                    $alici=getTableSingle("table_users",array("id" => $kkontrol->sell_user_id));
                                                    $mailGonder=email_gonder($alici->email,$kkontrol->sipNo." No'lu İlan Sipariş Tesliminiz için alıcıdan yeni mesajınız var.","","",1,base_url("temp-mail/8/test/".$alici->id."/".$kkontrol->sipNo));
                                                    $bildirimEkle=$this->m_tr_model->add_new(array(
                                                        "user_id" => $alici->id,
                                                        "noti_id" => 17,
                                                        "type" => 1,
                                                        "created_at" => date("Y-m-d H:i:s"),
                                                        "advert_id" => $kkontrol->advert_id,"order_id" => $kkontrol->id,
                                                    ),"table_notifications_user");
                                                    addLog("Alıcı Canlı Sohbetten Mesaj Gönderdi", $kkontrol->sipNo." no'lu '".$kontrolAds->ad_name."' adlı ilan siparişinin onayı için alıcı tarafından canlı sohbet üzerinden mesaj gönderildi. Mesaj : ".$mesaj, 1);
                                                }
                                                echo json_encode(array("err" => false,"yasakli" => $yasakli,"message" => langS(278, 2,$this->input->post("lang"))));
                                            } else {
                                                echo json_encode(array("err" => true, "message" => langS(38, 2,$this->input->post("lang"))));
                                            }
                                        } else {
                                            echo json_encode(array("err" => true, "message" => langS(345,2,$this->input->post("lang"))));
                                        }
                                    }else{
                                        $yasakli=0;
                                        if(ClearText($mesaj)){
                                            $yasakli=1;
                                        }else{
                                            $yasakli=0;
                                        }
                                        $kaydet = $this->m_tr_model->add_new(array(
                                            "advert_id" => $kkontrol->advert_id,
                                            "buyer_id" => $user->id,
                                            "seller_id" => $kkontrol->sell_user_id,
                                            "type" => 2,
                                            "message" => $mesaj,
                                            "is_deleted" => $yasakli,
                                            "created_at" => date("Y-m-d H:i:s")
                                        ), "table_orders_adverts_message");
                                        if ($kaydet) {
                                            if($yasakli==0){
                                                $ayarCek=getTableSingle("table_options_sms",array("id" => 1));
                                                if($ayarCek->modul_aktif==1){
                                                    $sablon=getTableSingle("table_lang_sms_mail",array("order_id" => 3,"lang_id" => $_SESSION["lang"]));
                                                    try {
                                                        $alici=getTableSingle("table_users",array("id" => $kkontrol->sell_user_id));
                                                        $this->load->helper("netgsm_helper");
                                                        $smsG=str_replace("{sipno}",$kkontrol->sipNo,$sablon->value);
                                                        $smsG=str_replace("satıcıdan","alıcıdan",str_replace("{satici}",$user->nick_name,$smsG));
                                                        $smsBilgi=smsGonder($alici->phone,$smsG." - B".rand(1000,9999));
                                                    }catch (Exception $ex){
                                                        $smsBilgi="Sms Gönderilirken Hata meydana geldi";
                                                    }
                                                }else{
                                                    $smsBilgi="Modül Pasif";
                                                }
                                                $mailGonder=email_gonder($alici->email,$kkontrol->sipNo." No'lu Siparişinizle alakalı alıcıdan yeni mesajınız var.","","",1,base_url("temp-mail/8/test/".$alici->id."/".$kkontrol->sipNo));
                                                $bildirimEkle=$this->m_tr_model->add_new(array(
                                                    "user_id" => $alici->id,
                                                    "noti_id" => 17,
                                                    "type" => 1,
                                                    "created_at" => date("Y-m-d H:i:s"),
                                                    "advert_id" => $kkontrol->advert_id,
                                                    "order_id" => $kkontrol->id,
                                                ),"table_notifications_user");
                                                $guncelle=$this->m_tr_model->updateTable("table_orders_adverts_message",array("sms_control" => $smsBilgi,"mail_control" => $mailGonder),array("id" => $kaydet));
                                                addLog("Alıcı Canlı Sohbetten Mesaj Gönderdi", $kkontrol->sipNo." no'lu '".$kontrolAds->ad_name."' adlı ilanınızın onayı için alıcı tarafından canlı sohbet üzerinden mesaj gönderildi. Mesaj : ".$mesaj, 1);
                                            }
                                            echo json_encode(array("err" => false,"yasakli" => $yasakli,"message" => langS(278, 2,$this->input->post("lang"))));
                                        } else {
                                            echo json_encode(array("err" => true, "message" => langS(38, 2,$this->input->post("lang"))));
                                        }
                                    }
                                }else{
                                    echo json_encode(array("err" => true, "message" => "none"));
                                }
                            } else {
                                echo json_encode(array("err" => true, "message" => "oturum"));
                            }
                        }
                    }

                } else {
                    header('Content-Type: application/json');
                    echo json_encode(array("err" => true, "message" => "oturum"));
                }
            } else {
                addLog("Saldırı Uygulandı.", "orderMessageAdd", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "orderMessageAdd", 3);
        }
    }

    public function addSendCode(){
        if ($_POST) {
            $this->load->model("m_tr_model");
            header('Content-Type: application/json');
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                $user = getActiveUsers();
                if ($user) {
                    $order_id=$this->security->xss_clean($this->input->post("sipNo"));
                    if($order_id){
                        $kontrol=getTableSingle("table_orders_adverts",array("sipNo" => $order_id,"status" => 1,"user_id" => $user->id ));
                        if($kontrol){
                            if($this->input->post("types")){
                                if($kontrol->onay_mail_status==0 && $kontrol->onay_mail_code!=""){
                                    $kod= $this->security->xss_clean($this->input->post("kod"));
                                    if($kod && strlen($kod)==6){
                                        if($kod==$kontrol->onay_mail_code){
                                            $at=date("Y-m-d H:i:s");
                                            $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array(
                                                "onay_mail_status" =>  1,
                                                "status" => 3,
                                                "onay_at" => $at,
                                                "admin_onay_at" => $at,
                                                "onay_lang" => $_SESSION["lang"],
                                                "onay_mail_date"  =>  date("Y-m-d H:i:s")
                                            ),array("id" => $kontrol->id));
                                            if($guncelle){
                                                $alici=$this->m_tr_model->getTableSingle("table_users",array("id" => $kontrol->user_id));
                                                $advert=getTableSingle("table_adverts",array("id" => $kontrol->advert_id));
                                                $satici=getTableSingle("table_users",array("id" => $kontrol->sell_user_id));
                                                $cekAyar =$this->m_tr_model->getTableSingle("table_options", array("id" => 1));
                                                $cekAyarSms =$this->m_tr_model->getTableSingle("table_options_sms", array("id" => 1));

                                                $kazancKaydet=$this->m_tr_model->add_new(array(
                                                    "user_id" => $kontrol->sell_user_id,
                                                    "advert_id" =>  $kontrol->advert_id,
                                                    "order_id" => $kontrol->id,
                                                    "is_blocked" => 0,
                                                    "confirm_date" => date("Y-m-d H:i:s"),
                                                    "created_at" => date("Y-m-d H:i:s"),
                                                    "unblocked_at" =>   date("Y-m-d H:i:s"),
                                                    "price" => $advert->price,
                                                    "cash_price" => $advert->sell_price,
                                                    "commission" => ($advert->price-$advert->sell_price)
                                                ),"table_users_ads_cash");

                                                if($kazancKaydet){
                                                    $logEkle=$this->m_tr_model->add_new(array(
                                                        "date" => date("Y-m-d H:i:s"),
                                                        "status" => 5,
                                                        "order_id" => $kontrol->id,
                                                        "advert_id" => $kontrol->advert_id,
                                                        "mesaj_title" => "Satıcıya Bakiye Aktarıldı. Otomatik Teslimat",
                                                        "mesaj" => $kontrol->sipNo." No'lu İlan Sipariş için Satıcıya Bakiye Kazancı eklendi."
                                                    ),"bk_logs");
                                                    $user=$this->m_tr_model->getTableSingle("table_users",array("id" => $satici->id,"status" => 1));
                                                    $ekle=$user->ilan_balance +  $advert->sell_price;
                                                    $gunUser=$this->m_tr_model->updateTable("table_users",array("ilan_balance" => $ekle),array("id" => $user->id));
                                                    $mailBilgiAlici="Mail Gönderilemedi";
                                                    $mailBilgiSatici="Mail Gönderilemedi";
                                                    $previzyonKaldir=$this->m_tr_model->updateTable("table_users_balance_history",
                                                        array("status" => 2,"update_at" => date("Y-m-d H:i:s")),
                                                        array("advert_id" => $kontrol->advert_id,"order_id" => $kontrol->id,"status" => 1,"user_id" => $alici->id));

                                                    $mailGonder = email_gonder($satici->email, $kontrol->sipNo . " Sipariş No'lu İlan Satışınız Alıcı Tarafından Onaylandı...", "", "", 2, base_url()."temp-mail/15/test/" . $advert->user_id . "/" . $kontrol->sipNo);
                                                    if($mailGonder==1){ $mailBilgiSatici="Mail Başarılı Şekilde Gönderildi."; }else{ $mailBilgiSatici="Mail Gönderilemedi."; }


                                                    $mailGonder = email_gonder($alici->email, $kontrol->sipNo . " Sipariş No'lu İlan Siparişiniz Başarılı Şekilde Tamamlandı..", "", "", 2, base_url()."temp-mail/16/test/" . $kontrol->user_id . "/" . $kontrol->sipNo);
                                                    if($mailGonder==1){ $mailBilgiAlici="Mail Başarılı Şekilde Gönderildi."; }else{ $mailBilgiAlici="Mail Gönderilemedi."; }
                                                    $smsBilgiSatici="Modül Aktif Değil.";
                                                    $smsBilgiAlici="Modül Aktif Değil.";


                                                }else{
                                                    $logEkle=$this->m_tr_model->add_new(array(
                                                        "date" => date("Y-m-d H:i:s"),
                                                        "status" => 6,
                                                        "order_id" => $kontrol->id,
                                                        "advert_id" => $kontrol->advert_id,
                                                        "mesaj_title" => "Satıcıya Bakiye Aktarılırken Kritik Hata",
                                                        "mesaj" => $kontrol->sipNo." No'lu İlan Sipariş için Satıcıya Bakiye Kazancı eklenirken kritik hata meydana geldi."
                                                    ),"bk_logs");
                                                }



                                                $dil=getLangValue($kontrol->advert_id,"table_adverts",1);
                                                $ad="";
                                                if($dil->name==""){
                                                    $ad=$advert->ad_name;
                                                }else{
                                                    $ad=$dil->name;
                                                }

                                                /*if($cekAyar->modul_aktif==1){
                                                    if($satici->phone!=""){
                                                        try {

                                                            $cekSablon=getTableSingle("table_lang_sms_mail",array("order_id" => 5,"lang_id" => $_SESSION["lang"]));
                                                            $this->load->helper("netgsm_helper");
                                                            $dil=getLangValue($kontrol->advert_id,"table_adverts",$this->input->post("lang"));
                                                            $ad="";
                                                            if($dil->name==""){
                                                                $ad=$advert->ad_name;
                                                            }else{
                                                                $ad=$dil->name;
                                                            }
                                                            $smsSablon=str_replace("{name}",kisalt($ad,20),$cekSablon->value);
                                                            $smsSablon=str_replace("{sipno}",$kontrol->sipNo,$smsSablon);
                                                            $smsSablon=str_replace("{alici}",$user->nick_name,$smsSablon);
                                                            $sms=smsGonder($satici->phone,$smsSablon." - B-".rand(100,999));
                                                        }catch (Exception $ex){

                                                        }
                                                    }
                                                }
                                                $mailGonder=email_gonder($satici->email,$kontrol->sipNo." Sipariş No'lu İlanınızın Teslimatı Alıcı Tarafından Onaylandı.","","",1,base_url("temp-mail/10/test/".$satici->id."/".$kontrol->sipNo));
                                                $bildirimEkle=$this->m_tr_model->add_new(array(
                                                    "user_id" => $kontrol->sell_user_id,
                                                    "noti_id" => 18,
                                                    "type" => 1,
                                                    "created_at" => date("Y-m-d H:i:s"),
                                                    "advert_id" => $kontrol->advert_id,"order_id" => $kontrol->id,
                                                ),"table_notifications_user");*/
                                                addLog("İlan Siparişi Alıcı Tarafından Onaylandı.", $alici->nick_name."adlı üye, #".$kontrol->sipNo." nolu ".$ad." adlı ilan siparişinin teslimatını onayladı. Sipariş Tamamlandı", 1);
                                                $veri=str_replace("{tarih}","<b  style='color:#d5cece;font-weight: 700'>".$at."</b>",langS(359,2,$this->input->post("lang")));
                                                echo json_encode(array("err" => false,"messsageThree" => $veri ));
                                            }
                                        }else{
                                            echo json_encode(array("err" => true,"message" =>langS(165,2,$this->input->post("lang"))));
                                        }
                                    }else{
                                        echo json_encode(array("err" => true,"message" => langS(171,2,$this->input->post("lang"))));
                                    }
                                }else{
                                    echo json_encode(array("err" => true,"message" => 3));
                                }
                            }else{
                                $token=tokengenerator(6,2);
                                if($kontrol->onay_mail_status==0 && $kontrol->onay_mail_code==""){
                                    $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array(
                                        "onay_mail_code" => $token,
                                        "onay_mail_date" => date("Y-m-d H:i:s")
                                    ),array("id" => $kontrol->id));
                                    if($guncelle){
                                        $mailGonder=email_gonder($user->email,$kontrol->sipNo." No'lu İlan Siparişi Onay Kodu.","","",1,base_url("temp-mail/9/test/".$user->id."/".$kontrol->sipNo));
                                        if($mailGonder=="1"){
                                            addLog("İlan Sipariş Onay Kodu Gönderildi.", $kontrol->sipNo." no'lu siparişe ait  ".$user->nick_name." adlı üyeye ilan siparişi onayı için ".$user->email." mail adresine ".$token." kod gönderildi.", 1);
                                            echo json_encode(array("err" => false));
                                        }else{
                                            $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array(
                                                "onay_mail_code" => "",
                                                "onay_mail_date" => ""
                                            ),array("id" => $kontrol->id));
                                            addLog("İlan Sipariş Onay Kodu Mail Gönderim Hatası.",  $kontrol->sipNo." no'lu siparişe ait  ".$user->nick_name." adlı üyeye ilan siparişi onayı için ".$user->email." mail adresine ".$token." kod gönderilirken hata meydana geldi", 1);
                                            echo json_encode(array("err" => true,"message" => langS(356,2,$this->input->post("lang"))));
                                        }
                                    }else{
                                        addLog("İlan sipariş Onay Mail Kayıt Hatası", $user->nick_name." adlı üye ilan siparişini onayı sırasında kayıt aşamasında beklenmedik bir hata meydana geldi.", 2);
                                    }
                                }else{
                                    $tarih = $kontrol->onay_mail_date;
                                    $newDate = strtotime('10 minutes', strtotime($tarih));
                                    if ($newDate > strtotime(date("Y-m-d H:i:s"))) {
                                        echo json_encode(array("err" => "aktif", "message" => langS(357, 2,$this->input->post("lang"))));
                                    } else {
                                        $token=tokengenerator(6,2);
                                        $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array(
                                            "onay_mail_code" => $token,
                                            "onay_mail_date" => date("Y-m-d H:i:s")
                                        ),array("id" => $kontrol->id));
                                        if($guncelle){
                                            $mailGonder=email_gonder($user->email,$kontrol->sipNo." No'lu İlan Siparişi Onay Kodu.","","",1,base_url("temp-mail/9/test/".$user->id."/".$kontrol->sipNo));
                                            if($mailGonder=="1"){
                                                addLog("İlan Sipariş Onay Kodu Gönderildi.", $user->nick_name." adlı üyeye ilan siparişi onayı için ".$user->email." mail adresine ".$token." kod gönderildi.", 1);
                                                echo json_encode(array("err" => false));
                                            }else{
                                                $guncelle=$this->m_tr_model->updateTable("table_orders_adverts",array(
                                                    "onay_mail_code" => "",
                                                    "onay_mail_date" => ""
                                                ),array("id" => $kontrol->id));
                                                addLog("İlan Sipariş Onay Kodu Mail Gönderim Hatası.", $user->nick_name." adlı üyeye ilan siparişi onayı için ".$user->email." mail adresine ".$token." kod gönderilirken hata meydana geldi", 1);
                                                echo json_encode(array("err" => true,"message" => langS(356,2,$this->input->post("lang"))));
                                            }
                                        }else{
                                            addLog("İlan sipariş Onay Mail Kayıt Hatası", $user->nick_name." adlı üye ilan siparişini onayı sırasında kayıt aşamasında beklenmedik bir hata meydana geldi.", 2);
                                        }
                                    }
                                }
                            }
                        }else{
                            echo json_encode(array("err" => true, "message" => "oturum"));
                        }
                    }else{
                        echo json_encode(array("err" => true, "message" => "oturum"));
                    }
                }else{
                    echo json_encode(array("err" => true, "message" => "oturum"));
                }
            }else{
                addLog("Saldırı Uygulandı.", "addSendCode", 3);
            }
        }else{
            addLog("Saldırı Uygulandı.", "addSendCode", 3);
        }
    }


}


