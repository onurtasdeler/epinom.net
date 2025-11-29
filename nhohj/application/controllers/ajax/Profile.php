<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

    public $viewFile = "";
    public $viewFolder = "";
    public $kontrolSession = "";

    public function __construct()
    {

        parent::__construct();
        $this->load->library("form_validation");

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

    //ilanlar ajax liste
    public function getListeMyAds()
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
                            if ($this->input->post("orders")) {
                                $sirala = $this->security->xss_clean($this->input->post("orders"));
                                if ($sirala == 1) {
                                    $sirala = " order by created_at desc";
                                } else if ($sirala == 2) {
                                    $sirala = " order by created_at asc";
                                } else if ($sirala == 3) {
                                    $sirala = " order by price asc";
                                } else if ($sirala == 4) {
                                    $sirala = " order by price desc";
                                }
                            } else {
                                $sirala = " order by created_at desc";
                            }
                            if ($this->input->post("types") == 1) {
                                $status = 0;
                            } else if ($this->input->post("types") == 2) {
                                $status = 1;
                            } else if ($this->input->post("types") == 3) {
                                $status = 3;
                            } else if ($this->input->post("types") == 4) {
                                $status = 4;
                            }else if ($this->input->post("types") == 5) {
                                $status = 2;
                            }


                            if ($ad != "") {
                                if($status==1){
                                    $cek = $this->m_tr_model->query("select * from table_adverts where user_id=".$user->id." and (status=1 or (status=4 and type=1))");
                                }else if($status==4){
                                    $cek = $this->m_tr_model->query("select * from table_adverts where user_id=".$user->id." and (status=4 or status=6)");
                                }else{
                                    $cek = getTable("table_adverts", array("user_id" => $user->id, "status" => $status, "deleted" => 0));

                                }
                                if ($cek) {
                                    foreach ($cek as $item) {
                                        $pars = json_decode($item->field_data);
                                        foreach ($pars as $par) {
                                            if ($par->lang_id == $this->input->post("lang")) {
                                                if (stristr($par->name, $ad)) {
                                                    $bulunanlar[] = $item->id;
                                                }
                                            }
                                        }

                                    }
                                }
                                if ($bulunanlar) {
                                    $toplam = count($bulunanlar);
                                } else {

                                    $pars = json_decode($item->field_data);
                                    foreach ($pars as $par) {
                                        if ($par->lang_id != $this->input->post("lang")) {
                                            if (stristr($par->name, $ad)) {
                                                $bulunanlar[] = $item->id;
                                            }
                                        }
                                    }
                                    if($bulunanlar){
                                        $toplam = count($bulunanlar);

                                    }else{
                                        $toplam = 0;
                                    }
                                }
                                if($status==1){
                                    $ara = $this->m_tr_model->query("select count(*) as say from table_adverts where ilanNo like '%" . $ad . "%' or user_id=" . $user->id . " and deleted=0 and (status = 1 or (status=4 and type=1)) " . $sirala);
                                }else if($status==4){
                                    $ara = $this->m_tr_model->query("select count(*) as say from table_adverts where ilanNo like '%" . $ad . "%' or user_id=" . $user->id . " and deleted=0 and (status = 4 or status=6) " . $sirala);
                                }else{
                                    $ara = $this->m_tr_model->query("select count(*) as say from table_adverts where ilanNo like '%" . $ad . "%' or user_id=" . $user->id . " and deleted=0 and status = " . $status . $sirala);

                                }
                                $toplam = $toplam + $ara[0]->say;
                            } else {
                                if($status==1){
                                    $toplam = $this->m_tr_model->query("select count(*) as say from table_adverts where user_id=" . $user->id . " and deleted=0 and (status=1 or (status=4 and type=1)) ". $ad);
                                }else if($status==4){
                                    $toplam = $this->m_tr_model->query("select count(*) as say from table_adverts where user_id=" . $user->id . " and deleted=0 and (status=4 or status=6) ". $ad);
                                }else{
                                    $toplam = $this->m_tr_model->query("select count(*) as say from table_adverts where user_id=" . $user->id . " and deleted=0 and status=" . $status . $ad);
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
                                        $ilanlar = $this->m_tr_model->query("select * from table_adverts where ( id in (" . $verilers . ") or ilanNo like '%" . $ad . "%' ) and deleted=0 and user_id=" . $user->id . " and (status=1 or (status=4 and type=1))". $sirala . " limit " . $limit . ",10");
                                    }else if($status==4){
                                        $ilanlar = $this->m_tr_model->query("select * from table_adverts where ( id in (" . $verilers . ") or ilanNo like '%" . $ad . "%' ) and deleted=0 and user_id=" . $user->id . " and (status=4 or status=6)". $sirala . " limit " . $limit . ",10");
                                    }else{
                                        $ilanlar = $this->m_tr_model->query("select * from table_adverts where ( id in (" . $verilers . ") or ilanNo like '%" . $ad . "%' ) and deleted=0 and user_id=" . $user->id . " and status = " . $status . $sirala . " limit " . $limit . ",10");
                                    }
                                } else {
                                    if ($ad != "") {
                                        if($status==1){
                                            $ilanlar = $this->m_tr_model->query("select * from table_adverts where ilanNo like '%" . $ad . "%' and user_id=" . $user->id . " and deleted=0 and (status =1 or (status=4 and type=1)) "  . $sirala . " limit " . $limit . ",10");
                                        }else  if($status==4){
                                            $ilanlar = $this->m_tr_model->query("select * from table_adverts where ilanNo like '%" . $ad . "%' and user_id=" . $user->id . " and deleted=0 and (status =4 or status=6) "  . $sirala . " limit " . $limit . ",10");
                                        }else{
                                            $ilanlar = $this->m_tr_model->query("select * from table_adverts where ilanNo like '%" . $ad . "%' and user_id=" . $user->id . " and deleted=0 and status = " . $status . $sirala . " limit " . $limit . ",10");
                                        }
                                    } else {
                                        if($status==1){
                                            $ilanlar = $this->m_tr_model->query("select * from table_adverts where  user_id=" . $user->id . " and deleted=0 and (status = 1 or (status=4 and type=1)) "  . $sirala . " limit " . $limit . ",10");
                                        }else if($status==4){
                                            $ilanlar = $this->m_tr_model->query("select * from table_adverts where  user_id=" . $user->id . " and deleted=0 and (status = 4 or status=6) "  . $sirala . " limit " . $limit . ",10");
                                        }else{
                                            $ilanlar = $this->m_tr_model->query("select * from table_adverts where  user_id=" . $user->id . " and deleted=0 and status = " . $status . $sirala . " limit " . $limit . ",10");

                                        }
                                    }
                                }

                                if ($ilanlar) {
                                    foreach ($ilanlar as $value) {
                                        $ll = getLangValue($value->id, "table_adverts",$this->input->post("lang"));
                                        $str .= '<div class="box boyutlaIlan">
                                                        <!--<div class="order-menu"  style="top:10px;" data-id="ul_' . $value->id . '">
                                                            <small >
                                                                <i class="mdi mdi-dots-vertical"></i>
                                                            </small>
                                                            <ul id="ul_' . $value->id . '">
                                                                <li><a href="#">Düzenle</a></li>
                                                                <li><a href="#">Sil</a></li>
                                                            </ul>
                                                        </div>-->';


                                        $cek=$this->m_tr_model->getTableSingle("table_adverts_upload_image",array("sira" => 1 ,"adverts_id" =>$value->id));
                                        if($cek){
                                            if($cek->image!=""){
                                                $str .= '<img src="' . base_url("upload/ilanlar_users/".$cek->image) . '"
                                                             alt="">';
                                            }else{
                                                if ($value->selected_image) {
                                                    $parResim = explode(",", $value->selected_image);

                                                    foreach ($parResim as $par) {
                                                        $cekKategoriResim = getTableSingle("table_adverts_image", array("status" => 1, "id" => $par));
                                                        if ($cekKategoriResim) {
                                                            $str .= '<img src="' . base_url("upload/ilanlar/default/" . $cekKategoriResim->image) . '"
                                                             alt="">';
                                                        } else {
                                                            $str .= '<img src="' . base_url("assets/images/noimage.jpeg") . '"
                                                             alt="">';
                                                        }
                                                    }
                                                }else{
                                                    $str .= '<img src="' . base_url("assets/images/noimage.jpeg") . '"
                                                             alt="">';
                                                }

                                            }

                                        }else{
                                            if ($value->selected_image) {
                                                $parResim = explode(",", $value->selected_image);

                                                foreach ($parResim as $par) {
                                                    $cekKategoriResim = getTableSingle("table_adverts_image", array("status" => 1, "id" => $par));
                                                    if ($cekKategoriResim) {
                                                        $str .= '<img src="' . base_url("upload/ilanlar/default/" . $cekKategoriResim->image) . '"
                                                             alt="">';
                                                    } else {
                                                        $str .= '<img src="' . base_url("assets/images/noimage.jpeg") . '"
                                                             alt="">';
                                                    }
                                                }
                                            }else{
                                                $str .= '<img src="' . base_url("assets/images/noimage.jpeg") . '"
                                                             alt="">';
                                            }
                                        }



                                        $useragent = $_SERVER['HTTP_USER_AGENT'];

                                        $mobil = 0;
                                        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
                                            $mobil = 1;
                                        }
                                        $n = "";
                                        if ($mobil == 1) {
                                            if($ll->name!=""){
                                                $n = kisalt($ll->name,36);
                                            }else{
                                                $n=kisalt($value->ad_name,36);
                                            }
                                        } else {
                                            if($ll->name!=""){
                                                $n = kisalt($ll->name, 65);
                                            }else{
                                                $n=kisalt($value->ad_name,65);
                                            }

                                        }
                                        $str .= '<div class="right">
                
                                                    <h5>' . $n . '<span
                                                style="color: #c5c5c5;font-size: 8pt;"> -  #' . $value->ilanNo . '</span>
                                                </h5>';
                                        $ilanPage = getLangValue(36, "table_pages",$this->input->post("lang"));
                                        if ($status == 2) {
                                            if ($mobil == 1) {
                                                $str .= ' <div class="kategoriGosterim"
                                                     style=" display: flex; padding-bottom: 6px; justify-content: start">
                                                     <div class="date">
                                                        ' . date("Y-m-d H:i:s", strtotime($value->created_at)) . '
                                                    </div>
                                                    
                                                </div>
                                                ';
                                            } else {
                                                $str .= ' <div class="kategoriGosterim"
                                                     style=" display: flex; padding-bottom: 6px; justify-content: start">
                                                    <div class="aciklamaGosterim bg-danger"
                                                         style="width: auto; padding-left: 10px; padding-right: 10px; line-height: 25px; color: white; height: 25px; border-radius: 20px;">
                                                       ' . langS(206, 2,$this->input->post("lang")) . ' - ' . $value->red_nedeni . ' / ' . langS(241, 2,$this->input->post("lang")) . ' : ' . date("Y-m-d H:i:s", strtotime($value->red_at)) . '
                                                    </div>
                                                    
                                                </div>
                                                ';
                                            }

                                            $str .= ' 
                                                    </div>
                                                    <a href="' . base_url(gg() . $ilanPage->link . "/" . mb_strtolower($value->ilanNo)) . '" class="detail"><i class="mdi mdi-pencil"></i> ' . langS(221, 2,$this->input->post("lang")) . '</a></div>';
                                        } else if ($status == 1) {
                                            if ($value->is_doping == 1) {
                                                $dopingCek = getTableSingle("table_adverts_dopings_users", array("advert_id" => $value->id, "status" => 1));
                                                if ($dopingCek) {
                                                    $dopingMain = getTableSingle("table_adverts_dopings", array("id" => $dopingCek->doping_id));
                                                    if ($dopingMain) {
                                                        if ($dopingCek->end_date > date("Y-m-d H:i:s")) {
                                                            $fark = saat_farki($dopingCek->end_date);
                                                            if ($fark["gun_farki"] != 0) {
                                                                $kalan = $fark["gun_farki"] . langS(93, 2,$this->input->post("lang")) . " " . $fark["saat_farki"] . " " . langS(122, 2,$this->input->post("lang"));
                                                            } else {
                                                                $kalan = $fark["saat_farki"] . " " . langS(122, 2,$this->input->post("lang"));
                                                            };
                                                        }
                                                    }
                                                }


                                            }

                                            if ($mobil == 1) {
                                                if($value->type==1) {
                                                    $say = count(explode(PHP_EOL, $value->stocks));
                                                    $str .= ' <div><span class="badge badge-primary adetKalan"><i class="mdi mdi-check"></i> ' . langS(387, 2,$this->input->post("lang")) . ' ' . $say . '</span>    </div>
                                                    <div class="date">
                                                        ' . date("Y-m-d H:i:s", strtotime($value->created_at)) . '
                                                    </div>
                                                </div><a href="' . base_url(gg($this->input->post("lang")) . $ilanPage->link . "/" . mb_strtolower($value->ilanNo)) . '" class="detail"><i class="mdi mdi-pencil"></i> ' . langS(221, 2,$this->input->post("lang")) . '</a></div>';
                                                }else{
                                                    $cekVitrin=getTableSingle("table_adverts_dopings_users",array("status" => 1,"advert_id" => $value->id,"user_id" => $user->id));
                                                    if($cekVitrin){
                                                        $date=str_replace("{date}","<b style='color:#393939'>".date("Y-m-d H:i",strtotime($cekVitrin->end_date))."</b>",langS(412,2,$this->input->post("lang")));
                                                        $str.='<div>
                                                        <span class="badge badge-success onecikan"><i class="mdi mdi-star"></i>'.$date.'</span>    
                                                        </div>';
                                                    }
                                                    $str .= '
                                                    <div class="date">
                                                        ' . date("Y-m-d H:i:s", strtotime($value->created_at)) . '
                                                    </div>
                                                </div><a href="' . base_url(gg($this->input->post("lang")) . $ilanPage->link . "/" . mb_strtolower($value->ilanNo)) . '" class="detail"><i class="mdi mdi-pencil"></i> ' . langS(221, 2,$this->input->post("lang")) . '</a></div>';
                                                }

                                            } else {
                                                $str .= '<div class="price">' . langS(70, 2,$this->input->post("lang")) . ': ' . (floor($value->price*100)/100) . ' ' . getcur();
                                                if($value->type==1){
                                                    $say=count(explode(PHP_EOL,$value->stocks));
                                                    $str .= ' </span> <span class="badge badge-primary adetKalan"><i class="mdi mdi-check"></i> '.langS(387,2,$this->input->post("lang")).' '.$say.'</span>    </div>
                                                    <div class="date">
                                                        ' . date("Y-m-d H:i:s", strtotime($value->created_at)) . '
                                                    </div>
                                                </div>
                                                
                                                <a href="' . base_url(gg() . $ilanPage->link . "/" . mb_strtolower($value->ilanNo)) . '" class="detail"><i class="mdi mdi-pencil"></i> ' . langS(221, 2,$this->input->post("lang")) . '</a></div>';
                                                }else{
                                                    $str .= ' </span> </div>';
                                                    $cekVitrin=getTableSingle("table_adverts_dopings_users",array("status" => 1,"advert_id" => $value->id,"user_id" => $user->id));
                                                    if($cekVitrin){
                                                        $date=str_replace("{date}","<b style='color:#393939'>".date("Y-m-d H:i",strtotime($cekVitrin->end_date))."</b>",langS(412,2,$this->input->post("lang")));
                                                        $str.='<div>
                                                        <span class="badge badge-success onecikan"><i class="mdi mdi-star"></i>'.$date.'</span>    
                                                        </div>';
                                                    }


                                                    $str.='<div class="date">
                                                        ' . date("Y-m-d H:i:s", strtotime($value->created_at)) . '
                                                    </div>
                                                </div>
                                               
                                                <a href="' . base_url(gg($this->input->post("lang")) . $ilanPage->link . "/" . mb_strtolower($value->ilanNo)) . '" class="detail"><i class="mdi mdi-pencil"></i> ' . langS(221, 2,$this->input->post("lang")) . '</a></div>';
                                                }

                                            }


                                        } else {

                                            $useragent = $_SERVER['HTTP_USER_AGENT'];
                                            $mobil = 0;
                                            if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
                                                $mobil = 1;
                                            }

                                            if ($mobil == 1) {
                                                if($value->type==1){
                                                    $say = count(explode(PHP_EOL, $value->stocks));
                                                    $str .= '<span class="badge badge-primary adetKalan"><i class="mdi mdi-check"></i> ' . langS(387, 2,$this->input->post("lang")) . ' ' . $say . '</span>  
                                                    <div class="date">
                                                        ' . date("Y-m-d H:i:s", strtotime($value->created_at)) . '
                                                    </div>
                                                </div>
                                                <a href="' . base_url(gg($this->input->post("lang")) . $ilanPage->link . "/" . mb_strtolower($value->ilanNo)) . '" class="detail"><i class="mdi mdi-pencil"></i> ' . langS(221, 2,$this->input->post("lang")) . '</a></div>';
                                                }else{
                                                    $str .= '
                                                    <div class="date">
                                                        ' . date("Y-m-d H:i:s", strtotime($value->created_at)) . '
                                                    </div>
                                                </div><a href="' . base_url(gg($this->input->post("lang")) . $ilanPage->link . "/" . mb_strtolower($value->ilanNo)) . '" class="detail"><i class="mdi mdi-pencil"></i> ' . langS(221, 2,$this->input->post("lang")) . '</a></div>';
                                                }

                                            } else {
                                                if($value->type==1){
                                                    $sayy=$this->m_tr_model->query("select count(*) as say from table_adverts_sell_stock where  advert_id=".$value->id );
                                                    if($value->status==4){
                                                        $hep=$sayy[0]->say * $value->price;
                                                        $str .= '<div class="price">'. langS(70, 2,$this->input->post("lang")) .' : ' .$sayy[0]->say .' x '. (floor($value->price*100)/100).' = ' . (floor($hep*100)/100) . ' ' . getcur();

                                                        $str .= ' </span> <span class="badge badge-warning adetKalan2"><i class="mdi mdi-check"></i> '.langS(388,2,$this->input->post("lang")).' '.$sayy[0]->say.'</span>    </div>
                                                            <div class="date">
                                                                ' . date("Y-m-d H:i:s", strtotime($value->created_at)) . '
                                                            </div>
                                                        </div>
                                                        
                                                        <a href="' . base_url(gg($this->input->post("lang")) . $ilanPage->link . "/" . mb_strtolower($value->ilanNo)) . '" class="detail"><i class="mdi mdi-pencil"></i> ' . langS(221, 2,$this->input->post("lang")) . '</a></div>';
                                                    }else{
                                                        $hep=$sayy[0]->say * $value->price;
                                                        $str .= '<div class="price">'. langS(70, 2,$this->input->post("lang")) .' : ' .$sayy[0]->say .' x '.(floor($value->price*100)/100).' = ' . (floor($hep*100)/100) . ' ' . getcur();

                                                        $str .= ' </span> <span class="badge badge-warning adetKalan2"><i class="mdi mdi-check"></i> '.langS(388,2,$this->input->post("lang")).' '.$sayy[0]->say.'</span>    </div>
                                                            <div class="date">
                                                                ' . date("Y-m-d H:i:s", strtotime($value->created_at)) . '
                                                            </div>
                                                        </div>
                                                        
                                                        <a href="' . base_url(gg($this->input->post("lang")) . $ilanPage->link . "/" . mb_strtolower($value->ilanNo)) . '" class="detail"><i class="mdi mdi-pencil"></i> ' . langS(221, 2,$this->input->post("lang")) . '</a></div>';
                                                    }

                                                }else{
                                                    $str .= '<div class="price">' . langS(70, 2,$this->input->post("lang")) . ': ' . (floor($value->price*100)/100) . ' ' . getcur();


                                                    $str .= ' </span></div>
                                                        <div class="date">
                                                           ' . date("Y-m-d H:i:s", strtotime($value->created_at)) . '
                                                        </div>
                                                    </div><a href="' . base_url(gg($this->input->post("lang")) . $ilanPage->link . "/" . mb_strtolower($value->ilanNo)) . '" class="detail"><i class="mdi mdi-pencil"></i> ' . langS(221, 2,$this->input->post("lang")) . '</a></div>';
                                                }



                                            }
                                            //$str .= ' - <span class="text-success"> ' . langS(72, 2) . ': ' . number_format($value->sell_price, 2, ",", ".") . ' ' . getcur();

                                        }


                                    }
                                    $sayfa_goster = 3; // gösterilecek sayfa sayısı
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

                                } else {
                                    echo json_encode(array("veriler" => "", "filter" => $filter, "filterSiralama" => "",
                                        "page" => "", "sayfalama" => "", "genel" => ""));
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
                                $status = 1;
                            } else if ($this->input->post("types") == 2) {
                                //TAMAMLANDI
                                $status = 2;
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
                                $cek = getTable("table_orders", array("user_id" => $user->id,"is_delete" => 0, "status" => $status));
                                if ($cek) {
                                    foreach ($cek as $item) {
                                        $cekUr = getTableSingle("table_products", array("id" => $item->product_id));
                                        $pars = json_decode($cekUr->field_data);
                                        foreach ($pars as $par) {
                                            if ($par->lang_id == $this->input->post("lang")) {
                                                if (stristr($par->name, $ad)) {
                                                    $bulunanlar[] = $item->id;
                                                }
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
                                $toplam = $this->m_tr_model->query("select count(*) as say from table_orders where is_delete=0 and  user_id=" . $user->id . " and status=" . $status . $ad);
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
                                    $ilanlar = $this->m_tr_model->query("select * from table_orders where is_delete=0 and  id in (" . $verilers . ") and user_id=" . $user->id . " and status = " . $status . $sirala . " limit " . $limit . ",10");
                                } else {
                                    $ilanlar = $this->m_tr_model->query("select * from table_orders where is_delete=0 and  user_id=" . $user->id . " and status = " . $status . $sirala . " limit " . $limit . ",10");
                                }
                                $useragent = $_SERVER['HTTP_USER_AGENT'];
                                $mobil = 0;
                                if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
                                    $mobil = 1;
                                }

                                if ($ilanlar) {
                                    foreach ($ilanlar as $value) {

                                        $cekUrun = $this->m_tr_model->getTableSingle("table_products", array("id" => $value->product_id, "status" => 1));
                                        if ($cekUrun) {
                                            $ll = getLangValue($cekUrun->id, "table_products", $this->input->post("lang"));
                                            if($ll->name==""){
                                                $ll = getLangValue($cekUrun->id, "table_products", 1);
                                            }
                                            $str .= '<div class="box boyutlaIlan">';
                                            if($cekUrun->image==""){
                                                $str .= '<img src="' . base_url("assets/images/noimage.webp") . '"
                                                             alt="">';
                                            }else{
                                                $str .= '<img src="' . base_url("upload/product/" . $cekUrun->image) . '"
                                                             alt="">';
                                            }

                                            if ($value->price_discount != 0) {
                                                $hesap = $value->price_discount * $value->quantity;
                                                $price = (floor($value->price_discount*100)/100) . " " . getcur() . " x " . $value->quantity . " = " . (floor($hesap*100)/100);
                                            } else {
                                                $hesap = $value->price * $value->quantity;
                                                $price = (floor($value->price*100)/100) . " " . getcur() . " x " . $value->quantity . " = " .(floor($hesap*100)/100);
                                            }
                                            $info = "";
                                            if ($value->special_field != "") {
                                                $cekOzel = $this->m_tr_model->getTableSingle("table_products_special", array("p_id" => $value->product_id, "status" => 1, "is_main" => 1));
                                                if ($cekOzel) {
                                                    $info = getLangValue($cekOzel->id, "table_products_special");
                                                    $infomobil = $info;
                                                    $info = ' - <span class="text-info">' . $info->name . " : " . $value->special_field . "</span>";
                                                }
                                            } else {
                                                $cekOzel = $this->m_tr_model->getTableSingle("table_products", array("id" => $value->product_id, "status" => 1));
                                            }
                                            $bg = "";
                                            if ($value->status == 2) {
                                                $bg = "bg-success";
                                            } else if ($value->status == 5) {
                                                $bg = "bg-danger";
                                            } else if ($value->status == 3) {
                                                $bg = "bg-info";
                                            }


                                            $str .= '<div class="right">
                                                    <h5>' . kisalt($ll->name, 65) . ' <span style="color: #c5c5c5;font-size: 8pt;"> - ' . $value->sipNo . '</span></h5>
                                                     <div class="price">
                                                         ' . $price . ' ' . getcur();
                                            if ($mobil == 1) {

                                            } else {
                                                $str .= $info;
                                            }

                                            $str .= '</div>
                                                 <div class="date">
                                                    ' . date("Y-m-d H:i", strtotime($value->created_at)) . '
                                                 </div>
                                             </div>';

                                            $str .= '<a  data-id="' . $value->sipNo . '" class="detail ' . $bg . '"><b>' . langS(221, 2,$this->input->post("lang")) . '</b></a>';


                                            if ($value->price_discount == 0) {
                                                $pricess = $value->price;
                                            } else {
                                                $pricess = $value->price_discount;
                                            }

                                            if ($mobil == 1) {
                                                $str .= '<div id="pd-' . $value->sipNo . '" class="profil-detail mt-2" style="width: auto; display:none">
                                                                <div class="row" style="justify-content: center;">
                                                           <div class="col-lg-12  table-orders" style="height:auto; margin-left:10px;">
                                                            <h4>' . langS(209, 2,$this->input->post("lang")) . '</h4>';
                                                $str2 = "";
                                                if ($value->status == 2) {
                                                    $str2 .= '<td><span class="badge badge-success">' . langS(207, 2,$this->input->post("lang")) . '</span></td>';
                                                } else if ($value->status == 1) {
                                                    $str2 .= '<td><span class="badge badge-warning">' . langS(220, 2,$this->input->post("lang")) . '</span></td>';
                                                } else if ($value->status == 3) {
                                                    $str2 .= '<td><span class="badge badge-info">' . langS(204, 2,$this->input->post("lang")) . '</span></td>';
                                                } else if ($value->status == 5) {
                                                    $str2 .= '<td><span class="badge badge-danger">' . langS(206, 2,$this->input->post("lang")) . '</span></td>';
                                                }
                                                $str .= '<table style="width: 100% !important;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>' . langS(210, 2,$this->input->post("lang")) . '</td>
                                                                        <td>' . $value->sipNo . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>' . langS(211, 2,$this->input->post("lang")) . '</td>
                                                                        <td>' . date("Y-m-d H:i", strtotime($value->created_at)) . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>' . langS(251, 2,$this->input->post("lang")) . '</td>
                                                                        <td>' . (floor($pricess*100)/100) . ' ' . getcur() . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>' . langS(213, 2,$this->input->post("lang")) . '</td>
                                                                        <td>' . $value->quantity . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>' . langS(250, 2,$this->input->post("lang")) . '</td>
                                                                        <td>' . (floor($value->total_price*100)/100) . ' ' . getcur() . '</td>
                                                                    </tr> ';
                                                if ($infomobil != "") {
                                                    $str .= ' <tr>
                                                                <td>' . $infomobil->name . '</td>
                                                                <td>' . $value->special_field . '</td>
                                                            </tr> ';
                                                }

                                                $str .= '<tr>
                                                                        <td>' . langS(212, 2,$this->input->post("lang")) . '</td>
                                                                         ' . $str2;
                                                if ($value->codes != "") {
                                                    $pars = explode("**", $value->codes);
                                                    $say = 1;
                                                    $strCopy = "";
                                                    foreach ($pars as $par) {
                                                        $str .= '<tr class="code">';
                                                        if ($say == 1) {
                                                            $str .= '<td colspan="6"><h5 style="margin-bottom: 5px !important;font-size:12pt; color: #e5af25 ">' . langS(215, 2,$this->input->post("lang")) . '</h5></td></tr>';
                                                        }
                                                        $strCopy .= $par . " | ";

                                                        $str .= '<tr class="code"><td colspan="6">
                                                                   <b style="font-size: 10pt;">' . $ll->name . '</b>
                                                                   <span class="badge badge-light">' . $par . '</span> 
                                                                   <div class="copy" onclick="copyToClipboard(\'' . $par . '\')" style="cursor:pointer"><i class="mdi mdi-content-copy"></i></div>
                                                               
                                                                    </td>
                                                                </tr>';
                                                        $say++;
                                                    }
                                                }

                                                $str .= '</tbody>
                                                            </table><div class="comment-request">';
                                                if ($value->status == 2) {
                                                    $str .= '';
                                                    if ($value->codes != "") {
                                                        $str .= '<a  onclick="copyToClipboard(\'' . rtrim($strCopy, ' | ') . '\')" class=" mt-2" style="background-color:#329a86;margin-right: 15px;">
                                                            <i class="mdi mdi-content-copy"></i> ' . langS(254, 2,$this->input->post("lang")) . '</a>';
                                                        $str .= '<a href="' . base_url("exporttxt/" . $value->sipNo) . '" class=" mt-2" style="background-color:#76549f;margin-right: 15px;">
                                                            <i class="mdi mdi-download"></i> ' . langS(255, 2,$this->input->post("lang")) . '</a>';
                                                    }
                                                    $str .= '<a data-id="SR-' . $value->sipNo . '-DS"  class=" mt-2 degerlendirme" style="margin-right: 15px;">
                                                            <i class="mdi mdi-message"></i> ' . langS(228, 2,$this->input->post("lang")) . '</a>';
                                                }
                                                $str .= '<a data-id="' . $value->sipNo . '" class="sms talepGenel mt-2">
                                                            <i class="mdi mdi-help" ></i> '
                                                    . langS(229, 2,$this->input->post("lang")) . '
                                                        </a>';

                                                $str .= '
                                                            </div>';
                                                $str .= '</div>
                                                        </div>';
                                            } else {
                                                $str .= '<div id="pd-' . $value->sipNo . '" class="profil-detail mt-2" style="display: none; border-radius: 10px;">
                                                                <div class="row" style="justify-content: center;">
                                                           <div class="col-lg-12  table-orders" style="height:auto; margin-left:10px; border-radius: 10px;">
                                                            <h4 style="font-size: 12pt;">Sipariş Detayları</h4>';
                                                $str .= '<table>
                                                                <thead>
                                                                    <th>' . langS(210, 2,$this->input->post("lang")) . '</th>
                                                                    <th>' . langS(211, 2,$this->input->post("lang")) . '</th>
                                                                    <th>' . langS(250, 2,$this->input->post("lang")) . '</th>
                                                                    <th>' . langS(213, 2,$this->input->post("lang")) . '</th>
                                                                    <th>' . langS(251, 2,$this->input->post("lang")) . '</th>
                                                                    <th>' . langS(212, 2,$this->input->post("lang")) . '</th>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>' . $value->sipNo . '</td>
                                                                        <td>' . date("Y-m-d H:i", strtotime($value->created_at)) . '</td>
                                                                        <td>' . (floor($pricess*100)/100) . " " . getcur() . '</td>
                                                                        <td>' . $value->quantity . '</td>
                                                                        <td>' . (floor($value->total_price*100)/100) . " " . getcur() . '</td>';
                                                if ($value->status == 2) {
                                                    $str .= '<td><span class="badge badge-success">' . langS(207, 2,$this->input->post("lang")) . '</span></td>';
                                                } else if ($value->status == 1) {
                                                    $str .= '<td><span class="badge badge-warning">' . langS(220, 2,$this->input->post("lang")) . '</span></td>';
                                                } else if ($value->status == 3) {
                                                    $str .= '<td><span class="badge badge-info">' . langS(204, 2,$this->input->post("lang")) . '</span></td>';
                                                } else if ($value->status == 5) {
                                                    $str .= '<td><span class="badge badge-danger">' . langS(206, 2,$this->input->post("lang")) . '</span></td>';
                                                }

                                                $str .= '</tr>';
                                                if ($value->codes != "") {
                                                    $pars = explode("**", $value->codes);
                                                    $say = 1;
                                                    $strCopy = "";
                                                    foreach ($pars as $par) {
                                                        $str .= '<tr class="code">';
                                                        if ($say == 1) {
                                                            $str .= '<td colspan="6"><h5 style="margin-bottom: 5px !important;font-size:12pt; color: #e5af25 ">' . langS(215, 2,$this->input->post("lang")) . '</h5></td></tr>';
                                                        }
                                                        $strCopy .= $par . " | ";

                                                        $str .= '<tr class="code"><td colspan="6">
                                                                   <b style="font-size: 10pt;">' . $ll->name . '</b>
                                                                   <span class="badge badge-light">' . $par . '</span> 
                                                                   <div class="copy" onclick="copyToClipboard(\'' . $par . '\')" style="cursor:pointer"><i class="mdi mdi-content-copy"></i></div>
                                                                  
                                                                    </td>
                                                                </tr>';
                                                        $say++;
                                                    }
                                                }


                                                $str .= '</tbody>
                                                            </table><div class="comment-request">';
                                                if ($value->status == 2) {
                                                    $str .= '';
                                                    if ($value->codes != "") {
                                                        $str .= '<a  onclick="copyToClipboard(\'' . rtrim($strCopy, ' | ') . '\')" class=" mt-2" style="background-color:#329a86;margin-right: 15px;">
                                                            <i class="mdi mdi-content-copy"></i> ' . langS(254, 2,$this->input->post("lang")) . '</a>';
                                                        $str .= '<a href="' . base_url("exporttxt/" . $value->sipNo) . '" class=" mt-2" style="background-color:#76549f;margin-right: 15px;">
                                                            <i class="mdi mdi-download"></i> ' . langS(255, 2,$this->input->post("lang")) . '</a>';
                                                    }
                                                    $str .= '<a data-id="SR-' . $value->sipNo . '-DS"  class=" mt-2 degerlendirme" style="margin-right: 15px;">
                                                            <i class="mdi mdi-message"></i> ' . langS(228, 2,$this->input->post("lang")) . '</a>';
                                                }
                                                $str .= '<a data-id="' . $value->sipNo . '" class="sms talepGenel mt-2">
                                                            <i class="mdi mdi-help" ></i> '
                                                    . langS(229, 2,$this->input->post("lang")) . '
                                                        </a>';

                                                $str .= '
                                                            </div>';
                                                $str .= '</div>
                                                        </div>';
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

    //talepler
    public function getListeMyDemands()
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
                            $sirala = " order by update_at desc";

                            if ($ad != "") {
                                $toplam = $this->m_tr_model->query("select count(*) as say from table_talep where is_delete=0 and  user_id=" . $user->id . " and talepNo like '%" . $ad . "%'");
                                $toplam = $toplam[0]->say;
                            } else {
                                $toplam = $this->m_tr_model->query("select count(*) as say from table_talep where is_delete=0 and  user_id=" . $user->id);
                                $toplam = $toplam[0]->say;
                            }


                            if ($toplam >= 1) {
                                $toplam_sayfa = ceil($toplam / 10);
                                if ($sayfa < 1) $sayfa = 1;
                                if ($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;
                                $limit = ($sayfa - 1) * 10;
                                if ($ad != "") {
                                    $ilanlar = $this->m_tr_model->query("select * from table_talep where is_delete=0 and   user_id=" . $user->id . " and talepNo like '%" . $ad . "%' " . $sirala . " limit " . $limit . ",10");
                                } else {
                                    $ilanlar = $this->m_tr_model->query("select * from table_talep where is_delete=0 and  user_id=" . $user->id . " " . $sirala . " limit " . $limit . ",10");
                                }
                                $useragent = $_SERVER['HTTP_USER_AGENT'];
                                $mobil = 0;
                                if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
                                    $mobil = 1;
                                }
                                $talepPage = getLangValue(45, "table_pages",$this->input->post("lang"));
                                if ($ilanlar) {
                                    foreach ($ilanlar as $value) {

                                        if ($mobil == 1) {
                                            $str .= '<div id="pd-' . $value->id . '" class="profil-detail customtable mt-2" style="width: auto; ">
                                                                <div class="row customtable" style="justify-content: center; ">
                                                           <div class="col-lg-12  table-orders" style="height:auto;  margin-left:10px;">
                                                            ';

                                            $str .= '<table style="width: 100% !important;">
                                                                <tbody>
                                                                
                                                                    <tr>
                                                                        <td>' . langS(262, 2,$this->input->post("lang")) . '</td>
                                                                        <td>' . $value->talepNo . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>' . langS(263, 2,$this->input->post("lang")) . '</td>
                                                                        <td>' . date("Y-m-d H:i", strtotime($value->created_at)) . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>' . langS(210, 2,$this->input->post("lang")) . '</td>
                                                                        <td>';
                                            if ($value->order_id != "") {
                                                if($value->advert_id!=0){
                                                    $tur = langS(265, 2,$this->input->post("lang"));
                                                }else{
                                                    if ($value->code_id != "") {

                                                    } else {
                                                        $tur = langS(264, 2,$this->input->post("lang"));
                                                        $or = $this->m_tr_model->getTableSingle("table_orders", array("id" => $value->order_id));
                                                        $or = $or->sipNo;
                                                    }
                                                }
                                            }
                                            $str2 = "";
                                            if ($value->status == 0) {
                                                $str2 .= '<td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> ' . langS(203, 2,$this->input->post("lang")) . '</span></td>';
                                            } else if ($value->status == 1) {
                                                $str2 .= '<td><span class="badge badge-info"><i class="mdi mdi-comment"></i> ' . langS(267, 2,$this->input->post("lang")) . '</span></td>';
                                            } else if ($value->status == 2) {
                                                $str2 .= '<td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> ' . langS(268, 2,$this->input->post("lang")) . '</span> </td>';
                                            } else if ($value->status == 3) {
                                                $str2 .= '<td><span class="badge badge-success"><i class="mdi mdi-check"></i> ' . langS(269, 2,$this->input->post("lang")) . '</span></td>';
                                            } else if ($value->status == 4) {
                                                $str2 .= '<td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> ' . langS(268, 2,$this->input->post("lang")) . '</span> </td>';
                                            }

                                            $str .= $or . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>' . langS(240, 2,$this->input->post("lang")) . '</td>
                                                                        ' . $str2 . '
                                                                    </tr>
                                                                    <tr>
                                                                        <td>' . langS(221, 2,$this->input->post("lang")) . '</td>
                                                                        <td><a href="' . base_url(gg($this->input->post("lang")) . $talepPage->link . "/" . str_replace("#", "", $value->talepNo)) . '" class="talep-detay" style=""><b>Detay</b></a></td>
                                                                    </tr> ';


                                            $str .= '</tbody>
                                                            </table>';
                                            $str .= '</div>
                                                        </div>';
                                        } else {

                                            $str .= '<div id="pd-' . $value->id . '" class="profil-detail customtable mt-2" style=" border-radius: 50px;">
                                                        <div class="row" style="justify-content: center;">
                                                           <div class="col-lg-12  table-orders" style="height:auto;  margin-left:10px; border-radius: 30px;">
                                                                <table>
                                                                    <thead>
                                                                        <th>' . langS(262, 2,$this->input->post("lang")) . '</th>
                                                                        <th>' . langS(241, 2,$this->input->post("lang")) . '</th>
                                                                        <th>' . langS(263, 2,$this->input->post("lang")) . '</th>
                                                                        <th>' . langS(210, 2,$this->input->post("lang")) . '</th>
                                                                        <th>' . langS(240, 2,$this->input->post("lang")) . '</th>
                                                                        <th>' . langS(221, 2,$this->input->post("lang")) . '</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>#T-S-' . $value->id . '</td>
                                                                            <td>' . date("Y-m-d H:i", strtotime($value->created_at)) . '</td>';
                                            if ($value->order_id != "") {
                                                if($value->advert_id!=0){
                                                    $tur = langS(265, 2,$this->input->post("lang"));
                                                    $or = $this->m_tr_model->getTableSingle("table_orders_adverts", array("id" => $value->advert_id));
                                                    $or = $or->sipNo;
                                                }else{
                                                    if ($value->code_id != "") {

                                                    } else {
                                                        $tur = langS(264, 2,$this->input->post("lang"));
                                                        $or = $this->m_tr_model->getTableSingle("table_orders", array("id" => $value->order_id));
                                                        $or = $or->sipNo;
                                                    }
                                                }

                                            }
                                            $str .= '<td>' . $tur . '</td>
                                                                            <td>#' . $or . '</td>';
                                            if ($value->status == 0) {
                                                $str .= '<td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> ' . langS(203, 2,$this->input->post("lang")) . '</span></td>';
                                            } else if ($value->status == 1) {
                                                $str .= '<td><span class="badge badge-info"><i class="mdi mdi-comment"></i> ' . langS(267, 2,$this->input->post("lang")) . '</span></td>';
                                            } else if ($value->status == 2) {
                                                $str .= '<td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> ' . langS(268, 2,$this->input->post("lang")) . '</span> </td>';
                                            } else if ($value->status == 3) {
                                                $str .= '<td><span class="badge badge-success"><i class="mdi mdi-check"></i> ' . langS(269, 2,$this->input->post("lang")) . '</span></td>';
                                            } else if ($value->status == 4) {
                                                $str .= '<td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> ' . langS(268, 2,$this->input->post("lang")) . '</span> </td>';
                                            }

                                            $str .= '<td><a href="' . base_url(gg($this->input->post("lang")) . $talepPage->link . "/" . str_replace("#", "", $value->talepNo)) . '" class="talep-detay" style=""><b>Detay</b></a></td>';
                                            $str .= '</tr>';

                                            $str .= '</tbody>
                                                            </table>';
                                            $str .= '</div>
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

    public function getListeMyBalance()
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
                                $toplam = $this->m_tr_model->query("select count(*) as say from table_users_balance_history where is_delete=0 and  user_id=" . $user->id . " and islemNo like '%" . $ad . "%'");
                                $toplam = $toplam[0]->say;
                            } else {
                                $toplam = $this->m_tr_model->query("select count(*) as say from table_users_balance_history where is_delete=0 and  user_id=" . $user->id);
                                $toplam = $toplam[0]->say;
                            }


                            if ($toplam >= 1) {
                                $toplam_sayfa = ceil($toplam / 10);
                                if ($sayfa < 1) $sayfa = 1;
                                if ($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;
                                $limit = ($sayfa - 1) * 10;
                                if ($ad != "") {
                                    $ilanlar = $this->m_tr_model->query("select * from table_users_balance_history where is_delete=0 and  user_id=" . $user->id . " and islemNo like '%" . $ad . "%' " . $sirala . " limit " . $limit . ",10");
                                } else {
                                    $ilanlar = $this->m_tr_model->query("select * from table_users_balance_history where is_delete=0 and  user_id=" . $user->id . " " . $sirala . " limit " . $limit . ",10");
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
                                                                        <th width="12%">' . langS(279, 2,$this->input->post("lang")) . '</th>
                                                                        <th>' . langS(241, 2,$this->input->post("lang")) . '</th>
                                                                        <th>' . langS(281, 2,$this->input->post("lang")) . '</th>
                                                                        <th>' . langS(210, 2,$this->input->post("lang")) . '</th>
                                                                        <th>' . langS(250, 2,$this->input->post("lang")) . '</th>
                                                                        <th>' . langS(240, 2,$this->input->post("lang")) . '</th>
                                                                    
                                                                    </thead>
                                                                    <tbody>';
                                    foreach ($ilanlar as $value) {

                                        if ($mobil == 1) {
                                            $str .= '<div id="pd-' . $value->id . '" class="profil-detail mt-2" style="width: auto; ">
                                                                <div class="row customtable" style="justify-content: center;">
                                                           <div class="col-lg-12  table-orders" style="height:auto;  margin-left:10px;">
                                                            ';

                                            $str .= '<table style="width: 100% !important;">
                                                    <tbody>
                                                    
                                                        <tr>
                                                            <td>' . langS(279, 2,$this->input->post("lang")) . '</td>
                                                            <td>#' . $value->islemNo . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td>' . langS(241, 2,$this->input->post("lang")) . '</td>
                                                            <td>' . date("Y-m-d H:i", strtotime($value->created_at)) . '</td>
                                                        </tr>';
                                            if ($value->order_id != "") {
                                                if ($value->advert_id != 0) {
                                                    $or = $this->m_tr_model->getTableSingle("table_orders_adverts", array("id" => $value->order_id));
                                                    $pr = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $value->advert_id));
                                                    $pr = getLangValue($pr->id, "table_adverts",$this->input->post("lang"));
                                                    $linkss="<a class='prlink' href='".base_url(gg($this->input->post("lang")).$adpage->link."/".$pr->link)."'> " . $pr->name."</a>";
                                                    if ($value->code_id != "") {

                                                    } else {
                                                        $tur = langS(264, 2,$this->input->post("lang"));
                                                        $or = $this->m_tr_model->getTableSingle("table_orders_adverts", array("id" => $value->order_id));
                                                        $or = $or->sipNo;
                                                    }
                                                } else {
                                                    if($value->ilan_id!=0 && $value->doping_id!=0){
                                                        $ilanlarimpage=getLangValue(36,"table_pages",$this->input->post("lang"));
                                                        $cekilan=getTableSingle("table_adverts",array("id" => $value->ilan_id));
                                                        $linkss="<i class='mdi mdi-star text-info'></i> Doping Ücreti <br>  <a class='doplink'  style=';margin-top:4px !important;display: block;' href='".base_url(gg($this->input->post("lang")).$ilanlarimpage->link."/".$cekilan->ilanNo)."'> " . kisalt($cekilan->ad_name,40)."</a>";
                                                        $or="-";
                                                    }else{
                                                        if($value->product_id!=0){
                                                            $or = $this->m_tr_model->getTableSingle("table_orders", array("id" => $value->order_id));
                                                            $pr = $this->m_tr_model->getTableSingle("table_products", array("id" => $value->product_id));
                                                            $prL=getLangValue($value->product_id,"table_products",$this->input->post("lang"));
                                                            if($prL->name==""){
                                                                $prL=getLangValue($value->product_id,"table_products",1);
                                                            }
                                                            $ct= $this->m_tr_model->getTableSingle("table_products_category", array("id" => $pr->category_id));
                                                            $ctLAng=getLangValue($ct->id,"table_products_category",$this->input->post("lang"));
                                                            $linkss="<a class='prlink'  href='".base_url(gg($this->input->post("lang")).$ctLAng->link."/".$prL->link)."'> " . $prL->name."</a>";
                                                            if ($value->code_id != "") {

                                                            } else {
                                                                $tur = langS(264, 2,$this->input->post("lang"));
                                                                $or = $this->m_tr_model->getTableSingle("table_orders", array("id" => $value->order_id));
                                                                $or = "#".$or->sipNo;
                                                            }
                                                        }else{
                                                            $ilanlarimpage=getLangValue(36,"table_pages",$this->input->post("lang"));
                                                            $cekilan=getTableSingle("table_adverts",array("id" => $value->ilan_id));
                                                            $linkss=" <a class='doplink'  style=';margin-top:4px !important;display: block;' href='".base_url(gg($this->input->post("lang")).$ilanlarimpage->link."/".$cekilan->ilanNo)."'> " . kisalt($cekilan->ad_name,40)."</a>";
                                                            $or="-";
                                                        }

                                                    }
                                                }
                                            }
                                            $str.='<tr>
                                                            <td>' . langS(281, 2 ,$this->input->post("lang")) . '</td>
                                                            <td>'.$linkss.'</td>
                                                        </tr>
                                                        <tr>
                                                            <td>' . langS(210, 2,$this->input->post("lang")) . '</td>
                                                            <td>' . $or . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td>' . langS(250, 2,$this->input->post("lang")) . '</td>
                                                            <td>' . (floor($value->quantity*100)/100) . " " . getcur() . '</td>
                                                        </tr>
                                                         <tr>
                                                            <td>' . langS(240, 2,$this->input->post("lang")) . '</td>';
                                            if ($value->status == 1) {
                                                $str .= '<td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> ' . langS(280, 2,$this->input->post("lang")) . '</span></td>';
                                            } else if ($value->status == 2) {
                                                $str .= '<td><span class="badge badge-danger"><i class="mdi mdi-chevron-triple-down"></i> ' . langS(282, 2,$this->input->post("lang")) . '</span></td>';
                                            } else if ($value->status == 3) {
                                                $str .= '<td><span class="badge badge-success"><i class="mdi mdi-chart-box-plus-outline"></i> ' . langS(283, 2,$this->input->post("lang")) . '</span> </td>';
                                            }
                                            $str.='</tr>';


                                            $str .= '</tbody>
                                                            </table>';
                                            $str .= '</div>
                                                        </div>';
                                        } else {

                                            $adpage=getLangValue(34,"table_pages",$this->input->post("lang"));

                                            $str .= '
                                                <tr>
                                                    <td>#' . $value->islemNo . '</td>
                                                    <td>' . date("Y-m-d H:i", strtotime($value->created_at)) . '</td>';
                                            if ($value->order_id != 0) {
                                                if ($value->advert_id != 0) {
                                                    $or = $this->m_tr_model->getTableSingle("table_orders_adverts", array("id" => $value->order_id));
                                                    $pr = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $value->advert_id));
                                                    $pr = getLangValue($pr->id, "table_adverts",$this->input->post("lang"));
                                                    $linkss="<a class='prlink'  href='".base_url(gg($this->input->post("lang")).$adpage->link."/".$pr->link)."'> " . $pr->name."</a>";
                                                    if ($value->code_id != "") {

                                                    } else {
                                                        $tur = langS(264, 2,$this->input->post("lang"));
                                                        $or = $this->m_tr_model->getTableSingle("table_orders_adverts", array("id" => $value->order_id));
                                                        $or = $or->sipNo;
                                                    }
                                                } else {
                                                    if($value->ilan_id!=0 && $value->doping_id!=0){
                                                        $ilanlarimpage=getLangValue(36,"table_pages",$this->input->post("lang"));
                                                        $cekilan=getTableSingle("table_adverts",array("id" => $value->ilan_id));
                                                        $linkss="<i class='mdi mdi-star text-info'></i> ".langS(441,2,$this->input->post("lang"))." <br>  <a class='doplink' style='margin-top:4px !important;display: block' href='".base_url(gg($this->input->post("lang")).$ilanlarimpage->link."/".$cekilan->ilanNo)."'> " . kisalt($cekilan->ad_name,40)."</a>";
                                                        $or="-";
                                                    }else{
                                                        if($value->product_id!=0){
                                                            $or = $this->m_tr_model->getTableSingle("table_orders", array("id" => $value->order_id));
                                                            $pr = $this->m_tr_model->getTableSingle("table_products", array("id" => $value->product_id));
                                                            $prL=getLangValue($value->product_id,"table_products",$this->input->post("lang"));
                                                            if($prL->name==""){
                                                                $prL=getLangValue($value->product_id,"table_products",1);
                                                            }
                                                            $ct= $this->m_tr_model->getTableSingle("table_products_category", array("id" => $pr->category_id));
                                                            $ctLAng=getLangValue($ct->id,"table_products_category",$this->input->post("lang"));
                                                            $linkss="<a class='prlink' href='".base_url(gg($this->input->post("lang")).$ctLAng->link."/".$prL->link)."'> " . $prL->name."</a>";
                                                            if ($value->code_id != "") {

                                                            } else {
                                                                $tur = langS(264, 2,$this->input->post("lang"));
                                                                $or = $this->m_tr_model->getTableSingle("table_orders", array("id" => $value->order_id));
                                                                $or = "#".$or->sipNo;
                                                            }
                                                        }else{
                                                            $ilanlarimpage=getLangValue(36,"table_pages",$this->input->post("lang"));
                                                            $cekilan=getTableSingle("table_adverts",array("id" => $value->ilan_id));
                                                            $linkss="<a class='prlink'  style='margin-top:4px !important;display: block' href='".base_url(gg($this->input->post("lang")).$ilanlarimpage->link."/".$cekilan->ilanNo)."'> " . kisalt($cekilan->ad_name,40)."</a>";
                                                            $or="-";
                                                        }

                                                    }
                                                }
                                            }else{
                                                if($value->sms_id!=0){
                                                    $smscek=getTableSingle("table_user_send_sms",array("id" => $value->sms_id,"status" => 1));
                                                    if($smscek){
                                                        $ilanCek=getTableSingle("table_adverts",array("id" => $smscek->advert_id));
                                                        if($ilanCek){
                                                            $ilan=getLangValue($ilanCek->id,"table_adverts",$this->input->post("lang"));
                                                            $pagess=getLangValue(34,"table_pages",$this->input->post("lang"));
                                                            $linkss=str_replace("{name}","<a href='".base_url(gg($this->input->post("lang")).$pagess->link."/".$ilan->link)."'>#".$ilanCek->ilanNo."</a>",langS(490,2,$this->input->post("lang")));
                                                        }
                                                    }
                                                }else{
                                                    if($value->ilan_id!=0 && $value->doping_id!=0){
                                                        $ilanlarimpage=getLangValue(36,"table_pages",$this->input->post("lang"));
                                                        $cekilan=getTableSingle("table_adverts",array("id" => $value->ilan_id));
                                                        $linkss="<i class='mdi mdi-star text-info'></i> ".langS(441,2,$this->input->post("lang"))." <br>  <a class='doplink' style='margin-top:4px !important;display: block' href='".base_url(gg($this->input->post("lang")).$ilanlarimpage->link."/".$cekilan->ilanNo)."'> " . kisalt($cekilan->ad_name,40)."</a>";
                                                        $or="-";
                                                    }
                                                }
                                            }
                                            $str .= "<td>".$linkss."</td>";
                                            $str .= '<td>' . $or . '</td>
                                                    <td>' . (floor($value->quantity*100)/100) . " " . getcur() . '</td>';
                                            if ($value->status == 1) {
                                                $str .= '<td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> ' . langS(280, 2,$this->input->post("lang")) . '</span></td>';
                                            } else if ($value->status == 2) {
                                                $str .= '<td><span class="badge badge-danger"><i class="mdi mdi-chevron-triple-down"></i> ' . langS(282, 2,$this->input->post("lang")) . '</span></td>';
                                            } else if ($value->status == 3) {
                                                $str .= '<td><span class="badge badge-success"><i class="mdi mdi-chart-box-plus-outline"></i> ' . langS(283, 2,$this->input->post("lang")) . '</span> </td>';
                                            }
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




    public function getListeMyAddBalanceHistory()
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
                            $sirala = "order by created_at desc ";
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
                                $toplam = $this->m_tr_model->query("select count(*) as say from table_payment_log where   (status=1 or status=0 or status=3 or status=2) and  user_id=" . $user->id . " and order_id like '%" . $ad . "%'");
                                $toplam = $toplam[0]->say;
                            } else {
                                $toplam = $this->m_tr_model->query("select count(*) as say from table_payment_log where  (status=1 or status=0 or status=3 or status=2) and  user_id=" . $user->id);
                                $toplam = $toplam[0]->say;
                            }


                            if ($toplam >= 1) {
                                $toplam_sayfa = ceil($toplam / 10);
                                if ($sayfa < 1) $sayfa = 1;
                                if ($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;
                                $limit = ($sayfa - 1) * 10;
                                if ($ad != "") {
                                    $ilanlar = $this->m_tr_model->query("select * from table_payment_log where   (status=1 or status=0 or status=3 or status=2) and user_id=" . $user->id . " and order_id like '%" . $ad . "%' " . $sirala . " limit " . $limit . ",10");
                                } else {
                                    $ilanlar = $this->m_tr_model->query("select * from table_payment_log where   (status=1 or status=0 or status=3 or status=2) and  user_id=" . $user->id . " " . $sirala . " limit " . $limit . ",10");
                                }
                                $useragent = $_SERVER['HTTP_USER_AGENT'];
                                $mobil = 0;
                                if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
                                    $mobil = 1;
                                }
                                $talepPage = getLangValue(45, "table_pages",$this->input->post("lang"));
                                if ($ilanlar) {

                                    foreach ($ilanlar as $value) {

                                        if ($mobil == 1) {
                                            $str .= '<div id="pd-' . $value->id . '" class="profil-detail mt-2" style="width: auto; ">
                                                                <div class="row customtable" style="justify-content: center;">
                                                           <div class="col-lg-12  table-orders" style="height:auto;  margin-left:10px;">
                                                            ';
                                            $str2="";
                                            $str .= '<table style="width: 100% !important;">
                                                    <tbody>
                                                    
                                                        <tr>
                                                            <td>' .langS(279, 2,$this->input->post("lang")) . '</td>
                                                            <td>#' . $value->order_id . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td>' . langS(241, 2,$this->input->post("lang")) . '</td>
                                                            <td>' . date("Y-m-d H:i", strtotime($value->created_at)) . '</td>
                                                        </tr>';
                                                        if( $value->payment_method==2){
                                                            $str .= '
                                                                    <tr>
                                                                        <td>' . langS(326, 2,$this->input->post("lang")) . '</td>
                                                                        <td>' . langS(522,2,$this->input->post("lang")). '</td>
                                                                    </tr>';
                                                            if($value->status==1){
                                                                $str .= '
                                                                    <tr>
                                                                        <td>' . langS(322, 2,$this->input->post("lang")) . '</td>
                                                                        <td>' .(floor($value->amount*100)/100) . ' ' . getcur() . '</td>
                                                                    </tr>';
                                                            }else{
                                                                $str .= '<tr>
                                                                        <td>' . langS(323, 2,$this->input->post("lang")) . '</td>
                                                                        <td>-</td>
                                                                    </tr>';
                                                                if($value->status==2){
                                                                    $str2='<span style="display:block; padding-top: 3px !important;"><b class="text-danger">' . langS(222, 2,$this->input->post("lang")) . ":</b> " . $value->red_nedeni . ' </span><br>';
                                                                }
                                                            }
                                                        }else{
                                                            $str .= '<tr>
                                                                        <td>' . langS(326, 2,$this->input->post("lang")) . '</td>
                                                                        <td>' . $value->payment_method . " " . $value->payment_channel . '</td>
                                                                    </tr>';
                                                            $str .= '<tr>
                                                                        <td>' . langS(322, 2,$this->input->post("lang")) . '</td>
                                                                        <td>' . (floor($value->amount*100)/100). ' ' . getcur() . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>' . langS(323, 2,$this->input->post("lang")) . '</td>
                                                                        <td>' . (floor($value->balance_amount*100)/100) . ' ' . getcur() . '</td>
                                                                    </tr>';
                                                        }
                                                        $str.='
                                                       
                                                        <tr>
                                                            <td>' . langS(240, 2,$this->input->post("lang")) . '</td>';
                                            if ($value->status == 0) {
                                                $str .= '<td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> ' . langS(220, 2,$this->input->post("lang")) . '</span></td>';
                                            } else if ($value->status == 2) {
                                                $str .= '<td><span class="badge badge-danger"><i class="mdi mdi-chevron-triple-down"></i> ' . langS(324, 2,$this->input->post("lang")) . '</span></td>';
                                            } else if ($value->status == 1) {
                                                $str .= '<td><span class="badge badge-success"><i class="mdi mdi-check"></i> ' . langS(325, 2,$this->input->post("lang")) . '</span> </td>';
                                            }
                                            $str .= '</tr>';

                                            if($value->payment_method==2){
                                                $banka=getTableSingle("table_banks",array("id" => $value->bank_id) );
                                                $str .= '<tr>
                                                    <td colspan="2">
                                                    <div class="alert alert-warning" style=";" role="alert">
                                                         <span style="display:block; padding-top: 3px !important;"><b>' . langS(519, 2,$this->input->post("lang")) . ":</b> " . $banka->name . '</span> <br>            
                                                         <span style="display:block; padding-top: 3px !important;"><b>' . langS(516, 2,$this->input->post("lang")) . ":</b> " . $value->ad_soyad . '</span> <br>            
                                                         <span style="display:block; padding-top: 3px !important;"><b>' . langS(458, 2,$this->input->post("lang")) . ":</b> " . $value->dates . ' </span><br>'.$str2.'            
                                                    </div>
                                                </td></tr>
                                                ';
                                            }else{
                                                if ($value->description != "") {
                                                    $str .= '<tr>
                                                    <td colspan="2">
                                                    <div class="alert alert-warning" style="margin-top: 0px !important;" role="alert">
                                                         <b>' . langS(327, 2,$this->input->post("lang")) . ":</b> " . $value->description . ' <br>            
                                                    </div>
                                                </td></tr>
                                                ';
                                                } else {
                                                    if ($value->status == 1) {
                                                        $str .= '<tr>
                                                    <td colspan="2">
                                                    <div class="alert alert-warning" style="margin-top: 0px !important;" role="alert">
                                                         <b>' . langS(327, 2,$this->input->post("lang")) . ":</b> " . langS(321, 2,$this->input->post("lang")) . '            
                                                    </div>
                                                </td></tr>
                                                ';
                                                    }
                                                }
                                            }



                                            $str.="</tr>";


                                            $str .= '</tbody>
                                                            </table>';
                                            $str .= '</div>
                                                        </div>';
                                        } else {
                                            $str .= '<div id="pd-' . $value->id . '" class="profil-detail mt-2" style=" border-radius: 50px;">
                                                        <div class="row customtable" style="justify-content: center;">
                                                           <div class="col-lg-12  table-orders" style="height:auto;   margin-left:10px; border-radius: 30px;">
                                                                <table>
                                                                    <thead>
                                                                        <th>' . langS(279, 2,$this->input->post("lang")) . '</th>
                                                                        <th>' . langS(241, 2,$this->input->post("lang")) . '</th>
                                                                        <th>' . langS(326, 2,$this->input->post("lang")) . '</th>
                                                                        <th>' . langS(322, 2,$this->input->post("lang")) . '</th>
                                                                        <th>' . langS(323, 2,$this->input->post("lang")) . '</th>
                                                                        <th>' . langS(240, 2,$this->input->post("lang")) . '</th>
                                                                   
                                                                    </thead>
                                                                    <tbody>';

                                            $str .= ' <tr>';

                                            $str.='<td>#' . $value->order_id . '</td>
                                                <td>' . date("Y-m-d H:i", strtotime($value->created_at)) . '</td>';
                                            $str2="";

                                            if( $value->payment_method==2){
                                                $str .= '<td style="width:20%">' . langS(522,2,$this->input->post("lang")). '</td>';
                                                $str .= '<td>' . (floor($value->amount*100)/100) . ' ' . getcur() . '</td>';
                                                if($value->status==1){
                                                    $str .= '<td>' .(floor($value->amount*100)/100) . ' ' . getcur() . '</td>';
                                                }else{
                                                    $str .= '<td>-</td>';
                                                    if($value->status==2){
                                                        $str2='<span style="display:block; padding-top: 3px !important;"><b  class="text-danger">' . langS(222, 2,$this->input->post("lang")) . ":</b> " . $value->red_nedeni . ' </span><br>';
                                                    }
                                                }
                                            }else{
                                                $str .= '<td style="width:20%">' . $value->payment_method . " " . $value->payment_channel . '</td>';
                                                $str .= '<td>' . (floor($value->amount*100)/100) . ' ' . getcur() . '</td>';
                                                $str .= '<td>' .(floor($value->balance_amount*100)/100) . ' ' . getcur() . '</td>';

                                            }


                                            if($value->payment_method==2)

                                            if ($value->status == 0) {
                                                $str .= '<td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> ' . langS(220, 2,$this->input->post("lang")) . '</span></td>';
                                            } else if ($value->status == 2) {
                                                $str .= '<td><span class="badge badge-danger"><i class="mdi mdi-chevron-triple-down"></i> ' . langS(324, 2,$this->input->post("lang")) . '</span></td>';
                                            } else if ($value->status == 1) {
                                                $str .= '<td><span class="badge badge-success"><i class="mdi mdi-check"></i> ' . langS(325, 2,$this->input->post("lang")) . '</span> </td>';
                                            }
                                            $str .= '</tr>';

                                            if($value->payment_method==2){
                                                $banka=getTableSingle("table_banks",array("id" => $value->bank_id) );
                                                $str .= '<tr>
                                                    <td colspan="6">
                                                    <div class="alert alert-warning" style=";" role="alert">
                                                         <span style="display:block; padding-top: 3px !important;"><b>' . langS(519, 2,$this->input->post("lang")) . ":</b> " . $banka->name . '</span> <br>            
                                                         <span style="display:block; padding-top: 3px !important;"><b>' . langS(516, 2,$this->input->post("lang")) . ":</b> " . $value->ad_soyad . '</span> <br>            
                                                         <span style="display:block; padding-top: 3px !important;"><b>' . langS(458, 2,$this->input->post("lang")) . ":</b> " . $value->dates . ' </span><br>'.$str2.'            
                                                    </div>
                                                </td></tr>
                                                ';
                                            }else{
                                                if ($value->description != "") {
                                                    $str .= '<tr>
                                                    <td colspan="6">
                                                    <div class="alert alert-warning" style="margin-top: 0px !important;" role="alert">
                                                         <b>' . langS(327, 2,$this->input->post("lang")) . ":</b> " . $value->description . ' <br>            
                                                    </div>
                                                </td></tr>
                                                ';
                                                } else {
                                                    if ($value->status == 1) {
                                                        $str .= '<tr>
                                                    <td colspan="6">
                                                    <div class="alert alert-warning" style="margin-top: 0px !important;" role="alert">
                                                         <b>' . langS(327, 2,$this->input->post("lang")) . ":</b> " . langS(321, 2,$this->input->post("lang")) . '            
                                                    </div>
                                                </td></tr>
                                                ';
                                                    }
                                                }
                                            }



                                        }

                                    }
                                    $str .= '</tbody>
                                                            </table>';
                                    $str .= '</div>
                                                        </div>';
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
                    redirect(base_url("404"));
                }
            } else {
                addLog("Saldırı Uygulandı.", "getListeMyAds İlanlarım Liste", 3);
                redirect(base_url("404"));
            }
        } else {
            addLog("Saldırı Uygulandı.", "getListeMyAds İlanlarım Liste", 3);
            redirect(base_url("404"));
        }

    }

    public function exportTXT($sipno)
    {
        if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
            if (getActiveUsers()) {
                if ($sipno) {
                    $this->load->model("m_tr_model");
                    $cek = $this->m_tr_model->getTableSingle("table_orders", array("sipNo" => $sipno, "user_id" => getActiveUsers()->id, "status" => 2));
                    if ($cek) {
                        $str = "";
                        $urun = $this->m_tr_model->getTableSingle("table_products", array("id" => $cek->product_id, "status" => 1));
                        if ($cek->codes != "") {
                            $par = explode("**", $cek->codes);
                            $str .= $cek->sipNo . " Nolu " . $urun->p_name . " Ürün için ilgili 'E-Pin Kodu/Kodları aşağıda listelenmiştir.\n";
                            $str .= "-----------------------------------------------------\n";
                            foreach ($par as $item) {
                                $str .= $item . "\n";
                            }
                            $str .= "-----------------------------------------------------\n";
                            $str .= "Bizi Tercih Ettiğiniz için teşekkür ederiz";
                            $file = $cek->sipNo . " Sipariş Epin Listesi.txt";
                            $txt = fopen($file, "w") or die("Unable to open file!");
                            fwrite($txt, $str);
                            fclose($txt);
                            header('Content-Description: File Transfer');
                            header('Content-Disposition: attachment; filename=' . basename($file));
                            header('Expires: 0');
                            header('Cache-Control: must-revalidate');
                            header('Pragma: public');
                            header('Content-Length: ' . filesize($file));
                            header("Content-Type: text/plain");
                            readfile($file);
                        }
                    } else {
                        redirect(base_url());
                    }
                }
            } else {
                redirect(base_url());
            }
        } else {
            addLog("Saldırı Uygulandı.", "exportTXT post", 3);
            redirect(base_url());
        }

    }

    public function userVerification()
    {
        if ($_POST) {
            $this->load->model("m_tr_model");
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                header('Content-Type: application/json');
                $user = getActiveUsers();
                if ($user) {
                    if ($this->input->post("types") == "email") {

                        if ($this->input->post("typesSub") == 1) {
                            if ($user->email == $this->input->post("email")) {
                                if ($user->email_onay == 0) {
                                    if ($user->email_onay_kod != "") {
                                        $tarih = $user->email_onay_send_at;
                                        $newDate = strtotime('1 day', strtotime($tarih));
                                        if ($newDate > strtotime(date("Y-m-d H:i:s"))) {
                                            echo json_encode(array("err" => "aktif", "message" => langS(163, 2)));
                                        } else {
                                            $kod = tokengenerator(8);
                                            $_SESSION["tokenGenerate"] = $kod;
                                            if ($_SESSION["tokenGenerate"]) {
                                                $mailGonder = email_gonder($user->email, "V1 E-Mail Doğrulama Kodu", "", "", 1, base_url("temp-mail/1/" . $kod));
                                                if (!$mailGonder) {
                                                    echo json_encode(array("err" => "mail"));
                                                } else {
                                                    $kaydet = $this->m_tr_model->updateTable("table_users", array("email_onay_kod" => $kod, "email_onay_send_at" => date("Y-m-d H:i:s")), array("id" => $user->id));
                                                    echo json_encode(array("err" => "ok"));
                                                }
                                            } else {
                                                echo json_encode(array("err" => "mail"));
                                            }
                                        }
                                    } else {
                                        $kod = tokengenerator(8);
                                        $_SESSION["tokenGenerate"] = $kod;
                                        if ($_SESSION["tokenGenerate"]) {
                                            $mailGonder = email_gonder($user->email, "V1 E-Mail Doğrulama Kodu", "", "", 1, base_url("temp-mail/1/" . $kod));
                                            if (!$mailGonder) {
                                                echo json_encode(array("err" => "mail"));
                                            } else {
                                                $kaydet = $this->m_tr_model->updateTable("table_users", array("email_onay_kod" => $kod, "email_onay_send_at" => date("Y-m-d H:i:s")), array("id" => $user->id));
                                                echo json_encode(array("err" => "ok"));
                                            }
                                        } else {
                                            echo json_encode(array("err" => "mail"));
                                        }
                                    }

                                } else {
                                    echo json_encode(array("err" => "onayli"));
                                }
                            } else {
                                echo json_encode(array("err" => "emailFail"));
                            }
                        } else {
                            if ($this->input->post("code")) {
                                if ($user->email_onay_kod == trim($this->input->post("code"))) {
                                    $guncelle = $this->m_tr_model->updateTable("table_users", array("email_onay" => 1), array("id" => $user->id));
                                    $rozet = $this->m_tr_model->getTableSingle("table_users_rozets", array("user_id" => $user->id));
                                    $us = getTableSingle("table_users", array("id" => $user->id));
                                    addLog("Email  Doğrulandı.", $us->nick_name . " kullanıcı adlı üye ".$us->email." ile doğrulama işlemini tamamladı.",
                                        1);
                                    if ($rozet) {
                                        $guncelle = $this->m_tr_model->updateTable("table_users_rozets", array("email_trusted" => 1, "email_trusted_at" => date("Y-m-d H:i:s")), array("user_id" => $user->id));
                                    } else {
                                        $kaydet = $this->m_tr_model->add_new(array("user_id" => $user->id, "email_trusted" => 1, "email_trusted_at" => date("Y-m-d H:i:s")), "table_users_rozets");
                                    }
                                    echo json_encode(array("err" => "ok", "message" => langS(166, 2), "messageP" => langS(166, 2) . "<br>" . langS(167, 2) . " " . date("Y-m-d H:i:s")));
                                } else {
                                    $us = getTableSingle("table_users", array("id" => $user->id));
                                    addLog("Email Doğrulama Hatası.", $us->nick_name . " kullanıcı adlı üye ".$us->email." ile hatalı doğrulama gerçekleştirdi.",
                                        1);
                                    echo json_encode(array("err" => "fail", "message" => langS(165, 2)));
                                }
                            }
                        }
                    } else if ($this->input->post("types") == "tc") {
                        if ($this->input->post("tc") && $this->input->post("birth") && $this->input->post("name") && $this->input->post("surname")) {
                            $cekss=getTableSingle("table_users",array("tc" => $this->input->post("tc")));
                            if($cekss){
                                echo json_encode(array("err" => "fail", "message" => "TC Doğrulaması Başarısız."));
                            }else{
                                $tcDogrula = TCDogrula($this->input->post("tc"), $this->input->post("name"), $this->input->post("surname"), $this->input->post("birth"));
                                if ($tcDogrula == 1) {
                                    $guncelle = $this->m_tr_model->updateTable("table_users", array("tc_onay" => 1, "tc" => $this->input->post("tc"),"full_name" => $this->input->post("name") . " " . $this->input->post("surname"), "name" => $this->input->post("name"), "surname" => $this->input->post("surname")), array("id" => $user->id));
                                    $us = getTableSingle("table_users", array("id" => $user->id));
                                    addLog("Tc Kimlik Doğrulandı.", $us->nick_name . " kullanıcı adlı üye " . $this->input->post("name") . " " . $this->input->post("surname") . " ad soyadı ile TC Kimlik Doğrulaması gerçekleştirdi.",
                                        1);
                                    $rozet = $this->m_tr_model->getTableSingle("table_users_rozets", array("user_id" => $user->id));
                                    if ($rozet) {
                                        $guncelle = $this->m_tr_model->updateTable("table_users_rozets", array("tc_trusted" => 1, "tc_trusted_at" => date("Y-m-d H:i:s")), array("user_id" => $user->id));
                                    } else {
                                        $kaydet = $this->m_tr_model->add_new(array("user_id" => $user->id, "tc_trusted" => 1, "tc_trusted_at" => date("Y-m-d H:i:s")), "table_users_rozets");
                                    }
                                    echo json_encode(array("err" => "ok", "message" => langS(170, 2), "messageP" => langS(170, 2) . "<br>" . langS(167, 2) . " " . date("Y-m-d H:i:s")));
                                } else if ($tcDogrula == 2) {
                                    $us = getTableSingle("table_users", array("id" => $user->id));
                                    addLog("Tc Kimlik Doğrulama Hatası.", $us->nick_name . " kullanıcı adlı üye " . $this->input->post("name") . " " . $this->input->post("surname") . " ad soyadı ile TC Kimlik Doğrulaması Başarısız oldu.",
                                        2);
                                    echo json_encode(array("err" => "fail", "message" => langS(171, 2)));
                                } else {
                                    echo json_encode(array("err" => "fail", "message" => langS(38, 2)));
                                }
                            }
                        }else{
                            echo json_encode(array("err" => "fail", "message" => langS(171, 2)));
                        }
                    } else if ($this->input->post("types") == "tel") {
                        $ayarlar=$this->m_tr_model->getTableSingle("table_options_sms",array("id" => 1));

                        if($ayarlar->modul_aktif==1){


                            $this->load->helper("netgsm_helper");
                            if ($this->input->post("typesSub") == 1) {

                                if ($user->tel_onay == 0) {

                                    $kk=$this->m_tr_model->getTableSingle("table_users",array("phone" => $this->input->post("tel")));
                                    if($kk){
                                        echo json_encode(array("err" => "none"));
                                    }else{
                                        if ($user->tel_onay_kod != "") {
                                            $tarih = $user->tel_onay_kod_at;
                                            $newDate = strtotime('3 minutes', strtotime($tarih));
                                            if ($newDate > strtotime(date("Y-m-d H:i:s"))) {
                                                echo json_encode(array("err" => "aktif", "message" => langS(173, 2)));
                                            } else {
                                                $kod = tokengenerator(6, 2);
                                                $_SESSION["tokenGeneratetel"] = $kod;
                                                if ($_SESSION["tokenGeneratetel"]) {
                                                    $tels = $this->input->post("tel");
                                                    $ayar=$this->m_tr_model->getTableSingle("options_general",array("id" => 1));

                                                    $tels = "+9" . str_replace(" ", "", str_replace("-", "", str_replace(")", "", str_replace("(", "", $tels))));
                                                    try {
                                                        $hata = 0;
                                                        $ayar=$this->m_tr_model->getTableSingle("options_general",array("id" => 1));
                                                        $sms = smsGonder($tels, $ayar->site_name." Telefon Doğrulama için gerekli kod:" . $kod);
                                                    } catch (Exception $ex) {
                                                        $hata = 1;
                                                    }
                                                    if ($hata == 1) {
                                                        echo json_encode(array("err" => "api"));
                                                    } else {
                                                        $kaydet = $this->m_tr_model->updateTable("table_users", array("tel_onay_kod" => $kod, "tel_onay_kod_at" => date("Y-m-d H:i:s")), array("id" => $user->id));
                                                        echo json_encode(array("err" => "ok"));
                                                    }
                                                } else {
                                                    echo json_encode(array("err" => "tel"));
                                                }
                                            }
                                        } else {
                                            $kod = tokengenerator(6, 3);
                                            $_SESSION["tokenGeneratetel"] = $kod;
                                            if ($_SESSION["tokenGeneratetel"]) {
                                                try {
                                                    $hata = 0;
                                                    $ayar=$this->m_tr_model->getTableSingle("options_general",array("id" => 1));
                                                    $tels = $this->input->post("tel");
                                                    $gunce=$this->m_tr_model->updateTable("table_users",array("tel_onay_temp" => $tels),array("id" => $user->id));
                                                    $tels = "+9" . str_replace(" ", "", str_replace("-", "", str_replace(")", "", str_replace("(", "", $tels))));
                                                    $sms = smsGonder($tels, $ayar->site_name." Telefon Doğrulama için gerekli kod:" . $kod);
                                                } catch (Exception $ex) {
                                                    $hata = 1;
                                                }
                                                if ($hata == 1) {
                                                    echo json_encode(array("err" => "api"));
                                                } else {
                                                    $kaydet = $this->m_tr_model->updateTable("table_users", array("tel_onay_kod" => $kod, "tel_onay_kod_at" => date("Y-m-d H:i:s")), array("id" => $user->id));
                                                    echo json_encode(array("err" => "ok"));
                                                }
                                            } else {
                                                echo json_encode(array("err" => "tel"));
                                            }
                                        }
                                    }


                                } else {
                                    echo json_encode(array("err" => "onayli"));
                                }

                            }
                            else {
                                if ($this->input->post("code")) {
                                    if ($user->tel_onay_kod == trim($this->input->post("code"))) {
                                        $guncelle = $this->m_tr_model->updateTable("table_users", array("tel_onay" => 1,"phone" => $user->tel_onay_temp), array("id" => $user->id));
                                        $us = getTableSingle("table_users", array("id" => $user->id));
                                        addLog("Telefon Numarası Doğrulandı.", $us->nick_name . " kullanıcı adlı üye ".$us->phone." no'lu telefon ile telefon doğrulama işlemini tamamladı.",
                                            1);
                                        $rozet = $this->m_tr_model->getTableSingle("table_users_rozets", array("user_id" => $user->id));
                                        if ($rozet) {
                                            $guncelle = $this->m_tr_model->updateTable("table_users_rozets", array("phone_trusted" => 1, "phone_trusted_at" => date("Y-m-d H:i:s")), array("user_id" => $user->id));
                                        } else {
                                            $kaydet = $this->m_tr_model->add_new(array("user_id" => $user->id, "phone_trusted" => 1, "phone_trusted_at" => date("Y-m-d H:i:s")), "table_users_rozets");
                                        }
                                        echo json_encode(array("err" => "ok", "message" => langS(172, 2), "messageP" => langS(172, 2) . "<br>" . langS(167, 2) . " " . date("Y-m-d H:i:s")));
                                    } else {
                                        $us = getTableSingle("table_users", array("id" => $user->id));
                                        addLog("Telefon Numarası Doğrulama Hatası.", $us->nick_name . " kullanıcı adlı üye ".$us->phone." no'lu telefon ile telefon doğrulama işlemi sırasında hata meydana geldi..",
                                            2);
                                        echo json_encode(array("err" => "fail", "message" => langS(165, 2)));
                                    }
                                }
                            }


                        }


                    }
                } else {
                    echo json_encode(array("err" => "oturum"));
                }

            } else {
                addLog("Saldırı Uygulandı.", "user_verification", 3);
                redirect(base_url().gg()."404");
            }
        } else {
            addLog("Saldırı Uygulandı.", "user_verification", 3);
            redirect(base_url().gg()."404");
        }
    }

    public function updateProfileSetting()
    {
        $this->load->model("m_tr_model");
        if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
            header('Content-Type: application/json');
            $user = getActiveUsers();
            if ($user) {
                if ($_FILES["profileImage"]["tmp_name"] != "") {
                    $up = img_upload($_FILES["profileImage"], "uye-" . $user->nick_name, "users", "", "", "");
                    if ($up) {
                        $sil = unlink("upload/users/" . $user->image);
                        $guncelle = $this->m_tr_model->updateTable("table_users", array("image" => $up), array("id" => $user->id));
                    }
                }

                if ($_FILES["coverImage"]["tmp_name"] != "") {
                    $up2 = img_upload($_FILES["coverImage"], "uye-kapak-" . $user->nick_name, "users", "", "", "");
                    if ($up2) {
                        $sil2 = unlink("upload/users/" . $user->image_banner);
                        $guncelle2 = $this->m_tr_model->updateTable("table_users", array("image_banner" => $up2), array("id" => $user->id));
                    }
                }

                if ($_FILES["profileImage"]["tmp_name"] != "" && $_FILES["coverImage"]["tmp_name"] != "") {
                    if ($guncelle && $guncelle2 && $up && $up2) {
                        echo json_encode(array("err" => "ok", "image" => base_url("upload/users/" . $up), "image_banner" => base_url("upload/users/" . $up2), "message" => langS(183, 2)));
                    } else {
                        echo json_encode(array("err" => "format", "message" => langS(105, 2)));
                    }
                } else if ($_FILES["profileImage"]["tmp_name"] == "" && $_FILES["coverImage"]["tmp_name"] != "") {
                    if ($guncelle2 && $up2) {
                        echo json_encode(array("err" => "ok", "image_banner" => base_url("upload/users/" . $up2), "message" => langS(183, 2)));
                    } else {
                        echo json_encode(array("err" => "format", "message" => langS(105, 2)));
                    }
                } else if ($_FILES["profileImage"]["tmp_name"] != "" && $_FILES["coverImage"]["tmp_name"] == "") {
                    if ($guncelle && $up) {
                        echo json_encode(array("err" => "ok", "image" => base_url("upload/users/" . $up), "message" => langS(183, 2)));
                    } else {
                        echo json_encode(array("err" => "format", "message" => langS(105, 2)));
                    }
                } else {
                    echo json_encode(array("err" => "ok", "message" => langS(183, 2)));
                }

            } else {
                echo json_encode(array("err" => "oturum"));
            }
        } else {
            addLog("Saldırı Uygulandı.", "updateProfileSetting", 3);
        }
    }

    public function getOrderInfo()
    {
        $this->load->model("m_tr_model");
        if ($_POST) {
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                header('Content-Type: application/json');
                $user = getActiveUsers();
                if ($user) {
                    if ($this->input->post("order")) {
                        $kont = $this->m_tr_model->getTableSingle("table_orders", array("sipNo" => $this->input->post("order")));
                        if ($kont) {
                            $product = $this->m_tr_model->getTableSingle("table_products", array("id" => $kont->product_id, "status" => 1));
                            $red = "";
                            $talepSorgu=getTableSingle("table_talep",array("id" => $kont->id,"advert_id" => $kont->advert_id));
                            if($talepSorgu){
                                echo json_encode(array("type" => 2,"talepid" => $talepSorgu->talepNo, "name" => $product->p_name, "adet" => $kont->quantity, "classs" => $staClass));
                            }else{
                                if ($kont->status == 1) {
                                    $sta = langS(203, 2);
                                    $staClass = "bg-warning";
                                } else if ($kont->status == 3) {
                                    $sta = langS(204, 2);
                                    $staClass = "bg-info";
                                } else if ($kont->status == 5) {
                                    $sta = langS(206, 2);
                                    $staClass = "bg-danger";
                                    if ($kont->iptal_nedeni) {
                                        $red = $kont->iptal_nedeni;
                                    }
                                } else if ($kont->status == 2) {
                                    $sta = langS(207, 2);
                                    $staClass = "bg-info";
                                    $kods = $kont->codes;
                                    if ($kods) {
                                        $par = explode("**", $kods);
                                        foreach ($par as $itemPar) {
                                            $kods2 .= $itemPar . "<br>";
                                        }
                                        rtrim($kods2, "<br>");
                                        $kods2 = str_replace("<br>", "\n\r", $kods2);
                                    }
                                }
                                echo json_encode(array("red" => langS($red, 2), "kods" => $kods2, "status2" => $kont->status, "price" => $kont->total_price . " " . getcur(), "name" => $product->p_name, "adet" => $kont->quantity, "tarih" => $kont->created_at, "status" => $sta, "no" => $kont->sipNo, "classs" => $staClass));
                            }

                        }
                    }
                } else {
                    echo json_encode(array("err" => "oturum"));
                }

            } else {
                addLog("Saldırı Uygulandı.", "getOrderInfo", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "getOrderInfo POST", 3);

        }
    }

    public function getAdsOrderInfo()
    {
        $this->load->model("m_tr_model");
        if ($_POST) {
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                header('Content-Type: application/json');
                $user = getActiveUsers();
                if ($user) {
                    if ($this->input->post("order")) {
                        $cevir=str_replace("-ST-45","",str_replace("12-","",strrev($this->input->post("order"))));
                        $kont = $this->m_tr_model->getTableSingle("table_orders_adverts", array("id" => $cevir));
                        if ($kont) {
                            $product = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $kont->advert_id));
                            if($product){
                                $cek = $this->m_tr_model->getTableSingle("table_talep", array("order_id" => $kont->id,"advert_id" => $product->id));
                                if($cek){
                                    echo json_encode(array("err" => true, "message" => "var", "status" => $kont->status, "talepNo" => "T-S-".$cek->id,"name" => $product->ad_name, "talep" => $kont->message, "date" => $kont->created_at, "update_at" => $kont->update_at));
                                }else{
                                    $red = "";
                                    $sta="";
                                    if ($kont->status == 0) {
                                        $sta = langS(349, 2,$this->input->post("lang"));
                                        $staClass = "bg-warning";
                                    } else if ($kont->status == 1) {
                                        $sta = langS(350, 2,$this->input->post("lang"));
                                        $staClass = "bg-info";
                                    } else if ($kont->status == 4) {
                                        $sta = langS(239, 2,$this->input->post("lang"));
                                        $staClass = "bg-danger";
                                        if ($kont->red_nedeni) {
                                            $red = $kont->red_nedeni;
                                        }
                                    } else if ($kont->status == 2) {
                                        $sta = langS(380, 2,$this->input->post("lang"));
                                        $staClass = "bg-primary";
                                    }else if ($kont->status == 3) {
                                        $sta = langS(352, 2,$this->input->post("lang"));
                                        $staClass = "bg-success";
                                    }
                                    echo json_encode(array("red" => $red, "status2" => $kont->status, "price" => $kont->price_total . " " . getcur(), "name" => $product->ad_name, "adet" => $kont->quantity, "tarih" => $kont->created_at, "status" => $sta, "no" => $kont->sipNo, "classs" => $staClass));

                                }

                            }else{

                            }

                        }
                    }
                } else {
                    echo json_encode(array("err" => "oturum"));
                }

            } else {
                addLog("Saldırı Uygulandı.", "getOrderInfo", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "getOrderInfo POST", 3);

        }
    }

    public function addAdsOrderComments()
    {

        if ($_POST) {
            $this->load->model("m_tr_model");

            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                $user = getActiveUsers();

                header('Content-Type: application/json');
                if ($user) {

                    if ($this->input->post("type") && $this->input->post("sipToken")) {

                        $tok = str_replace("12-","",str_replace("-ST-45","",strrev($this->input->post("sipToken"))));
                        $sorgu = $this->m_tr_model->getTableSingle("table_orders_adverts", array("id" => $tok));
                        if ($sorgu) {

                            $urun = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $sorgu->advert_id, "status" => 4));
                            if ($urun) {
                                if($sorgu->type==1){
                                    $bilgi = $this->m_tr_model->getTableSingle("table_comments", array("order_advert_id" => $sorgu->id));
                                    if ($bilgi) {
                                        $ll = getLangValue($urun->id, "table_adverts",$this->input->post("lang"));
                                        $ad=$ll->name;
                                        if($ad==""){
                                            $ll = getLangValue($urun->id, "table_adverts",1);
                                            $ad=$ll->name;
                                        }
                                        echo json_encode(array("err" => false, "name" => "<i class='mdi mdi-arrow-right'></i> " . $ad, "update" => $bilgi->update_at, "date" => $bilgi->created_at, "comment" => $bilgi->comment,
                                            "puan" => $bilgi->puan, "status" => $bilgi->status));
                                    }
                                }else{
                                    if ($sorgu->comment_id == 0) {
                                        $ll = getLangValue($urun->id, "table_adverts",$this->input->post("lang"));
                                        $ad=$ll->name;
                                        if($ad==""){
                                            $ll = getLangValue($urun->id, "table_adverts",1);
                                            $ad=$ll->name;
                                        }
                                        echo json_encode(array("err" => false, "name" => "<i class='mdi mdi-arrow-right'></i> " . $ad. "  <span class='text-white; font-size:10pt !important; '>#" . $sorgu->sipNo . "</span>"));
                                    }else{
                                        $bilgi = $this->m_tr_model->getTableSingle("table_comments", array("id" => $sorgu->comment_id));
                                        if ($bilgi) {

                                            $ll = getLangValue($urun->id, "table_adverts",$this->input->post("lang"));
                                            $ad=$ll->name;
                                            if($ad==""){
                                                $ll = getLangValue($urun->id, "table_adverts",1);
                                                $ad=$ll->name;
                                            }
                                            echo json_encode(array("err" => false, "name" => "<i class='mdi mdi-arrow-right'></i> " . $ad, "update" => $bilgi->update_at, "date" => $bilgi->created_at, "comment" => $bilgi->comment,
                                                "puan" => $bilgi->puan, "status" => $bilgi->status));
                                        }
                                    }
                                }

                            } else {

                                echo json_encode(array("err" => true, "message" => langS(38, 2)));
                            }
                        } else {

                            echo json_encode(array("err" => true, "message" => langS(38, 2)));
                        }
                    } else {
                        if ($this->input->post("comment") && $this->input->post("puan")  && $this->input->post("sipToken")) {
                            $temizle = str_replace("12-","",str_replace("-ST-45","",strrev($this->input->post("sipToken"))));

                            $sorgu = $this->m_tr_model->getTableSingle("table_orders_adverts", array("id" => $temizle));
                            if ($sorgu) {

                                $ilan=$this->m_tr_model->getTableSingle("table_adverts", array("id" => $sorgu->advert_id));
                                if($ilan){
                                    if ($sorgu->comment_id == 0) {
                                        $ekle = $this->m_tr_model->add_new(array(
                                            "order_advert_id" => $sorgu->id,
                                            "advert_id" => $ilan->id,
                                            "user_id" => $user->id,
                                            "sell_user_id"  => $ilan->user_id,
                                            "comment" => htmlspecialchars($this->security->xss_clean($this->input->post("comment"))),
                                            "puan" => $this->input->post("puan"),
                                            "created_at" => date("Y-m-d H:i:s")
                                        ), "table_comments");
                                        if ($ekle) {
                                            $guncelle = $this->m_tr_model->updateTable("table_orders_adverts", array("comment_id" => $ekle), array("id" => $sorgu->id));
                                            echo json_encode(array("err" => false, "message" => "<i class='mdi mdi-check'></i> " . langS(237, 2)));
                                        } else {
                                            echo json_encode(array("err" => true, "message" => langS(38, 2)));
                                        }
                                    }else{
                                        $c = $this->m_tr_model->getTableSingle("table_comments", array("id" => $sorgu->comment_id));
                                        if ($c) {
                                            if ($c->status == 3) {
                                                $guncelle = $this->m_tr_model->updateTable("table_comments", array(
                                                    "order_id" => 0,
                                                    "advert_id" => $ilan->id,
                                                    "sell_user_id"  => $ilan->user_id,
                                                    "order_advert_id" => $sorgu->id,
                                                    "user_id" => $user->id,
                                                    "comment" => htmlspecialchars($this->security->xss_clean($this->input->post("comment"))),
                                                    "puan" => $this->input->post("puan"),
                                                    "status" => 1
                                                ), array("id" => $c->id));
                                                echo json_encode(array("err" => false, "message" => "<i class='mdi mdi-check'></i> " . langS(237, 2)));
                                            } else {
                                                echo json_encode(array("err" => true, "message" => langS(38, 2)));
                                            }
                                        } else {
                                            echo json_encode(array("err" => true, "message" => langS(38, 2)));
                                        }
                                    }
                                }else{
                                    echo json_encode(array("err" => true, "message" => langS(171, 2)));
                                }

                            } else {
                                echo json_encode(array("err" => true, "message" => langS(38, 2)));
                            }
                        } else {
                            echo json_encode(array("err" => true, "message" => langS(38, 2)));
                        }
                    }
                } else {
                    echo json_encode(array("err" => true, "message" => "oturum"));
                }
            } else {
                addLog("Saldırı Uygulandı.", "addadsOrderComments", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "addadsOrderComments", 3);
        }
    }

    public  function addOrderComments()
    {
        if ($_POST) {
            $this->load->model("m_tr_model");
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                $user = getActiveUsers();
                header('Content-Type: application/json');
                if ($user) {
                    if ($this->input->post("type") && $this->input->post("sipToken")) {
                        $tok = $this->input->post("sipToken");
                        $temizle = str_replace("-DS", "", str_replace("SR-", "", $tok));
                        $sorgu = $this->m_tr_model->getTableSingle("table_orders", array("sipNo" => $temizle));
                        if ($sorgu) {
                            $urun = $this->m_tr_model->getTableSingle("table_products", array("id" => $sorgu->product_id, "status" => 1));
                            if ($urun) {
                                if ($sorgu->comment_id == 0) {
                                    $ll = getLangValue($urun->id, "table_products");
                                    echo json_encode(array("err" => false, "name" => "<i class='mdi mdi-arrow-right'></i> " . $ll->name . "  <span class='text-white; font-size:10pt !important; '>#" . $sorgu->sipNo . "</span>"));
                                } else {
                                    $bilgi = $this->m_tr_model->getTableSingle("table_comments", array("id" => $sorgu->comment_id));
                                    if ($bilgi) {

                                        $ll = getLangValue($urun->id, "table_products");
                                        echo json_encode(array("err" => false, "name" => "<i class='mdi mdi-arrow-right'></i> " . $ll->name, "update" => $bilgi->update_at, "date" => $bilgi->created_at, "comment" => $bilgi->comment,
                                            "puan" => $bilgi->puan, "status" => $bilgi->status));
                                    }
                                }
                            } else {
                                echo json_encode(array("err" => true, "message" => langS(38, 2)));
                            }
                        } else {
                            echo json_encode(array("err" => true, "message" => langS(38, 2)));
                        }
                    } else {
                        if ($this->input->post("comment") && $this->input->post("puan") && $this->input->post("sipToken")) {
                            $tok = $this->input->post("sipToken");
                            $temizle = str_replace("-DS", "", str_replace("SR-", "", $tok));
                            $sorgu = $this->m_tr_model->getTableSingle("table_orders", array("sipNo" => $temizle));
                            if ($sorgu) {
                                if (is_numeric($this->input->post("puan"))) {
                                    if ($sorgu->comment_id == 0) {
                                        $ekle = $this->m_tr_model->add_new(array(
                                            "order_id" => $sorgu->id,
                                            "user_id" => $user->id,
                                            "comment" => htmlspecialchars($this->security->xss_clean($this->input->post("comment"))),
                                            "puan" => $this->input->post("puan"),
                                            "created_at" => date("Y-m-d H:i:s")
                                        ), "table_comments");
                                        if ($ekle) {
                                            $guncelle = $this->m_tr_model->updateTable("table_orders", array("comment_id" => $ekle), array("id" => $sorgu->id));
                                            echo json_encode(array("err" => false, "message" => "<i class='mdi mdi-check'></i> " . langS(237, 2)));
                                        } else {
                                            echo json_encode(array("err" => true, "message" => langS(38, 2)));
                                        }
                                    } else {
                                        $c = $this->m_tr_model->getTableSingle("table_comments", array("id" => $sorgu->comment_id));
                                        if ($c) {
                                            if ($c->status == 3) {
                                                $guncelle = $this->m_tr_model->updateTable("table_comments", array(
                                                    "order_id" => $sorgu->id,
                                                    "user_id" => $user->id,
                                                    "comment" => htmlspecialchars($this->security->xss_clean($this->input->post("comment"))),
                                                    "puan" => $this->input->post("puan"),
                                                    "status" => 1
                                                ), array("id" => $c->id));
                                                echo json_encode(array("err" => false, "message" => "<i class='mdi mdi-check'></i> " . langS(237, 2)));
                                            } else {
                                                echo json_encode(array("err" => true, "message" => langS(38, 2)));
                                            }
                                        } else {
                                            echo json_encode(array("err" => true, "message" => langS(38, 2)));
                                        }

                                    }
                                } else {
                                    echo json_encode(array("err" => true, "message" => langS(171, 2)));
                                }
                            } else {
                                echo json_encode(array("err" => true, "message" => langS(38, 2)));
                            }
                        } else {
                            echo json_encode(array("err" => true, "message" => langS(38, 2)));
                        }
                    }
                } else {
                    echo json_encode(array("err" => true, "message" => "oturum"));
                }
            } else {
                addLog("Saldırı Uygulandı.", "addOrderComments", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "addOrderComments", 3);
        }
    }

    public function addOrderTalep()
    {
        if ($_POST) {
            $this->load->model("m_tr_model");
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                $user = getActiveUsers();
                header('Content-Type: application/json');
                if ($user) {
                    if ($this->input->post("type")) {
                        $kkontrol = $this->m_tr_model->getTableSingle("table_orders", array("sipNo" => $this->input->post("sips")));
                        if ($kkontrol) {
                            $cek = $this->m_tr_model->getTableSingle("table_talep", array("order_id" => $kkontrol->id));
                            if ($cek) {
                                if ($kkontrol->code_id != "") {

                                } else {
                                    //kontrol
                                    echo json_encode(array("err" => false, "message" => langS(259, 2), "status" => $cek->status, "talepNo" => "#T-S-" . $cek->id, "talep" => $cek->message, "date" => $cek->created_at, "up_date" => $cek->update_at));
                                }
                            } else {
                                echo json_encode(array("err" => true, "message" => "var"));
                            }
                        }
                    } else {
                        if ($this->input->post("sips") && $this->input->post("talep")) {
                            $talep = $this->security->xss_clean($this->input->post("talep"));
                            $sip = $this->security->xss_clean($this->input->post("sips"));
                            $cek = $this->m_tr_model->getTableSingle("table_orders", array("sipNo" => $sip));
                            if ($cek) {
                                $kkontrol = $this->m_tr_model->getTableSingle("table_talep", array("order_id" => $cek->id));
                                if ($kkontrol) {
                                    if ($kkontrol->code_id != "") {

                                    } else {
                                        //kontrol
                                        echo json_encode(array("err" => true, "message" => "var", "status" => $kkontrol->status, "talepNo" => "#T-S-" . $kkontrol->id, "talep" => $kkontrol->message, "date" => $kkontrol->created_at, "up_date" => $kkontrol->update_at));
                                    }
                                } else {
                                    $kaydet = $this->m_tr_model->add_new(array(
                                        "user_id" => $user->id,
                                        "order_id" => $cek->id,
                                        "message" => $talep,
                                        "product_id" => $cek->product_id,
                                        "created_at" => date("Y-m-d H:i:s")
                                    ), "table_talep");
                                    if ($kaydet) {
                                        $talepNO = "#T-S-" . $kaydet;
                                        $guncelle = $this->m_tr_model->updateTable("table_talep", array("talepNo" => $talepNO), array("id" => $kaydet));
                                        echo json_encode(array("err" => false, "message" => langS(258, 2), "talepNo" => $talepNO));
                                    } else {
                                        echo json_encode(array("err" => true, "message" => langS(38, 2)));
                                    }
                                }


                            } else {
                                echo json_encode(array("err" => true, "message" => "oturum"));
                            }
                        }
                    }

                } else {
                    echo json_encode(array("err" => true, "message" => "oturum"));
                }
            } else {
                addLog("Saldırı Uygulandı.", "addOrderTalep", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "addOrderTalep", 3);
        }
    }

    public function addOrderTalepAds()
    {
        if ($_POST) {
            $this->load->model("m_tr_model");
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                $user = getActiveUsers();
                header('Content-Type: application/json');
                if ($user) {
                    if ($this->input->post("type")) {
                        $kkontrol = $this->m_tr_model->getTableSingle("table_orders_adverts", array("sipNo" => $this->input->post("sipToken")));
                        if ($kkontrol) {
                            $cek = $this->m_tr_model->getTableSingle("table_talep", array("order_id" => $kkontrol->id));
                            if ($cek) {
                                if ($kkontrol->code_id != "") {

                                } else {

                                    echo json_encode(array("err" => false, "message" => langS(259, 2), "status" => $cek->status, "talepNo" => "#T-S-" . $cek->id, "talep" => $cek->message, "date" => $cek->created_at, "up_date" => $cek->update_at));
                                }
                            } else {
                                echo json_encode(array("err" => true, "message" => "var"));
                            }
                        }
                    } else {
                        if ($this->input->post("sipToken") && $this->input->post("talep")) {
                            $talep = $this->security->xss_clean($this->input->post("talep"));
                            $sip = $this->security->xss_clean($this->input->post("sipToken"));
                            $cek = $this->m_tr_model->getTableSingle("table_orders_adverts", array("sipNo" => $sip));
                            if ($cek) {
                                $kkontrol = $this->m_tr_model->getTableSingle("table_talep", array("order_id" => $cek->id,"advert_id" => $cek->advert_id));
                                if ($kkontrol) {
                                    echo json_encode(array("err" => true, "message" => "var", "status" => $kkontrol->status, "talepNo" => $kkontrol->talepNo, "talep" => $kkontrol->message, "date" => $kkontrol->created_at, "update_at" => $kkontrol->update_at));
                                } else {
                                    $kaydet = $this->m_tr_model->add_new(array(
                                        "user_id" => $user->id,
                                        "order_id" => $cek->id,
                                        "advert_id" => $cek->advert_id,
                                        "message" => $talep,
                                        "created_at" => date("Y-m-d H:i:s")
                                    ), "table_talep");
                                    if ($kaydet) {
                                        $talepNO = "#T-S-" . $kaydet;
                                        $guncelle = $this->m_tr_model->updateTable("table_talep", array("talepNo" => $talepNO), array("id" => $kaydet));
                                        echo json_encode(array("err" => false, "message" => langS(258, 2), "talepNo" => $talepNO));
                                    } else {
                                        echo json_encode(array("err" => true, "message" => langS(38, 2)));
                                    }
                                }
                            } else {
                                echo json_encode(array("err" => true, "message" => "oturum"));
                            }
                        }
                    }

                } else {
                    echo json_encode(array("err" => true, "message" => "oturum"));
                }
            } else {
                addLog("Saldırı Uygulandı.", "addOrderTalep", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "addOrderTalep", 3);
        }
    }

    public function talepMessageAdd()
    {
        if ($_POST) {
            $this->load->model("m_tr_model");
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                $user = getActiveUsers();

                if ($user) {
                    if ($this->input->post("types")) {
                        if ($this->input->post("talep")) {
                            $talep = $this->security->xss_clean($this->input->post("talep"));
                            $kkontrol = $this->m_tr_model->getTableSingle("table_talep", array("talepNo" => $talep));
                            if ($kkontrol) {
                                header('Content-Type: application/json');
                                $str = "";
                                $str .= '<li class="clearfix">
                                    <div class="message-data text-right">';

                                $tarih1 = new DateTime($kkontrol->created_at);
                                $tarih2 = new DateTime();
                                $interval = $tarih2->diff($tarih1);
                                $fark = "";
                                if ($interval->format('%a') > 0) {
                                    $fark = " - " . $interval->format('%a ' . langS(93, 2,$this->input->post("lang")) . " " . langS(274, 2,$this->input->post("lang")));
                                } else {
                                    $fark = " - " . langS(275, 2,$this->input->post("lang"));
                                }
                                if($user->image==""){

                                    $str .= '<span class="message-data-time">' . date("H:i", strtotime($kkontrol->created_at)) . $fark . '</span>
                                      <img src="' . base_url("assets/images/profilepic.png") . '" alt="avatar">
                                    </div>
                                    <div class="message other-message float-right">' . $kkontrol->message . '</div>
                                </li>';
                                }else{
                                    $str .= '<span class="message-data-time">' . date("H:i", strtotime($kkontrol->created_at)) . $fark . '</span>
                                        <img src="' . base_url("upload/users/" . $user->image) . '" alt="avatar">
                                    </div>
                                    <div class="message other-message float-right">' . $kkontrol->message . '</div>
                                </li>';
                                }

                                $cekSohbet = getTableOrder("table_talep_message", array("talep_id" => $kkontrol->id), "created_at", "asc");
                                if ($cekSohbet) {
                                    foreach ($cekSohbet as $item) {
                                        $tarih1 = new DateTime($item->created_at);
                                        $tarih2 = new DateTime();
                                        $interval = $tarih2->diff($tarih1);
                                        $fark = "";
                                        if ($interval->format('%a') > 0) {
                                            $fark = " - " . $interval->format('%a ' . langS(93, 2,$this->input->post("lang")) . " " . langS(274, 2,$this->input->post("lang")));
                                        } else {
                                            $fark = " - " . langS(275, 2,$this->input->post("lang"));
                                        }
                                        if ($item->tur == 1) {
                                            $str .= '<li class="clearfix">
                                                <div class="message-data">
                                                    <img src="' . base_url("assets/images/favicon.png") . '" alt="avatar">
                                                    <span class="message-data-time">' . date("H:i", strtotime($item->created_at)) . $fark . '</span>
                                                </div>
                                                <div class="message my-message">' . $item->message . '</div>
                                            </li>';

                                        } else {
                                            if($user->image==""){
                                                $str .= '<li class="clearfix">
                                                <div class="message-data text-right">
                                                    <span class="message-data-time">' . date("H:i", strtotime($item->created_at)) . $fark . '</span>
                                                    <img src="' . base_url("assets/images/profilepic.png") . '" alt="avatar">
                                                </div>
                                                <div class="message other-message float-right">' . $item->message . '</div>
                                            </li>';
                                            }else{
                                                $str .= '<li class="clearfix">
                                                <div class="message-data text-right">
                                                    <span class="message-data-time">' . date("H:i", strtotime($item->created_at)) . $fark . '</span>
                                                    <img src="' . base_url("upload/users/" . $user->image) . '" alt="avatar">
                                                </div>
                                                <div class="message other-message float-right">' . $item->message . '</div>
                                            </li>';
                                            }


                                        }
                                    }
                                    echo json_encode(array("veri" => $str, "status" => $kkontrol->status));
                                } else {

                                }
                            }
                        } else {
                            echo json_encode(array("err" => true, "message" => "oturum"));
                        }
                    } else {
                        header('Content-Type: application/json');
                        if ($this->input->post("talep") && $this->input->post("mesaj")) {
                            $talep = $this->security->xss_clean($this->input->post("talep"));
                            $mesaj = $this->security->xss_clean($this->input->post("mesaj"));
                            $kkontrol = $this->m_tr_model->getTableSingle("table_talep", array("talepNo" => $talep));
                            if ($kkontrol) {
                                if ($kkontrol->status == 0 || $kkontrol->status == 1 || $kkontrol->status == 2 || $kkontrol->status == 4) {

                                    $sorgula = $this->m_tr_model->getTableOrder("table_talep_message", array("talep_id" => $kkontrol->id), "id", "desc",3);
                                    if ($sorgula) {

                                        foreach ($sorgula as $ss) {
                                            if ($s <= 3) {
                                                if ($ss->tur != 1) {
                                                    $us++;
                                                }
                                            }
                                            $s++;
                                        }
                                    }
                                    if ($us < 3) {
                                        $kaydet = $this->m_tr_model->add_new(array(
                                            "talep_id" => $kkontrol->id,
                                            "tur" => 2,
                                            "message" => $mesaj,
                                            "status" => 2,
                                            "created_at" => date("Y-m-d H:i:s")
                                        ), "table_talep_message");
                                        if ($kaydet) {
                                            $guncelle = $this->m_tr_model->updateTable("table_talep", array("status" => 2, "update_at" => date("Y-m-d H:i:s")), array("id" => $kkontrol->id));
                                            echo json_encode(array("err" => false, "message" => langS(278, 2,$this->input->post("lang")), "status" => 2));
                                        } else {
                                            echo json_encode(array("err" => true, "message" => langS(38, 2,$this->input->post("lang"))));
                                        }
                                    } else {
                                        echo json_encode(array("err" => true, "message" => langS(440,2,$this->input->post("lang"))));
                                    }

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
                addLog("Saldırı Uygulandı.", "addOrderTalep", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "addOrderTalep", 3);
        }
    }





    //banka ekleme güncelleme
    public function bankSaveUpdate()
    {
        if ($_POST) {
            header('Content-Type: application/json');
            $this->load->model("m_tr_model");
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                $user = getActiveUsers();
                if ($user) {
                    if ($this->input->post("digit") && $this->input->post("digit") == 2) {
                        if ($this->input->post("bankaHesap")) {
                            $kontrol = $this->m_tr_model->getTableSingle("table_user_bank", array("id" => str_replace("cr-", "", $this->input->post("bankaHesap")), "user_id" => $user->id));
                            if ($kontrol) {
                                $cek = $this->m_tr_model->getTableSingle("table_options", array("id" => 1));
                                $tutar = $this->security->xss_clean($this->input->post("tutar"));
                                if ($tutar) {
                                    if (is_numeric($tutar) && $tutar >= $cek->cekim_alt_limit && $tutar <= $user->ilan_balance) {
                                        $token = tokengenerator(10, 1);
                                        $kaydet = $this->m_tr_model->add_new(array(
                                            "bank_id" => $kontrol->id,
                                            "tokenNo" => $token,
                                            "tutar" => $tutar,
                                            "bank_name" => $kontrol->banka_adi,
                                            "bank_iban" => $kontrol->banka_iban,
                                            "bank_user" => $kontrol->banka_sahip,
                                            "created_at" => date("Y-m-d H:i:s"),
                                            "user_id" => $user->id
                                        ), "table_user_ads_with");
                                        if ($kaydet) {
                                            addLog("Yeni Bakiye Çekim Talebi",$token . " no'lu " . $tutar . " ".getcur(). " tutarında bakiye çekim talebinde bulundu.", 1);

                                            echo json_encode(array("err" => false, "message" => langS(314, 2,$this->input->post("lang"))));
                                        } else {
                                            echo json_encode(array("err" => true, "message" => langS(38, 2,$this->input->post("lang"))));
                                        }
                                    } else {
                                        echo json_encode(array("err" => true, "message" => langS(313, 2,$this->input->post("lang"))));
                                    }
                                }
                            } else {
                                echo json_encode(array("err" => true, "message" => langS(38, 2,$this->input->post("lang"))));
                            }
                        } else {
                            $bank = $this->security->xss_clean($this->input->post("bankName"));
                            $sahip = $this->security->xss_clean($this->input->post("sahip"));
                            $iban = $this->security->xss_clean($this->input->post("iban"));
                            $tutar = $this->security->xss_clean($this->input->post("tutar"));
                            if ($bank && $sahip && $iban && $tutar) {
                                if (is_numeric($tutar)) {
                                    if (strlen($iban) == 32) {
                                        $cek = $this->m_tr_model->getTableSingle("table_options", array("id" => 1));
                                        if ($cek->cekim_alt_limit <= $tutar) {
                                            if ($user->ilan_balance > $tutar) {
                                                $token = tokengenerator(10, 1);
                                                $kaydet = $this->m_tr_model->add_new(array(
                                                    "bank_id" => 0,
                                                    "tokenNo" => $token,
                                                    "bank_name" => $bank,
                                                    "bank_iban" => $iban,
                                                    "bank_user" => $sahip,
                                                    "tutar" => $tutar,
                                                    "created_at" => date("Y-m-d H:i:s"),
                                                    "user_id" => $user->id
                                                ), "table_user_ads_with");
                                                if ($kaydet) {

                                                    addLog("Yeni Bakiye Çekim Talebi",$token . " no'lu " . $tutar  . " ".getcur(). " tutarında bakiye çekim talebinde bulundu.", 1);
                                                    echo json_encode(array("err" => false, "message" => langS(314, 2,$this->input->post("lang"))));
                                                } else {
                                                    echo json_encode(array("err" => true, "message" => langS(38, 2,$this->input->post("lang"))));
                                                }
                                            } else {
                                                echo json_encode(array("err" => true, "message" => langS(313, 2,$this->input->post("lang"))));
                                            }
                                        } else {
                                            echo json_encode(array("err" => true, "message" => langS(313, 2,$this->input->post("lang"))));
                                        }
                                    } else {
                                        echo json_encode(array("err" => true, "message" => langS(171, 2,$this->input->post("lang"))));
                                    }
                                } else {
                                    echo json_encode(array("err" => true, "message" => langS(171, 2,$this->input->post("lang"))));
                                }
                            } else {
                                echo json_encode(array("err" => true, "message" => langS(171, 2,$this->input->post("lang"))));
                            }
                        }
                    } else {
                        if ($this->input->post("types")) {
                            if ($this->input->post("guncelle")) {
                                $kont = $this->m_tr_model->getTableSingle("table_user_bank", array("id" => $this->security->xss_clean(str_replace("cr-", "", $this->input->post("guncelle"))), "user_id" => $user->id));
                                if ($kont) {
                                    if ($this->input->post("types") == 1) {
                                        echo json_encode(array("err" => false, "message" => $kont->banka_adi, "sil" => "cr-" . $kont->id));
                                    } else if ($this->input->post("types") == 5) {
                                        echo json_encode(array("err" => false, "name" => $kont->banka_adi, "iban" => $kont->banka_iban, "sahip" => $kont->banka_sahip));
                                    } else {
                                        $guncelle = $this->m_tr_model->updateTable("table_user_bank", array(
                                            "deleted" => 1
                                        ), array("id" => $kont->id));
                                        if ($guncelle) {
                                            addLog("Banka Hesabı Silindi",$kont->banka_adi . " adlı banka hesabı silindi", 1);
                                            echo json_encode(array("err" => false, "message" => langS(306, 2,$this->input->post("lang"))));
                                        } else {
                                            echo json_encode(array("err" => true, "message" => langS(38, 2,$this->input->post("lang"))));
                                        }
                                    }

                                } else {
                                    echo json_encode(array("err" => "oturum"));
                                }
                            } else {
                                echo json_encode(array("err" => "oturum"));
                            }
                        } else {
                            if ($this->input->post("bankaName") && $this->input->post("accName") && $this->input->post("iban")) {
                                $bank = $this->security->xss_clean($this->input->post("bankaName"));
                                $name = $this->security->xss_clean($this->input->post("accName"));
                                $iban = $this->security->xss_clean($this->input->post("iban"));
                                if ($this->input->post("guncelle")) {
                                    $kont = $this->m_tr_model->getTableSingle("table_user_bank", array("id" => $this->security->xss_clean(str_replace("cr-", "", $this->input->post("guncelle"))), "user_id" => $user->id));
                                    if ($kont) {
                                        $guncelle = $this->m_tr_model->updateTable("table_user_bank", array(
                                            "banka_adi" => $bank,
                                            "banka_iban" => $iban,
                                            "banka_sahip" => $name,
                                            "status" => $this->input->post("status")
                                        ), array("id" => $kont->id));
                                        if ($guncelle) {
                                            addLog("Banka Hesabı Güncellendi",$bank . " adlı banka hesabı güncellendi", 1);
                                            echo json_encode(array("err" => false, "message" => langS(303, 2,$this->input->post("lang"))));
                                        } else {
                                            echo json_encode(array("err" => true, "message" => langS(38, 2,$this->input->post("lang"))));
                                        }
                                    } else {
                                        echo json_encode(array("err" => "oturum"));
                                    }
                                } else {
                                    $kaydet = $this->m_tr_model->add_new(array(
                                        "user_id" => $user->id,
                                        "banka_adi" => $bank,
                                        "banka_iban" => $iban,
                                        "banka_sahip" => $name,
                                        "created_at" => date("Y-m-d H:i:s")
                                    ), "table_user_bank");
                                    if ($kaydet) {
                                        addLog("Yeni bir banka hesabı ekledi.", $bank." Adlı banka hesabı eklendi", 1);
                                        echo json_encode(array("err" => false, "message" => langS(299, 2,$this->input->post("lang"))));
                                    } else {
                                        echo json_encode(array("err" => true, "message" => langS(38, 2,$this->input->post("lang"))));
                                    }
                                }
                            } else {
                                echo json_encode(array("err" => true, "message" => "oturum"));
                            }
                        }
                    }
                } else {
                    echo json_encode(array("err" => "oturum"));
                }
            } else {
                addLog("Saldırı Uygulandı.", "bankSaveUpdate", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "bankSaveUpdate", 3);
        }
    }

    public
    function getCategorySelect()
    {
        try {
            if ($_POST) {
                $kat = "";
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    if ($this->input->post("types") == 1) {
                        if ($this->input->post("val") && is_numeric($this->input->post("val"))) {
                            $kat .= "<option value=''>" . langS(36, 2) . "</option>";
                            $cek = getTableSingle("table_advert_category", array("id" => $this->input->post("val"), "parent_id" => 0, "top_id" => 0, "status" => 1));
                            if ($cek) {
                                $kats = $this->m_tr_model->getTableOrder("table_advert_category", array("top_id" => $cek->id, "parent_id" => 0), "name", "asc");
                                if ($kats) {
                                    foreach ($kats as $item) {
                                        $ll = getLangValue($item->id, "table_advert_category");
                                        $kat .= "<option value='" . $item->id . "'>" . $ll->name . "</option>";
                                    }
                                } else {
                                    $kat = false;
                                }
                                echo json_encode(array("kat" => $kat));
                            }

                        }
                    } else if ($this->input->post("types") == 2) {
                        if ($this->input->post("val") && is_numeric($this->input->post("val"))) {
                            $kat .= "<option value=''>" . langS(36, 2) . "</option>";
                            $cek = getTableSingle("table_advert_category", array("id" => $this->input->post("val"), "top_id !=" => 0, "parent_id" => 0, "status" => 1));
                            if ($cek) {
                                $kats = $this->m_tr_model->getTableOrder("table_advert_category", array("top_id" => $cek->top_id, "parent_id" => $cek->id), "name", "asc");
                                if ($kats) {
                                    foreach ($kats as $item) {
                                        $ll = getLangValue($item->id, "table_advert_category");
                                        $kat .= "<option value='" . $item->id . "'>" . $ll->name . "</option>";
                                    }
                                } else {
                                    $kat = false;
                                }


                                $special = getTableOrder("table_adverts_category_special", array("p_id" => $cek->id, "status" => 1), "order_id", "asc");
                                $specialStr = "";
                                if ($special) {
                                    foreach ($special as $item) {
                                        $rq = "";
                                        if ($item->is_required == 1) {
                                            $rq = "required";
                                        } else {
                                            $rq = "";
                                        }
                                        $getLangSpe = getLangValue($item->id, "table_adverts_category_special");
                                        if ($item->type == 1) {
                                            $specialStr .= ' <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="formLabel" for="">' . $getLangSpe->name . '</label>
                                                                        <input type="text" class="' . $rq . '" id="sp-' . $item->id . '" name="sp_' . $item->id . '" placeholder="' . $getLangSpe->name . '">
                                                                    </div>
                                                                </div>';
                                        } else {
                                            $secenek = $getLangSpe->secenek;
                                            if ($secenek) {
                                                $secenek = explode(",", $secenek);
                                                $specialStr .= '<div class="col-lg-4">
                                                                    <div class="form-group"> 
                                                                        <label class="formLabel" for="">' . $getLangSpe->name . '</label>
                                                                        <select class="' . $rq . ' selectCustom" name="sp_' . $item->id . '"><option value="">Seçiniz</option>';
                                                $sira = 0;
                                                foreach ($secenek as $items) {
                                                    $specialStr .= '<option value="sp-' . $sira . '">' . $items . '</option>';
                                                    $sira++;
                                                }
                                                $specialStr .= "</select></div></div>";
                                            }
                                        }
                                    }
                                }

                                $resimText = "";
                                $resimler = getTableOrder("table_adverts_image", array("status" => 1, "category" => $cek->id), "order_id", "asc");
                                if ($resimler) {
                                    foreach ($resimler as $itemResim) {
                                        $resimText .= '<div class="col-6 col-lg-3 mt-2">
                                                            <div class="i-box">
                                                               <img src="' . base_url() . 'upload/ilanlar/default/' . $itemResim->image . '" alt="' . $lTop->name . '">
                                                                <input type="radio" class="required kategoriImages" onclick="checkFluency()"  name="seciliResimler" value="' . $itemResim->id . '" >
                                                                <div class="chc"></div>
                                                            </div>
                                                        </div>';
                                    }
                                }


                                echo json_encode(array("kat" => $kat, "special" => $specialStr, "resimler" => $resimText, "komisyon" => $cek->commission));
                            }

                        }
                    } else if ($this->input->post("types") == 3) {

                    }
                }
            } else {
                addLog("Saldırı Uygulandı.", "getCategory", 3);
            }
        } catch (Exception $ex) {
            addLog("Saldırı Uygulandı.", "getCategory", 3);
        }
    }

    public
    function advertUpdates()
    {
        try {

            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                header('Content-Type: application/json');
                $token = getActiveUsers();
                if (!$token) {
                    echo json_encode(array("err" => "oturum"));
                } else {
                    if ($this->input->post("ilanNo")) {
                        $kontrol = getTableSingle("table_adverts", array("ilanNo" => $this->input->post("ilanNo"), "user_id" => $token->id));
                        if ($kontrol) {

                            $this->load->library("form_validation");
                            $getLang = getTable("table_langs", array("status" => 1));
                            if ($this->input->post("mainCat") && $this->input->post("topcat") && is_numeric($this->input->post("mainCat")) && is_numeric($this->input->post("topcat"))) {
                                $getCatAna = getTableSingle("table_advert_category", array("id" => $this->input->post("mainCat")));
                                $getCatTop = getTableSingle("table_advert_category", array("id" => $this->input->post("topcat")));
                                if ($this->input->post("subcat")) {
                                    if (is_numeric($this->input->post("subcat"))) {
                                        $getCatAlt = getTableSingle("table_advert_category", array("id" => $this->input->post("subcat")));
                                    } else {
                                        //saldırı
                                    }
                                }

                                foreach ($getLang as $item) {
                                    if ($item->lang_id == 1) {
                                        $this->form_validation->set_rules("name_" . $item->id, str_replace("\r\n", "", langS(64, 2, $item->id)), "required|trim");
                                        $this->form_validation->set_rules("aciklama_" . $item->id, str_replace("\r\n", "", langS(68, 2, $item->id)), "required|trim");
                                    }

                                }
                                $this->form_validation->set_rules("proType", str_replace("\r\n", "", langS(60, 2)), "required|trim");
                                if ($this->input->post("proType") == "stoklu") {
                                    $this->form_validation->set_rules("stocks", str_replace("\r\n", "", langS(90, 2)), "required|trim");
                                }
                                $this->form_validation->set_rules("deliveryTime", str_replace("\r\n", "", langS(66, 2)), "required|trim");
                                $ozelAlanlar = getTable("table_adverts_category_special", array("p_id" => $this->input->post("ilan_top_cat")));
                                if ($ozelAlanlar) {
                                    foreach ($ozelAlanlar as $item) {
                                        $speLang = getLangValue($item->id, "table_adverts_category_special");
                                        $this->form_validation->set_rules("sp_" . $item->id, $speLang->name, "required|trim");

                                    }
                                }

                                if (is_numeric($this->input->post("price"))) {
                                    $this->form_validation->set_rules("price", str_replace("\r\n", "", langS(70, 2)), "required|trim");
                                    $val = $this->form_validation->run();
                                    $name = "";
                                    $ce=json_decode(getTableSingle("table_adverts",array("id" => $kontrol->id))->field_data);
                                    if ($val) {
                                        foreach ($getLang as $item) {
                                            if ($item->id == 1) {
                                                $name = $this->input->post("name_" . $item->id);
                                            }
                                            $link="";
                                            if($ce){
                                                foreach ($ce as $it){
                                                    if($it->link){
                                                        if($it->lang_id==$item->id){
                                                            $link=$it->link;
                                                        }
                                                    }
                                                }
                                            }

                                            if($link!=""){
                                                $langValue[] = array(
                                                    "lang_id" => $item->id,
                                                    "name" => $this->input->post("name_" . $item->id),
                                                    "aciklama" => $this->input->post("aciklama_" . $item->id),
                                                    "link" => $link
                                                );
                                            }else{
                                                $langValue[] = array(
                                                    "lang_id" => $item->id,
                                                    "name" => $this->input->post("name_" . $item->id),
                                                    "aciklama" => $this->input->post("aciklama_" . $item->id)
                                                );
                                            }


                                        }

                                        $enc = json_encode($langValue);
                                        $ayarlar = getTableSingle("options_general", array("id" => 1));
                                        $ayar = getTableSingle("table_options", array("id" => 1));
                                        $user = getActiveUsers();
                                        $islem = $this->input->post("price", true) - (($ayar->ilan_komisyon * $this->input->post("price", true)) / 100);
                                        if ($user) {
                                            if ($this->input->post("doping")) {
                                                $doping = getTableSingle("table_adverts_dopings", array("id" => $this->input->post("doping")));
                                            }
                                            if ($ozelAlanlar) {
                                                $d = array();
                                                $yt=1;
                                                foreach ($ozelAlanlar as $item) {
                                                    $verilers[] = array("sp_id" => $item->id, "veri" => $this->input->post("sp_" . $item->id));
                                                    $this->m_tr_model->updateTable("table_adverts",array(
                                                        "oz_".$yt => $this->input->post("sp_".$item->id)
                                                    ),array("id" => $kontrol->id));
                                                    $yt++;
                                                }
                                            }

                                            $verilers = json_encode($verilers);
                                            $ayarCek=getTableSingle("table_options",array("id" => 1));
                                            if($ayarCek->admin_onay==1){
                                                $guncelle = $this->m_tr_model->updateTable("table_adverts", array(
                                                    "ad_name" => $name,
                                                    "cat_name" => $getCatTop->name,
                                                    "category_main_id" => $this->input->post("mainCat"),
                                                    "category_top_id" => $this->input->post("topcat"),
                                                    "category_parent_id" => ($getCatAlt) ? $getCatAlt->id : 0,
                                                    "type" => ($this->input->post("proType") == "stoklu") ? 1 : 0,
                                                    "stocks" => ($this->input->post("proType") == "stoklu") ? $this->input->post("stocks") : "",
                                                    "delivery_time" => $this->input->post("deliveryTime"),
                                                    "price" => $this->input->post("price"),
                                                    "sell_price" => $islem,
                                                    "selected_image" => $this->input->post("seciliResimler"),
                                                    "field_data" => $enc,
                                                    "status" => 0,
                                                    "update_at" => date("Y-m-d H:i:s"),
                                                    "special_field" => $verilers,
                                                ), array("id" => $kontrol->id));
                                            }else{
                                                $guncelle = $this->m_tr_model->updateTable("table_adverts", array(
                                                    "ad_name" => $name,
                                                    "cat_name" => $getCatTop->name,
                                                    "category_main_id" => $this->input->post("mainCat"),
                                                    "category_top_id" => $this->input->post("topcat"),
                                                    "category_parent_id" => ($getCatAlt) ? $getCatAlt->id : 0,
                                                    "type" => ($this->input->post("proType") == "stoklu") ? 1 : 0,
                                                    "stocks" => ($this->input->post("proType") == "stoklu") ? $this->input->post("stocks") : "",
                                                    "delivery_time" => $this->input->post("deliveryTime"),
                                                    "price" => $this->input->post("price"),
                                                    "sell_price" => $islem,
                                                    "selected_image" => $this->input->post("seciliResimler"),
                                                    "field_data" => $enc,
                                                    "status" => $kontrol->status,
                                                    "update_at" => date("Y-m-d H:i:s"),
                                                    "special_field" => $verilers,
                                                ), array("id" => $kontrol->id));
                                            }



                                            if ($guncelle) {
                                                if($_FILES["resim1"]["tmp_name"]!=""){
                                                    $cek = getTableSingle("table_adverts_upload_image", array("adverts_id" => $kontrol->id,"sira" => 1));
                                                    if($cek){
                                                        unlink("upload/ilanlar_users/" . $cek->image);
                                                    }
                                                    $newfilename = permalink($ayarlar->site_name . "-ilan-" . $this->input->post("name_1") . "-" . uniqid(time()));
                                                    $image_f = upload_picture($_FILES["resim1"], "ilanlar_users", $newfilename, "");
                                                    if ($image_f) {
                                                        $resimKaydet = $this->m_tr_model->updateTable("table_adverts_upload_image",
                                                            array("image" => $image_f . ".webp"), array("id" => $cek->id));
                                                    }
                                                }
                                                if($_FILES["resim2"]["tmp_name"]!=""){
                                                    $cek = getTableSingle("table_adverts_upload_image", array("adverts_id" => $kontrol->id,"sira" => 2));
                                                    if($cek){
                                                        unlink("upload/ilanlar_users/" . $cek->image);
                                                    }
                                                    $newfilename = permalink($ayarlar->site_name . "-ilan-" . $this->input->post("name_1") . "-" . uniqid(time()));
                                                    $image_f = upload_picture($_FILES["resim2"], "ilanlar_users", $newfilename, "");
                                                    if ($image_f) {
                                                        $resimKaydet = $this->m_tr_model->updateTable("table_adverts_upload_image",
                                                            array("image" => $image_f . ".webp"), array("id" => $cek->id));
                                                    }
                                                }
                                                if($_FILES["resim3"]["tmp_name"]!=""){
                                                    $cek = getTableSingle("table_adverts_upload_image", array("adverts_id" => $kontrol->id,"sira" => 3));
                                                    if($cek){
                                                        unlink("upload/ilanlar_users/" . $cek->image);
                                                    }
                                                    $newfilename = permalink($ayarlar->site_name . "-ilan-" . $this->input->post("name_1") . "-" . uniqid(time()));
                                                    $image_f = upload_picture($_FILES["resim3"], "ilanlar_users", $newfilename, "");
                                                    if ($image_f) {
                                                        $resimKaydet = $this->m_tr_model->updateTable("table_adverts_upload_image",
                                                            array("image" => $image_f . ".webp"), array("id" => $cek->id));
                                                    }
                                                }
                                                addLog("İlan Güncellendi", $kontrol->ilanNo . " No'lu ilan güncellendi.", 1);
                                                echo json_encode(array("errorr" => "yok", "message" => langS(105, 2)));
                                            } else {
                                                addLog("İlan Kayıt Hatası", $kontrol->ilanNo . " No'lu ilan güncellenirken hata meydana geldi..", 4);
                                                echo json_encode(array("errorr" => "kayit", "message" => langS(105, 2)));
                                            }
                                        }
                                    } else {
                                        echo json_encode(array("errorr" => "validation", "message" => validation_errors()));
                                    }
                                } else {
                                    echo json_encode(array("errorr" => "price", "message" => "Error : Price"));
                                }
                            } else {
                                addLog("Saldırı Uygulandı.", "İlan Güncelleme advertUpdate FormControl", 3);
                            }
                        } else {
                            addLog("Saldırı Uygulandı.", "İlan Güncelleme advertUpdate Kontrol", 3);
                            echo json_encode(array("errorr" => "oturum"));
                        }
                    } else {
                        addLog("Saldırı Uygulandı.", "İlan Güncelleme advertUpdate FormControl", 3);
                        echo json_encode(array("error" => "oturum23"));
                    }
                }
            } else {
                addLog("Saldırı Uygulandı.", "İlan Güncelleme advertUpdate FormControl", 3);
            }

        } catch (Exception $ex) {
            $user = getActiveUser();
            addLog("İlan Kaydetme", $user->email . "üyesinde beklenmeyen bir hata meydana geldi.", 4);
        }
    }

    public
    function setDeleteAdvert()
    {
        try {

            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                header('Content-Type: application/json');
                $token = getActiveUsers();
                if (!$token) {
                    echo json_encode(array("error" => "oturum"));
                } else {
                    if ($this->input->post("ilanNo")) {
                        $kontrol = getTableSingle("table_adverts", array("ilanNo" => $this->input->post("ilanNo"), "user_id" => $token->id));
                        if ($kontrol) {
                            $guncelle = $this->m_tr_model->updateTable("table_adverts", array("deleted" => 1, "status" => 8, "delete_date" => date("Y-m-d H:i:s")), array("id" => $kontrol->id));
                            if ($guncelle) {
                                addLog("İlan Silindi", $kontrol->ilanNo . " no'lu ilan silindi.", 1);
                                echo json_encode(array("errorr" => "yok", "message" => langS(335, 2)));
                            }
                        } else {
                            addLog("Saldırı Uygulandı.", "İlan Silme setDeleteAdvert Kontrol", 3);
                            echo json_encode(array("errorr" => "oturum"));
                        }
                    } else {
                        addLog("Saldırı Uygulandı.", "İlan Silme setDeleteAdvert FormControl", 3);
                        echo json_encode(array("error" => "oturum"));
                    }
                }
            } else {
                addLog("Saldırı Uygulandı.", "İlan Silme setDeleteAdvert FormControl", 3);
            }

        } catch (Exception $ex) {
            $user = getActiveUser();
            addLog("İlan Silme", $user->email . "üyesinde beklenmeyen bir hata meydana geldi.", 4);
        }
    }

    public function addDoping(){
        try {
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                header('Content-Type: application/json');
                $token = getActiveUsers();
                if (!$token) {
                    echo json_encode(array("error" => "oturum"));
                } else {
                    if ($this->input->post("ilanNo") && $this->input->post("dop") && $this->input->post("lang") ) {
                        $kontrol = getTableSingle("table_adverts", array("ilanNo" => $this->input->post("ilanNo"), "user_id" => $token->id));
                        if ($kontrol) {
                            $kk=getTableSingle("table_adverts_dopings_users",array("user_id" => $token->id,"advert_id" => $kontrol->id,"status" => 1));
                            if($kk){
                                echo json_encode(array("err" => true,"message" => langS(418,2,$this->input->post("lang"))));
                            }else{
                                $dopCek=getTableSingle("table_adverts_dopings",array("id" => $this->input->post("dop"),"status" => 1));
                                if($dopCek){
                                    if($token->balance>$dopCek->price){
                                        $dus=$token->balance-$dopCek->price;
                                        $eski=$token->balance;
                                        $guncelleUye=$this->m_tr_model->updateTable("table_users",array("balance" => $dus),array("id" => $token->id));
                                        if($guncelleUye){
                                            $bakiyeDus=$this->m_tr_model->add_new(array(
                                                    "user_id" => $token->id,
                                                    "user_email" => $token->email,
                                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                                    "title" => "Doping Bakiyesi Düşüldü",
                                                    "description" => $kontrol->ad_name." adlı ilana ait öne çıkarma işlemi için üyeden ".$dopCek->price." ".getcur()." tutarı bakiyeden düşüldü: Eski bakiye =".$eski." - Yeni Bakiye =".$dus,
                                                    "date" => date("Y-m-d H:i:s"),
                                                    "status" => 1,
                                                    "advert_id" => $kontrol->id
                                                )
                                                ,"ft_logs");
                                            $his=$this->m_tr_model->add_new(array(
                                                    "user_id" => $token->id,
                                                    "type" => 0,
                                                    "quantity" => $dopCek->price,
                                                    "qty" => 1,
                                                    "description" => $kontrol->ad_name." adlı ilan için öne çıkarma işlemi uygulandı.".$dopCek->price." tutarı bakiyeden düşüldü.",
                                                    "doping_id" => $dopCek->id,
                                                    "ilan_id" => $kontrol->id,
                                                    "status" => 2,
                                                    "created_at" => date("Y-m-d H:i:s")
                                                )
                                                ,"table_users_balance_history");
                                            if($his){
                                                $guu=$this->m_tr_model->updateTable("table_users_balance_history",array("islemNo" => "T-B-".$his."-".rand(100,999)),array(
                                                    "id"=>$his
                                                ));
                                                $newDate = date("Y-m-d H:i:s",strtotime($dopCek->sure.' day',strtotime(date("Y-m-d H:i:s")))) ;
                                                $dopingKaydet=$this->m_tr_model->add_new(array(
                                                    "user_id" => $token->id,
                                                    "advert_id" => $kontrol->id,
                                                    "doping_id" => $dopCek->id,
                                                    "created_at" => date("Y-m-d H:i:s"),
                                                    "approval_at" => date("Y-m-d H:i:s"),
                                                    "end_date" => $newDate,
                                                    "price" => $dopCek->price,
                                                    "status" => 1
                                                ),"table_adverts_dopings_users");
                                                if($dopingKaydet){
                                                    $gu=$this->m_tr_model->updateTable("table_adverts",array("is_doping" => 1),array("id" => $kontrol->id));
                                                    if($gu){
                                                        $bakiyeDus=$this->m_tr_model->add_new(array(
                                                                "user_id" => $token->id,
                                                                "user_email" => $token->email,
                                                                "ip" => $_SERVER["REMOTE_ADDR"],
                                                                "title" => "İlan Öne Çıkartıldı",
                                                                "description" => $kontrol->ad_name." adlı ilana ait öne çıkartıldı.Üyeden ".$dopCek->price." ".getcur()." tutarı bakiyeden düşüldü: Eski bakiye =".$eski." - Yeni Bakiye =".$dus." - İlan ".$newDate." tarihinde öne çıkarma süresi bitecek",
                                                                "date" => date("Y-m-d H:i:s"),
                                                                "status" => 1,
                                                                "advert_id" => $kontrol->id,
                                                            )
                                                            ,"ft_logs");
                                                        echo json_encode(array("err" => false,"message" => langS(417,2,$this->input->post("lang"))));
                                                    }
                                                }
                                            }else{
                                                $bakiyeDus=$this->m_tr_model->add_new(array(
                                                        "user_id" => $token->id,
                                                        "user_email" => $token->email,
                                                        "ip" => $_SERVER["REMOTE_ADDR"],
                                                        "title" => "Ödeme Kaydı Ekleme Hatası",
                                                        "description" => $kontrol->ad_name." adlı ilana ait öne çıkarma işlemi için üyeden ".$dopCek->price." ".getcur()." tutarı ödeme kaydına eklenirken hata meydana geldi.",
                                                        "date" => date("Y-m-d H:i:s"),
                                                        "status" => 2,
                                                        "advert_id" => $kontrol->id
                                                    )
                                                    ,"ft_logs");
                                                echo json_encode(array("err" => true,"message" => langS(59,2,$this->input->post("lang"))));
                                            }

                                        }else{
                                            $bakiyeDus=$this->m_tr_model->add_new(array(
                                                    "user_id" => $token->id,
                                                    "user_email" => $token->email,
                                                    "ip" => $_SERVER["REMOTE_ADDR"],
                                                    "title" => "Doping Bakiye Düşme Hatası",
                                                    "description" => $kontrol->ad_name." adlı ilana ait öne çıkarma işlemi için üyeden ".$dopCek->price." ".getcur()." tutarı bakiyeden düşülürken hata meydana geldi",
                                                    "date" => date("Y-m-d H:i:s"),
                                                    "status" => 2,
                                                    "advert_id" => $kontrol->id
                                                )
                                                ,"ft_logs");
                                            echo json_encode(array("errorr" => false, "message" => langS(417, 2,$this->input->post("lang"))));
                                        }

                                    }else{
                                        echo json_encode(array("errorr" => true, "message" => langS(195, 2,$this->input->post("lang"))));
                                    }
                                }
                            }
                        } else {
                            addLog("Saldırı Uygulandı.", "İlan Silme setDeleteAdvert Kontrol", 3);
                            echo json_encode(array("errorr" => "oturum"));
                        }
                    } else {
                        addLog("Saldırı Uygulandı.", "Doping Tanımlama addDoping FormControl", 3);
                        echo json_encode(array("error" => "oturum"));
                    }
                }
            } else {
                addLog("Saldırı Uygulandı.", "Doping Tanımlama addDoping FormControl", 3);
            }

        } catch (Exception $ex) {
            $user = getActiveUser();
            addLog("İlan Doping Tanımlama", $user->email . "üyesinde beklenmeyen bir hata meydana geldi.", 4);
        }
    }

    public function payUpdateSetName(){
        try {
            if($_POST){
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    $token = getActiveUsers();
                    if (!$token) {
                        echo json_encode(array("error" => "oturum"));
                    } else {
                        if($this->input->post("ad") && $this->input->post("soyad")){
                            $temizle1=veriTemizle($this->input->post("ad"));
                            $temizle2=veriTemizle($this->input->post("soyad"));
                            if($temizle2!="" && $temizle1!="" && strlen($temizle1)>2 && strlen($temizle2) >2){
                                $gucnelle=$this->m_tr_model->updateTable("table_users",array("name" => $temizle1,"surname" => $temizle2,"full_name" => $temizle1." ".$temizle2 ),array("id" => $token->id));
                                if($gucnelle){
                                    echo json_encode(array("error" => false,"t" => 2));
                                }else{
                                    echo json_encode(array("error" => true,"t" => 1));
                                }
                            }else{
                                echo json_encode(array("error" => true,"t" => 2));
                            }
                        }
                    }
                }
            }else{
                redirect(base_url(gg()."404"));
            }

        }catch (Exception $ex) {
            $user = getActiveUser();
            addLog("Ödeme Ad Soyad Tanımlama", $user->email . "üyesinde beklenmeyen bir hata meydana geldi.", 4);
        }
    }




    //*************************************************************************************//
    public  function updatePassSetting()
    {
        if ($_POST) {
            header('Content-Type: application/json');
            $this->load->model("m_tr_model");
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                $user = getActiveUsers();
                if ($user) {
                    $ceklang=getTableSingle("table_langs",array("id" => $_SESSION["lang"]));
                    $this->form_validation->set_rules("password", ($_SESSION["lang"]==1)?"Şifre":"Password", "required|trim|max_length[16]|min_length[8]",
                        array(
                            "min_length"   =>  str_replace("[field]",($_SESSION["lang"]==1)?"Şifre":"Password",str_replace("[s]","8",langs(59,2,$ceklang->id))),
                            "max_length"   =>  str_replace("[field]",($_SESSION["lang"]==1)?"Şifre":"Password",str_replace("[s]","16",langs(60,2,$ceklang->id)))
                        )
                    );
                    $this->form_validation->set_rules("passTry", ($_SESSION["lang"]==1)?"Şifre":"Password", "required|trim|max_length[16]|min_length[8]|matches[password]",
                        array(
                            "min_length"   =>  str_replace("[field]",($_SESSION["lang"]==1)?"Şifre Tekrar":"Password Try",str_replace("[s]","8",langs(59,2,$ceklang->id))),
                            "max_length"   =>  str_replace("[field]",($_SESSION["lang"]==1)?"Şifre Tekrar":"Password Try",str_replace("[s]","16",langs(60,2,$ceklang->id)))
                        )
                    );
                    $this->form_validation->set_message(array(
                        "required"    =>	"{field} ".str_replace("\r\n","",langS(8,2,$ceklang->id)),
                        "valid_email" =>	langS(9,2,$ceklang->id),
                        "matches"     => 	langS(10,2,$ceklang->id),
                        "min_length"  =>	str_replace("[field]","{field}",langS(17,2,$ceklang->id)),
                        "max_length"  =>    str_replace("[field]","{field}",langS(18,2,$ceklang->id))));
                    $array="";
                    $val=$this->form_validation->run();
                    if ($val){
                        $pass = $this->security->xss_clean($this->input->post("password"));
                        $passTry = $this->security->xss_clean($this->input->post("passTry"));
                        $pass = md5($pass);
                        if ($pass == $user->password) {
                            echo json_encode(array("hata" => "var", "message" => langS(73, 2)));
                        } else {
                            $guncelle = $this->m_tr_model->updateTable("table_users", array("password" => $pass), array("id" => $user->id));
                            if ($guncelle) {
                                addLog("Şifre Değiştirildi", $user->nick_name." kullanıcı şifresini başarılı şekilde değiştirdi.", 1);
                                $this->session->sess_destroy();
                                echo json_encode(array("hata" => "yok", "message" => langS(77, 2, $ceklang->id)));
                            } else {
                                echo json_encode(array("hata" => "var", "message" => langS(38, 2,$ceklang->id)));
                            }
                        }
                    }else{
                        echo json_encode(array("hata" => "var","type" => "validation", "message" => validation_errors()));
                    }
                } else {
                    echo json_encode(array("err" => "oturum"));
                }
            } else {
                redirect(base_url()."404");
            }
        } else {
            redirect(base_url()."404");
        }
    }



}


