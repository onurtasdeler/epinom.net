<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adverts_list extends CI_Controller
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

    public function getListCategoryAjax(){
        if ($_POST) {
            if($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                //typecat:3 Son Kategori
                //typecat:2 Alt Kategori
                header('Content-Type: application/json');
                //types:1 vitrin
                //types:2 normal
                $this->load->model("m_tr_model");

                if($this->input->post("typecat")==3){
                    //En Alt Kategori Seçeneği

                    $page=$this->input->post("page",true);
                    $pageNormal=$this->input->post("pageNormal",true);

                    $limit=$this->input->post("limit",true);
                    if(is_numeric($page) && is_numeric($limit)){
                        if($page==-1){
                            $page=0;
                        }else if($page==-3){
                            $page=0;
                        }else{
                            $page=$page;
                        }
                    }else{
                        redirect(base_url("404"));
                        exit;
                    }


                    if(is_numeric($pageNormal) && is_numeric($limit)){
                        if($pageNormal==-1){
                            $pageNormal=0;
                        }else if($pageNormal==-3){
                            $pageNormal=0;
                        }else{
                            $pageNormal=$pageNormal;
                        }
                    }else{
                        redirect(base_url("404"));
                        exit;
                    }





                    $main=$this->input->post("main",true);
                    $top=$this->input->post("top",true);
                    $sub=$this->input->post("sub",true);
                    $types=$this->input->post("types",true);
                    $order=$this->input->post("order",true);

                    $sonrasi="";
                    if(is_numeric($main) && is_numeric($top) && is_numeric($sub) && is_numeric($types) ){
                        if($types==2){
                            if($this->input->post("ordernormal") && $this->input->post("ordernormal")!="latest"){
                                if($order=="lat"){
                                    $k1="1";
                                    $order=" ilan.created_at desc ";
                                }else if($order=="most"){
                                    $k1="1";
                                    $order=" ilan.views desc ";
                                }else if($order=="oldest"){
                                    $k1="1";
                                    $order=" ilan.created_at asc ";
                                }else if($order=="inprice"){
                                    $k1="1";
                                    $order=" ilan.price asc ";
                                }else if($order=="deprice"){
                                    $k1="1";
                                    $order=" ilan.price desc ";
                                }
                            }else{
                                $k1="";
                                $order=" rand() desc";
                            }
                        }else{
                            if($this->input->post("order") && $this->input->post("order")!="latest"){
                                if($order=="lat"){
                                    $k1="1";
                                    $order=" ilan.created_at desc ";
                                }else if($order=="most"){
                                    $k1="1";
                                    $order=" ilan.views desc ";
                                }else if($order=="oldest"){
                                    $k1="1";
                                    $order=" ilan.created_at asc ";
                                }else if($order=="inprice"){
                                    $k1="1";
                                    $order=" ilan.price asc ";
                                }else if($order=="deprice"){
                                    $k1="1";
                                    $order=" ilan.price desc ";
                                }
                            }else{
                                $k1="";
                                $order=" rand() desc";
                            }
                        }




                        $wheres="";
                        $wdata=[];


                        if($k1==""){
                            if($types==1){
                                if($this->input->post("ids")){
                                    //$wheres=" and ilanNo not in(";
                                    $explode=explode(",",$this->input->post("ids"));
                                    $explode=array_filter($explode);
                                    foreach ($explode as $itemr) {
                                        $wheres.= "'".$itemr."',";
                                        $wdata[]=$itemr;
                                    }
                                    $wheres=rtrim($wheres,",");
                                    $ordereski=$order;
                                    $order=" ilanNo not in(".$wheres."),".$ordereski;
                                    $wheres="  ";
                                }
                            }else{
                                if($this->input->post("idsNormal")){
                                    //$wheres=" and ilanNo not in(";
                                    $explode=explode(",",$this->input->post("idsNormal"));
                                    $explode=array_filter($explode);
                                    foreach ($explode as $itemr) {
                                        $wheres.= "'".$itemr."',";
                                        $wdata[]=$itemr;
                                    }
                                    $wheres=rtrim($wheres,",");
                                    $ordereski=$order;
                                    $order=" ilanNo not in(".$wheres."),".$ordereski;
                                    $wheres="  ";
                                }
                            }
                        }


                        $price_min=0;
                        $price_max=0;
                        $seller="";
                        $ads="";


                         if($types==1){
                             if($this->input->post("filters")){
                                 $specials="";
                                 parse_str($this->input->post("filters",true),$special);
                                 if($special){
                                     $speVeri=[];
                                     $amount="";
                                     //echo "123";
                                     $str="";
                                     foreach ($special as $key => $vals){
                                         if($key){
                                             if($key=="price_start" ){
                                                 $price_min=$vals;
                                             }else  if($key=="price_en" ){
                                                 $price_max=$vals;
                                             }else  if($key=="ad_name" ){
                                                 $ads=$vals;
                                             }else  if($key=="seller_name" ){
                                                 $seller=$vals;
                                             }else{
                                                 $speVeri[$this->security->xss_clean($key)]=array(
                                                     "no" => $this->security->xss_clean($key),
                                                     "value" => ""
                                                 );
                                                 $keyparse=str_replace("spe-","",$this->security->xss_clean($key));
                                                 $valparse="";
                                                 foreach ($vals as $val) {
                                                     $valparse.=str_replace("spe-","",$this->security->xss_clean($val)).",";
                                                 }
                                                 $valparse=rtrim($valparse,",");
                                                 $parseVale=explode(",",$valparse);
                                                 $speVeri[$this->security->xss_clean($key)]=array("no" => $keyparse ,"value" => $parseVale);
                                             }
                                         }
                                     }



                                     if($speVeri){
                                         $speData=[];
                                         foreach ($speVeri as $key => $item) {
                                             $str="";
                                             if($key=="price_start" || $key=="price_en" || $key=="ad_name" || $key=="seller_name"){

                                             }else{
                                                 $str="";
                                                 $str.=" (spe.spe_id=".$item["no"]." and ( ";
                                                 foreach ($item["value"] as $it) {
                                                     $str.=" spe.value = ".$it." or ";
                                                 }
                                                 $str=rtrim($str,"or ");
                                                 $str.=" ))";
                                                 $sorgu=$this->m_tr_model->query("select ilan.id from table_adverts_spe_field as spe
                                                left join table_adverts as ilan on spe.ads_id = ilan.id
                                                where ilan.status=1 and ilan.is_doping=1 and ".$str." group by ilan.id");
                                                 if($sorgu){
                                                     foreach ($sorgu as $s){
                                                         $speData[$item["no"]]["value"][]=$s->id;
                                                     }

                                                 }
                                             }

                                         }

                                         $uniqueValues = array();
                                         foreach ($speData as $dizi) {
                                             $uniqueValues = array_merge($uniqueValues, array_unique($dizi["value"]));
                                         }
                                         $valueCounts = array_count_values($uniqueValues);

                                         $matchingValues = array();
                                         foreach ($valueCounts as $value => $count) {
                                             if ($count === count($speData)) {
                                                 $matchingValues[] = $value;
                                             }
                                         }
                                     }

                                     $match="";
                                     if($matchingValues){
                                         foreach ($matchingValues as $m){
                                             $match.=$m.",";
                                         }
                                     }
                                     $match=rtrim($match,",");
                                     if($price_min || $price_max){
                                         if($price_min>=0 || $price_max>=0){
                                             if($price_min==0 && $price_max>=0){
                                                 //sadece max
                                                 if(is_numeric($price_max) && $price_max<10000000){
                                                     $price_max=$this->security->xss_clean($price_max);
                                                     if($price_max){
                                                         $specials.="  and ( ilan.price<=".$price_max." ) ";
                                                     }
                                                 }else{
                                                     echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                     exit;
                                                 }
                                             }else if($price_min>=0 && $price_max==0){
                                                 //sadece min
                                                 if(is_numeric($price_min) && $price_min<10000000){
                                                     $price_min=$this->security->xss_clean($price_min);
                                                     if($price_min){
                                                         $specials.="  and ( ilan.price>=".$price_min." ) ";
                                                     }
                                                 }else{
                                                     echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                     exit;
                                                 }
                                             }else if($price_min>=0 && $price_max>=0){
                                                 if($price_min<$price_max){
                                                     if(is_numeric($price_min) && $price_min<10000000 && is_numeric($price_max) && $price_max<10000000){
                                                         $price_min=$this->security->xss_clean($price_min);
                                                         $price_max=$this->security->xss_clean($price_max);
                                                         if($price_min && $price_max){
                                                             $specials.="  and ( ilan.price>=".$price_min." and ilan.price<=".$price_max." ) ";
                                                         }
                                                     }else{
                                                         echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                         exit;
                                                     }
                                                 }else{
                                                     echo json_encode(array("hata" => "var","message" => "Başlangıç Fiyatı Bitiş Fiyatından Büyük Olamaz"));
                                                     exit;
                                                 }
                                             }
                                         }
                                     }


                                     if($ads!=""){
                                         $temizAds=strip_tags($this->security->xss_clean($ads));
                                         if($_SESSION["lang"]==1){
                                             $specials.="  and ( ilan.ad_name like '%".$ads."%')  ";
                                         }else{
                                             $specials.="  and ( ilan.ad_name_en like '%".$ads."%')  ";
                                         }
                                     }

                                     if($seller!=""){
                                         $temizSell=strip_tags($this->security->xss_clean($seller));
                                         $specials.="  and ( users.magaza_name like '%".$temizSell."%')  ";
                                     }
                                     /* if($amount){
                                          $kont=explode(" - ",$this->security->xss_clean($amount));
                                          if($kont){
                                              if(is_numeric($kont[0]) && is_numeric($kont[1])){
                                                  $specials.="  and ( ilan.price<=".$kont[1]." and  ilan.price>=".$kont[0]." ) ";
                                              }
                                          }
                                      }*/

                                     if($match){
                                         $specials.=" and ilan.id in(".$match.")";
                                     }
                                 }

                                 if($k1){
                                     if($page==0){
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 ".$specials," order by  ".$order, "0",24);
                                     }else{
                                         $sorgu=$page;
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 ".$specials," order by  ".$order, $sorgu,$limit);
                                     }

                                 }else{
                                     if($page==0){
                                         $sorgu=0;
                                     }else{
                                         if($this->input->post("filters") && $this->input->post("page")==24){
                                             $sorgu=24;
                                         }else{
                                             $sorgu=$page+$limit;
                                         }
                                     }
                                     $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 ".$specials," order by  ".$order, $sorgu,$limit);

                                 }

                                 if($veriler["veri"]){

                                     $sorgu=$page+$limit;
                                     $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 ".$specials," order by  ".$order, $sorgu,$limit);
                                 
                                 }
                             }else{
                                 if($k1){
                                     if($page==0){
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 "," order by  ".$order, "0",$limit);
                                     }else{
                                         $sorgu=$page;
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 ".$wheres." "," order by  ".$order, $sorgu,$limit);
                                     }
                                 }else{
                                     $sorgu=$page+$limit;
                                     $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 ".$wheres." "," order by  ".$order, $sorgu,$limit);
                                 }
                                 if($veriler){
                                     $sorgu=$sorgu+$limit;
                                     $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 ".$wheres." "," order by  ".$order, $sorgu,$limit);
                                 }
                             }


                         }else{

                             $order=$this->input->post("ordernormal");
                             if($this->input->post("ordernormal") && $this->input->post("ordernormal")!="latest"){
                                 if($order=="lat"){
                                     $k1="1";
                                     $order=" ilan.created_at desc ";
                                 }else if($order=="most"){
                                     $k1="1";
                                     $order=" ilan.views desc ";
                                 }else if($order=="oldest"){
                                     $k1="1";
                                     $order=" ilan.created_at asc ";
                                 }else if($order=="inprice"){
                                     $k1="1";
                                     $order=" ilan.price asc ";
                                 }else if($order=="deprice"){
                                     $k1="1";
                                     $order=" ilan.price desc ";
                                 }
                             }else{
                                 $k1="";
                                 $order=" rand() desc";
                             }


                             if($this->input->post("filters")){

                                 $specials="";
                                 parse_str($this->input->post("filters",true),$special);
                                 if($special){
                                     $speVeri=[];
                                     $amount="";
                                     //echo "123";
                                     $str="";
                                     foreach ($special as $key => $vals){
                                         if($key){
                                             if($key=="price_start" ){
                                                 $price_min=$vals;
                                             }else  if($key=="price_en" ){
                                                 $price_max=$vals;
                                             }else  if($key=="ad_name" ){
                                                 $ads=$vals;
                                             }else  if($key=="seller_name" ){
                                                 $seller=$vals;
                                             }else{
                                                 $speVeri[$this->security->xss_clean($key)]=array(
                                                     "no" => $this->security->xss_clean($key),
                                                     "value" => ""
                                                 );
                                                 $keyparse=str_replace("spe-","",$this->security->xss_clean($key));
                                                 $valparse="";
                                                 foreach ($vals as $val) {
                                                     $valparse.=str_replace("spe-","",$this->security->xss_clean($val)).",";
                                                 }
                                                 $valparse=rtrim($valparse,",");
                                                 $parseVale=explode(",",$valparse);
                                                 $speVeri[$this->security->xss_clean($key)]=array("no" => $keyparse ,"value" => $parseVale);
                                             }
                                         }
                                     }

                                     $price_min=0;
                                     $price_max=0;
                                     $seller="";
                                     $ads="";


                                     if($speVeri){
                                         $speData=[];
                                         foreach ($speVeri as $key => $item) {
                                             $str="";
                                             if($key=="price_start" || $key=="price_en" || $key=="ad_name" || $key=="seller_name"){

                                             }else{
                                                 $str.=" (spe.spe_id=".$item["no"]." and ( ";
                                                 foreach ($item["value"] as $it) {
                                                     $str.=" spe.value = ".$it." or ";
                                                 }
                                                 $str=rtrim($str,"or ");
                                                 $str.=" ))";

                                                 $sorgu=$this->m_tr_model->query("select ilan.id from table_adverts_spe_field as spe
                                                left join table_adverts as ilan on spe.ads_id = ilan.id
                                                where ilan.status=1 and ilan.is_doping=0 and ".$str." group by ilan.id");
                                                 if($sorgu){
                                                     foreach ($sorgu as $s){
                                                         $speData[$item["no"]]["value"][]=$s->id;
                                                     }
                                                 }
                                             }

                                         }



                                         $uniqueValues = array();
                                         foreach ($speData as $dizi) {
                                             $uniqueValues = array_merge($uniqueValues, array_unique($dizi["value"]));
                                         }
                                         $valueCounts = array_count_values($uniqueValues);

                                         $matchingValues = array();
                                         foreach ($valueCounts as $value => $count) {
                                             if ($count === count($speData)) {
                                                 $matchingValues[] = $value;
                                             }
                                         }
                                     }

                                     $match="";
                                     if($matchingValues){
                                         foreach ($matchingValues as $m){
                                             $match.=$m.",";
                                         }
                                     }
                                     $match=rtrim($match,",");
                                     if($price_min || $price_max){
                                         if($price_min>=0 || $price_max>=0){
                                             if($price_min==0 && $price_max>=0){
                                                 //sadece max
                                                 if(is_numeric($price_max) && $price_max<10000000){
                                                     $price_max=$this->security->xss_clean($price_max);
                                                     if($price_max){
                                                         $specials.="  and ( ilan.price<=".$price_max." ) ";
                                                     }
                                                 }else{
                                                     echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                     exit;
                                                 }
                                             }else if($price_min>=0 && $price_max==0){
                                                 //sadece min
                                                 if(is_numeric($price_min) && $price_min<10000000){
                                                     $price_min=$this->security->xss_clean($price_min);
                                                     if($price_min){
                                                         $specials.="  and ( ilan.price>=".$price_min." ) ";
                                                     }
                                                 }else{
                                                     echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                     exit;
                                                 }
                                             }else if($price_min>=0 && $price_max>=0){
                                                 if($price_min<$price_max){
                                                     if(is_numeric($price_min) && $price_min<10000000 && is_numeric($price_max) && $price_max<10000000){
                                                         $price_min=$this->security->xss_clean($price_min);
                                                         $price_max=$this->security->xss_clean($price_max);
                                                         if($price_min && $price_max){
                                                             $specials.="  and ( ilan.price>=".$price_min." and ilan.price<=".$price_max." ) ";
                                                         }
                                                     }else{
                                                         echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                         exit;
                                                     }
                                                 }else{
                                                     echo json_encode(array("hata" => "var","message" => "Başlangıç Fiyatı Bitiş Fiyatından Büyük Olamaz"));
                                                     exit;
                                                 }
                                             }
                                         }
                                     }


                                     if($ads!=""){
                                         $temizAds=strip_tags($this->security->xss_clean($ads));
                                         if($_SESSION["lang"]==1){
                                             $specials.="  and ( ilan.ad_name like '%".$ads."%')  ";
                                         }else{
                                             $specials.="  and ( ilan.ad_name_en like '%".$ads."%')  ";
                                         }
                                     }

                                     if($seller!=""){
                                         $temizSell=strip_tags($this->security->xss_clean($seller));
                                         $specials.="  and ( users.magaza_name like '%".$temizSell."%')  ";
                                     }

                                     /* if($amount){
                                          $kont=explode(" - ",$this->security->xss_clean($amount));
                                          if($kont){
                                              if(is_numeric($kont[0]) && is_numeric($kont[1])){
                                                  $specials.="  and ( ilan.price<=".$kont[1]." and  ilan.price>=".$kont[0]." ) ";
                                              }
                                          }
                                      }*/

                                     if($match){
                                         $specials.=" and ilan.id in(".$match.")";
                                     }
                                 }

                                 if($k1){
                                     if($pageNormal==0){
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=0 ".$specials," order by  ".$order, "0",24);
                                     }else{
                                         $sorgu=$pageNormal;
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=0 ".$specials," order by  ".$order, $sorgu,$limit);
                                     }

                                 }else{
                                     if($pageNormal==0){
                                         $sorgu=0;
                                     }else{
                                         if($this->input->post("filters") && $this->input->post("pageNormal")==24){
                                             $sorgu=24;
                                         }else{
                                             $sorgu=$pageNormal+$limit;
                                         }
                                     }
                                     $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=0 ".$specials," order by  ".$order, $sorgu,$limit);

                                 }

                                 if($veriler["veri"]){

                                     $sorgu=$pageNormal+$limit;
                                     $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=0 ".$specials," order by  ".$order, $sorgu,$limit);

                                 }
                             }else{

                                 if($k1){
                                     if($page==0){
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 "," order by  ".$order, "0",$limit);
                                     }else{
                                         $sorgu=$page;
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 ".$wheres." "," order by  ".$order, $sorgu,$limit);
                                     }
                                 }else{
                                     $sorgu=$page+$limit;
                                     $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 ".$wheres." "," order by  ".$order, $sorgu,$limit);
                                 }
                                 if($veriler){
                                     $sorgu=$sorgu+$limit;
                                     $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 ".$wheres." "," order by  ".$order, $sorgu,$limit);
                                 }



                                 if($k1){
                                     if($pageNormal==0){
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=0 "," order by  ".$order, "0",$limit);
                                     }else{

                                         $sorgu=$pageNormal;

                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=0 ".$wheres." "," order by  ".$order, $sorgu,$limit);
                                     }
                                 }else{
                                     $sorgu=$pageNormal+$limit;
                                     $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=0 ".$wheres." "," order by  ".$order, $sorgu,$limit);
                                 }
                                 if($veriler){
                                     $sorgu=$pageNormal+$limit;
                                     $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=0 ".$wheres." "," order by  ".$order, $sorgu,$limit);
                                 }
                             }
                         }

                         if($veriler["veri"]){

                            $veri=$this->createListAds($veriler["veri"],$wdata);
                            if($veri["str"]){
                                if($types==1){
                                    $sts="";
                                    if($veri["id"]){
                                        foreach ($veri["id"] as $item) {
                                            $sts.=$item.",";
                                        }
                                    }
                                    $sts=rtrim($sts,",");
                                    if($k1){
                                        if($page==0){
                                            echo json_encode(array("veri" => $veri["str"],"page" => 24,"lasts" => ($sonrasi)?"1":""));
                                        }else{
                                            if($this->input->post("filters")){
                                                echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":""  ));
                                            }else{
                                                echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":"" ));

                                            }
                                        }
                                    }else{
                                        echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":""  ,"ids" => $sts));
                                    }
                                }else{

                                    $sts="";
                                    if($veri["id"]){
                                        foreach ($veri["id"] as $item) {
                                            $sts.=$item.",";
                                        }
                                    }
                                    $sts=rtrim($sts,",");
                                    if($k1){
                                        if($pageNormal==0){
                                            echo json_encode(array("veri" => $veri["str"],"page" => 24,"lasts" => ($sonrasi)?"1":"" ));
                                        }else{
                                            if($this->input->post("filters")){
                                                echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":""  ));
                                            }else{
                                                echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":"" ));

                                            }
                                        }
                                    }else{
                                        echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":"" ,"ids" => $sts));
                                    }
                                }

                            }
                         }else{
                             echo json_encode(array("veri" => "nothing"));
                             exit;
                         }


                     }else{
                         redirect(base_url("404"));
                         exit;
                     }
                }
                else{


                    //En Alt Kategori Seçeneği
                    $page=$this->input->post("page",true);
                    $pageNormal=$this->input->post("pageNormal",true);
                    $limit=$this->input->post("limit",true);
                    if(is_numeric($page) && is_numeric($limit)){
                        if($page==-1){
                            $page=0;
                        }else if($page==-3){
                            $page=0;
                        }else{
                            $page=$page;
                        }
                    }else{
                        redirect(base_url("404"));
                        exit;
                    }


                    if(is_numeric($pageNormal) && is_numeric($limit)){
                        if($pageNormal==-1){
                            $pageNormal=0;
                        }else if($pageNormal==-3){
                            $pageNormal=0;
                        }else{
                            $pageNormal=$pageNormal;
                        }
                    }else{
                        redirect(base_url("404"));
                        exit;
                    }





                    $main=$this->input->post("main",true);
                    $top=$this->input->post("top",true);
                    $types=$this->input->post("types",true);
                    $order=$this->input->post("order",true);

                    $sonrasi="";
                    if(is_numeric($main) && is_numeric($top) && is_numeric($types) ){
                        if($types==2){

                            if($this->input->post("ordernormal") && $this->input->post("ordernormal")!="latest"){
                                if($order=="lat"){
                                    $k1="1";
                                    $order=" ilan.created_at desc ";
                                }else if($order=="most"){
                                    $k1="1";
                                    $order=" ilan.views desc ";
                                }else if($order=="oldest"){
                                    $k1="1";
                                    $order=" ilan.created_at asc ";
                                }else if($order=="inprice"){
                                    $k1="1";
                                    $order=" ilan.price asc ";
                                }else if($order=="deprice"){
                                    $k1="1";
                                    $order=" ilan.price desc ";
                                }
                            }else{
                                $k1="";
                                $order=" rand() desc";
                            }
                        }else{
                            if($this->input->post("order") && $this->input->post("order")!="latest"){
                                if($order=="lat"){
                                    $k1="1";
                                    $order=" ilan.created_at desc ";
                                }else if($order=="most"){
                                    $k1="1";
                                    $order=" ilan.views desc ";
                                }else if($order=="oldest"){
                                    $k1="1";
                                    $order=" ilan.created_at asc ";
                                }else if($order=="inprice"){
                                    $k1="1";
                                    $order=" ilan.price asc ";
                                }else if($order=="deprice"){
                                    $k1="1";
                                    $order=" ilan.price desc ";
                                }
                            }else{
                                $k1="";
                                $order=" rand() desc";
                            }
                        }




                        $wheres="";
                        $wdata=[];


                        if($k1==""){
                            if($types==1){
                                if($this->input->post("ids")){
                                    //$wheres=" and ilanNo not in(";
                                    $explode=explode(",",$this->input->post("ids"));
                                    $explode=array_filter($explode);
                                    foreach ($explode as $itemr) {
                                        $wheres.= "'".$itemr."',";
                                        $wdata[]=$itemr;
                                    }
                                    $wheres=rtrim($wheres,",");
                                    $ordereski=$order;
                                    $order=" ilanNo not in(".$wheres."),".$ordereski;
                                    $wheres="  ";
                                }
                            }else{
                                if($this->input->post("idsNormal")){
                                    //$wheres=" and ilanNo not in(";
                                    $explode=explode(",",$this->input->post("idsNormal"));
                                    $explode=array_filter($explode);
                                    foreach ($explode as $itemr) {
                                        $wheres.= "'".$itemr."',";
                                        $wdata[]=$itemr;
                                    }
                                    $wheres=rtrim($wheres,",");
                                    $ordereski=$order;
                                    $order=" ilanNo not in(".$wheres."),".$ordereski;
                                    $wheres="  ";
                                }
                            }
                        }




                        if($types==1){

                            $price_min=0;
                            $price_max=0;
                            $seller="";
                            $ads="";
                            if($this->input->post("filters")){

                                $specials="";
                                parse_str($this->input->post("filters",true),$special);
                                if($special){
                                    $speVeri=[];
                                    $amount="";
                                    //echo "123";
                                    $str="";
                                    foreach ($special as $key => $vals){
                                        if($key){
                                            if($key=="price_start" ){
                                                $price_min=$vals;
                                            }else  if($key=="price_en" ){
                                                $price_max=$vals;
                                            }else  if($key=="ad_name" ){
                                                $ads=$vals;
                                            }else  if($key=="seller_name" ){
                                                $seller=$vals;
                                            }else{
                                                $speVeri[$this->security->xss_clean($key)]=array(
                                                    "no" => $this->security->xss_clean($key),
                                                    "value" => ""
                                                );
                                                $keyparse=str_replace("spe-","",$this->security->xss_clean($key));
                                                $valparse="";
                                                foreach ($vals as $val) {
                                                    $valparse.=str_replace("spe-","",$this->security->xss_clean($val)).",";
                                                }
                                                $valparse=rtrim($valparse,",");
                                                $parseVale=explode(",",$valparse);
                                                $speVeri[$this->security->xss_clean($key)]=array("no" => $keyparse ,"value" => $parseVale);
                                            }
                                        }
                                    }



                                    if($speVeri){
                                        $speData=[];
                                        foreach ($speVeri as $key => $item) {
                                            $str="";
                                            if($key=="price_start" || $key=="price_en" || $key=="ad_name" || $key=="seller_name"){

                                            }else{
                                                $str.=" (spe.spe_id=".$item["no"]." and ( ";
                                                foreach ($item["value"] as $it) {
                                                    $str.=" spe.value = ".$it." or ";
                                                }
                                                $str=rtrim($str,"or ");
                                                $str.=" ))";
                                                $sorgu=$this->m_tr_model->query("select ilan.id from table_adverts_spe_field as spe
                                                left join table_adverts as ilan on spe.ads_id = ilan.id
                                                where ilan.status=1 and ilan.is_doping=1 and ".$str." group by ilan.id");

                                                if($sorgu){
                                                    foreach ($sorgu as $s){
                                                        $speData[$item["no"]]["value"][]=$s->id;
                                                    }
                                                }
                                            }


                                        }

                                        $uniqueValues = array();
                                        foreach ($speData as $dizi) {
                                            $uniqueValues = array_merge($uniqueValues, array_unique($dizi["value"]));
                                        }
                                        $valueCounts = array_count_values($uniqueValues);

                                        $matchingValues = array();
                                        foreach ($valueCounts as $value => $count) {
                                            if ($count === count($speData)) {
                                                $matchingValues[] = $value;
                                            }
                                        }
                                    }

                                    $match="";
                                    if($matchingValues){
                                        foreach ($matchingValues as $m){
                                            $match.=$m.",";
                                        }
                                    }
                                    $match=rtrim($match,",");

                                    /* if($amount){
                                         $kont=explode(" - ",$this->security->xss_clean($amount));
                                         if($kont){
                                             if(is_numeric($kont[0]) && is_numeric($kont[1])){
                                                 $specials.="  and ( ilan.price<=".$kont[1]." and  ilan.price>=".$kont[0]." ) ";
                                             }
                                         }
                                     }*/

                                    if($match){
                                        $specials.=" and ilan.id in(".$match.")";
                                    }
                                }

                                if($k1){
                                    if($page==0){
                                        $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=1 ".$specials," order by  ".$order, "0",24);
                                    }else{
                                        $sorgu=$page;
                                        $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=1 ".$specials," order by  ".$order, $sorgu,$limit);
                                    }

                                }else{
                                    if($page==0){
                                        $sorgu=0;
                                    }else{
                                        if($this->input->post("filters") && $this->input->post("page")==24){
                                            $sorgu=24;
                                        }else{
                                            $sorgu=$page+$limit;
                                        }
                                    }
                                    $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.is_doping=1 ".$specials," order by  ".$order, $sorgu,$limit);

                                }

                                if($veriler["veri"]){

                                    $sorgu=$page+$limit;
                                    $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=1 ".$specials," order by  ".$order, $sorgu,$limit);

                                }
                            }else{
                                if($k1){
                                    if($page==0){
                                        $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=1 "," order by  ".$order, "0",$limit);
                                    }else{
                                        $sorgu=$page;
                                        $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."   and ilan.is_doping=1 ".$wheres." "," order by  ".$order, $sorgu,$limit);
                                    }
                                }else{
                                    $sorgu=$page+$limit;
                                    $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=1 ".$wheres." "," order by  ".$order, $sorgu,$limit);
                                }
                                if($veriler){
                                    $sorgu=$sorgu+$limit;
                                    $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=1 ".$wheres." "," order by  ".$order, $sorgu,$limit);
                                }
                            }


                        }else{




                            $order=$this->input->post("ordernormal");
                            if($this->input->post("ordernormal") && $this->input->post("ordernormal")!="latest"){
                                if($order=="lat"){
                                    $k1="1";
                                    $order=" ilan.created_at desc ";
                                }else if($order=="most"){
                                    $k1="1";
                                    $order=" ilan.views desc ";
                                }else if($order=="oldest"){
                                    $k1="1";
                                    $order=" ilan.created_at asc ";
                                }else if($order=="inprice"){
                                    $k1="1";
                                    $order=" ilan.price asc ";
                                }else if($order=="deprice"){
                                    $k1="1";
                                    $order=" ilan.price desc ";
                                }
                            }else{
                                $k1="";
                                $order=" rand() desc";
                            }



                            $price_min=0;
                            $price_max=0;
                            $seller="";
                            $ads="";
                            if($this->input->post("filters")){

                                $specials="";
                                parse_str($this->input->post("filters",true),$special);
                                if($special){
                                    $speVeri=[];
                                    $amount="";
                                    //echo "123";
                                    $str="";
                                    foreach ($special as $key => $vals){
                                        if($key){

                                            if($key=="price_start" ){
                                                $price_min=$vals;
                                            }else  if($key=="price_en" ){
                                                $price_max=$vals;
                                            }else  if($key=="ad_name" ){
                                                $ads=$vals;
                                            }else  if($key=="seller_name" ){
                                                $seller=$vals;
                                            }else{

                                                $speVeri[$this->security->xss_clean($key)]=array(
                                                    "no" => $this->security->xss_clean($key),
                                                    "value" => ""
                                                );
                                                $keyparse=str_replace("spe-","",$this->security->xss_clean($key));
                                                $valparse="";
                                                foreach ($vals as $val) {
                                                    $valparse.=str_replace("spe-","",$this->security->xss_clean($val)).",";
                                                }
                                                $valparse=rtrim($valparse,",");
                                                $parseVale=explode(",",$valparse);
                                                $speVeri[$this->security->xss_clean($key)]=array("no" => $keyparse ,"value" => $parseVale);
                                            }
                                        }
                                    }



                                    if($speVeri){
                                        $speData=[];
                                        foreach ($speVeri as $key => $item) {
                                            $str="";
                                            if($key=="price_start" || $key=="price_en" || $key=="ad_name" || $key=="seller_name"){

                                            }else{
                                                $str.=" (spe.spe_id=".$item["no"]." and ( ";
                                                foreach ($item["value"] as $it) {
                                                    $str.=" spe.value = ".$it." or ";
                                                }
                                                $str=rtrim($str,"or ");
                                                $str.=" ))";

                                                $sorgu=$this->m_tr_model->query("select ilan.id from table_adverts_spe_field as spe
                                                left join table_adverts as ilan on spe.ads_id = ilan.id
                                                where ilan.status=1 and ilan.is_doping=0 and ".$str." group by ilan.id");

                                                if($sorgu){
                                                    foreach ($sorgu as $s){
                                                        $speData[$item["no"]]["value"][]=$s->id;
                                                    }
                                                }
                                            }


                                        }



                                        $uniqueValues = array();
                                        foreach ($speData as $dizi) {
                                            $uniqueValues = array_merge($uniqueValues, array_unique($dizi["value"]));
                                        }
                                        $valueCounts = array_count_values($uniqueValues);

                                        $matchingValues = array();
                                        foreach ($valueCounts as $value => $count) {
                                            if ($count === count($speData)) {
                                                $matchingValues[] = $value;
                                            }
                                        }
                                    }

                                    $match="";
                                    if($matchingValues){
                                        foreach ($matchingValues as $m){
                                            $match.=$m.",";
                                        }
                                    }
                                    $match=rtrim($match,",");


                                    /* if($amount){
                                         $kont=explode(" - ",$this->security->xss_clean($amount));
                                         if($kont){
                                             if(is_numeric($kont[0]) && is_numeric($kont[1])){
                                                 $specials.="  and ( ilan.price<=".$kont[1]." and  ilan.price>=".$kont[0]." ) ";
                                             }
                                         }
                                     }*/

                                    if($match){
                                        $specials.=" and ilan.id in(".$match.")";
                                    }
                                }
                                if($this->input->post("idsNormal")){
                                    //$wheres=" and ilanNo not in(";
                                    $explode=explode(",",$this->input->post("idsNormal"));
                                    $explode=array_filter($explode);
                                    foreach ($explode as $itemr) {
                                        $wheres.= "'".$itemr."',";
                                        $wdata[]=$itemr;
                                    }
                                    $wheres=rtrim($wheres,",");
                                    $ordereski=$order;
                                    $order=" ilanNo not in(".$wheres."),".$ordereski;
                                    $wheres="  ";
                                }

                                if($k1){

                                    if($pageNormal==0){

                                        $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.is_doping=0 ".$specials," order by  ".$order, "0",24);
                                    }else{

                                        $sorgu=$pageNormal;
                                        $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and  ilan.is_doping=0 ".$specials," order by  ".$order, $sorgu,$limit);
                                    }


                                }else{

                                    if($pageNormal==0){
                                        $sorgu=0;
                                    }else{
                                        if($this->input->post("filters") && $this->input->post("pageNormal")==24){
                                            $sorgu=24;
                                        }else{
                                            $sorgu=$pageNormal+$limit;
                                        }
                                    }
                                    $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=0 ".$specials," order by  ".$order, $sorgu,$limit);

                                }

                                if($veriler["veri"]){

                                    $sorgu=$pageNormal+$limit;
                                    $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.is_doping=0 ".$specials," order by  ".$order, $sorgu,$limit);

                                }
                            }else{
                                if($this->input->post("idsNormal")){
                                    //$wheres=" and ilanNo not in(";
                                    $explode=explode(",",$this->input->post("idsNormal"));
                                    $explode=array_filter($explode);
                                    foreach ($explode as $itemr) {
                                        $wheres.= "'".$itemr."',";
                                        $wdata[]=$itemr;
                                    }
                                    $wheres=rtrim($wheres,",");
                                    $ordereski=$order;
                                    $order=" ilanNo not in(".$wheres."),".$ordereski;
                                    $wheres="  ";
                                }


                                if($k1){
                                    if($pageNormal==0){
                                        $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=0 "," order by  ".$order, "0",$limit);
                                    }else{
                                        $sorgu=$pageNormal;
                                        $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=0 ".$wheres." "," order by  ".$order, $sorgu,$limit);
                                    }
                                }else{
                                    $sorgu=$pageNormal+$limit;
                                    $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=0 ".$wheres." "," order by  ".$order, $sorgu,$limit);
                                }
                                if($veriler){
                                    $sorgu=$pageNormal+$limit;
                                    $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=0 ".$wheres." "," order by  ".$order, $sorgu,$limit);
                                }
                            }
                        }

                        if($veriler["veri"]){

                            $veri=$this->createListAds($veriler["veri"],$wdata);
                            if($veri["str"]){
                                if($types==1){
                                    $sts="";
                                    if($veri["id"]){
                                        foreach ($veri["id"] as $item) {
                                            $sts.=$item.",";
                                        }
                                    }
                                    $sts=rtrim($sts,",");
                                    if($k1){
                                        if($page==0){
                                            echo json_encode(array("veri" => $veri["str"],"page" => 24,"lasts" => ($sonrasi)?"1":"" ));
                                        }else{
                                            if($this->input->post("filters")){
                                                echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":""  ));
                                            }else{
                                                echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":""  ));

                                            }
                                        }
                                    }else{
                                        echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":""  ,"ids" => $sts));
                                    }
                                }else{


                                    $sts="";
                                    if($veri["id"]){
                                        foreach ($veri["id"] as $item) {
                                            $sts.=$item.",";
                                        }
                                    }
                                    $sts=rtrim($sts,",");
                                    if($k1){
                                        if($pageNormal==0){
                                            echo json_encode(array("veri" => $veri["str"],"page" => 24,"lasts" => ($sonrasi)?"1":"" ));
                                        }else{
                                            if($this->input->post("filters")){
                                                echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":""  ));
                                            }else{
                                                echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":""  ));

                                            }
                                        }
                                    }else{
                                        echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":"" ,"ids" => $sts));
                                    }
                                }

                            }
                        }else{
                            echo json_encode(array("veri" => "nothing"));
                            exit;
                        }


                    }else{
                        redirect(base_url("404"));
                        exit;
                    }
                }


                if($this->input->post("types",true)==1)

                if($this->input->post("main") && $this->input->post("top") && $this->input->post("sub")){

                }
            }else{
                redirect(base_url("404"));
            }
        }else{
            redirect(base_url("404"));
        }
    }
    public function getListCategoryAjaxFilter(){
        if ($_POST) {

            if($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                //typecat:3 Son Kategori
                //typecat:2 Alt Kategori
                header('Content-Type: application/json');
                //types:1 vitrin
                //types:2 normal
                if($this->input->post("typecat")==3){
                    //En Alt Kategori Seçeneği
                    $page=$this->input->post("page",true);
                    $pageNormal=$this->input->post("pageNormal",true);
                    $limit=$this->input->post("limit",true);
                    if(is_numeric($page) && is_numeric($limit)){
                        if($page==-1){
                            $page=0;
                        }else if($page==-3){
                            $page=0;
                        }else{
                            $page=$page;
                        }
                    }else{
                        redirect(base_url("404"));
                        exit;
                    }

                    if(is_numeric($pageNormal) && is_numeric($limit)){
                        if($pageNormal==-1){
                            $pageNormal=0;
                        }else if($pageNormal==-3){
                            $pageNormal=0;
                        }else{
                            $pageNormal=$pageNormal;
                        }
                    }else{
                        redirect(base_url("404"));
                        exit;
                    }

                    $main=$this->input->post("main",true);
                    $top=$this->input->post("top",true);
                    $sub=$this->input->post("sub",true);
                    $types=$this->input->post("types",true);
                    $this->load->model("m_tr_model");
                    $order=$this->input->post("order",true);
                    $sonrasi="";
                    if(is_numeric($main) && is_numeric($top) && is_numeric($sub) && is_numeric($types) ){
                        if($types==2){
                            if($this->input->post("ordernormal") && $this->input->post("ordernormal")!="latest"){
                                if($order=="lat"){
                                    $k1="1";
                                    $order=" ilan.created_at desc ";
                                }else if($order=="most"){
                                    $k1="1";
                                    $order=" ilan.views desc ";
                                }else if($order=="oldest"){
                                    $k1="1";
                                    $order=" ilan.created_at asc ";
                                }else if($order=="inprice"){
                                    $k1="1";
                                    $order=" ilan.price asc ";
                                }else if($order=="deprice"){
                                    $k1="1";
                                    $order=" ilan.price desc ";
                                }
                            }else{
                                $k1="";
                                $order=" rand() ";
                            }
                        }else{
                            if($this->input->post("order") && $this->input->post("order")!="latest"){
                                if($order=="lat"){
                                    $k1="1";
                                    $order=" ilan.created_at desc ";
                                }else if($order=="most"){
                                    $k1="1";
                                    $order=" ilan.views desc ";
                                }else if($order=="oldest"){
                                    $k1="1";
                                    $order=" ilan.created_at asc ";
                                }else if($order=="inprice"){
                                    $k1="1";
                                    $order=" ilan.price asc ";
                                }else if($order=="deprice"){
                                    $k1="1";
                                    $order=" ilan.price desc ";
                                }
                            }else{
                                $k1="";
                                $order=" rand() ";
                            }
                        }





                        if($k1==""){
                            if($types==2){
                                if($this->input->post("idsNormal")){
                                    //$wheres=" and ilanNo not in(";
                                    $explode=explode(",",$this->input->post("idsNormal"));
                                    $explode=array_filter($explode);
                                    foreach ($explode as $itemr) {
                                        $wheres.= "'".$itemr."',";
                                        $wdata[]=$itemr;
                                    }
                                    $wheres=rtrim($wheres,",");
                                    $ordereski=$order;
                                    $order=" ilanNo not in(".$wheres."),".$ordereski;
                                    $wheres="  ";
                                }
                            }else{
                                if($this->input->post("ids")){
                                    //$wheres=" and ilanNo not in(";
                                    $explode=explode(",",$this->input->post("ids"));
                                    $explode=array_filter($explode);
                                    foreach ($explode as $itemr) {
                                        $wheres.= "'".$itemr."',";
                                        $wdata[]=$itemr;
                                    }
                                    $wheres=rtrim($wheres,",");
                                    $ordereski=$order;
                                    $order=" ilanNo not in(".$wheres."),".$ordereski;
                                    $wheres="  ";
                                }
                            }

                        }


                        $price_min=0;
                        $price_max=0;
                        $seller="";
                        $ads="";
                         if($types==1){
                             if($this->input->post("filters")){
                                 $specials="";
                                 parse_str($this->input->post("filters",true),$special);
                                 if($special){
                                     $speVeri=[];

                                     $amount="";
                                     //echo "123";
                                     $str="";
                                     foreach ($special as $key => $vals){
                                         if($key){

                                             if($key=="price_start" ){
                                                 $price_min=$vals;
                                             }else  if($key=="price_en" ){
                                                 $price_max=$vals;
                                             }else  if($key=="ad_name" ){
                                                 $ads=$vals;
                                             }else  if($key=="seller_name" ){
                                                 $seller=$vals;
                                             }else{
                                                 $speVeri[$this->security->xss_clean($key)]=array(
                                                     "no" => $this->security->xss_clean($key),
                                                     "value" => ""
                                                 );
                                                 $keyparse=str_replace("spe-","",$this->security->xss_clean($key));
                                                 $valparse="";
                                                 foreach ($vals as $val) {
                                                     $valparse.=str_replace("spe-","",$this->security->xss_clean($val)).",";
                                                 }
                                                 $valparse=rtrim($valparse,",");
                                                 $parseVale=explode(",",$valparse);
                                                 $speVeri[$this->security->xss_clean($key)]=array("no" => $keyparse ,"value" => $parseVale);
                                             }
                                         }
                                     }



                                     if($speVeri){
                                         $speData=[];
                                         $matchingAds = null;
                                         $matchingAds = null;
                                         foreach ($speVeri as $key => $item) {
                                             $str = " (spe.spe_id = " . $item["no"] . " AND spe.value IN ('" . implode("','", $item["value"]) . "'))";
                                             $query = "SELECT ilan.id FROM table_adverts_spe_field AS spe
                          INNER JOIN table_adverts AS ilan ON spe.ads_id = ilan.id
                          WHERE ilan.status = 1 AND ilan.is_doping = 1 AND " . $str . " GROUP BY ilan.id";

                                             $sorgu = $this->m_tr_model->query($query);
                                             if ($sorgu) {
                                                 $currentAds = array_map(function($s) {
                                                     return $s->id;
                                                 }, $sorgu);

                                                 if (is_null($matchingAds)) {
                                                     $matchingAds = $currentAds;
                                                 } else {
                                                     $matchingAds = array_intersect($matchingAds, $currentAds);
                                                 }
                                             } else {
                                                 $matchingAds = [];
                                                 break;
                                             }
                                         }

                                         if ($matchingAds) {
                                             $match = implode(",", $matchingAds);
                                         }

                                     }


                                     if($price_min || $price_max){
                                         if($price_min>=0 || $price_max>=0){
                                             if($price_min==0 && $price_max>=0){
                                                 //sadece max
                                                 if(is_numeric($price_max) && $price_max<10000000){
                                                     $price_max=$this->security->xss_clean($price_max);
                                                     if($price_max){
                                                         $specials.="  and ( ilan.price<=".$price_max." ) ";
                                                     }
                                                 }else{
                                                     echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                     exit;
                                                 }
                                             }else if($price_min>=0 && $price_max==0){
                                                 //sadece min
                                                 if(is_numeric($price_min) && $price_min<10000000){
                                                     $price_min=$this->security->xss_clean($price_min);
                                                     if($price_min){
                                                         $specials.="  and ( ilan.price>=".$price_min." ) ";
                                                     }
                                                 }else{
                                                     echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                     exit;
                                                 }
                                             }else if($price_min>=0 && $price_max>=0){
                                                 if($price_min<$price_max){
                                                     if(is_numeric($price_min) && $price_min<10000000 && is_numeric($price_max) && $price_max<10000000){
                                                         $price_min=$this->security->xss_clean($price_min);
                                                         $price_max=$this->security->xss_clean($price_max);
                                                         if($price_min && $price_max){
                                                             $specials.="  and ( ilan.price>=".$price_min." and ilan.price<=".$price_max." ) ";
                                                         }
                                                     }else{
                                                         echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                         exit;
                                                     }
                                                 }else{
                                                     echo json_encode(array("hata" => "var","message" => "Başlangıç Fiyatı Bitiş Fiyatından Büyük Olamaz"));
                                                     exit;
                                                 }
                                             }
                                         }
                                     }


                                     if($ads!=""){
                                         $temizAds=strip_tags($this->security->xss_clean($ads));
                                         if($_SESSION["lang"]==1){
                                             $specials.="  and ( ilan.ad_name like '%".$ads."%')  ";
                                         }else{
                                             $specials.="  and ( ilan.ad_name_en like '%".$ads."%')  ";
                                         }
                                     }

                                     if($seller!=""){
                                         $temizSell=strip_tags($this->security->xss_clean($seller));
                                         $specials.="  and ( users.magaza_name like '%".$temizSell."%')  ";
                                     }
                                     if($match){
                                         $specials.=" and ilan.id in(".$match.")";
                                     }else{
                                         $specials.=" and ilan.id in(0)";
                                     }
                                 }

                                 if($k1){
                                     if($page==0){
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 ".$specials," order by  ".$order, "0","24");
                                     }else{
                                         $sorgu=$page;
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 ".$specials," order by  ".$order, $sorgu,$limit);
                                     }
                                 }else{
                                     if($page==0){
                                         $sorgu=0;
                                     }else{
                                         $sorgu=$page+$limit;
                                     }
                                     $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 ".$specials," order by  ".$order, $sorgu,$limit);
                                 }

                                 if($veriler){
                                     $sorgu=$page+$limit;
                                     $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 ".$specials," order by  ".$order, $sorgu,$limit);
                                 }
                             }else{

                                 if($k1){
                                     if($page==0){
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 "," order by  ".$order, "0","24");
                                     }else{
                                         $sorgu=$page;
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 "," order by  ".$order, $sorgu,$limit);
                                     }
                                 }else{
                                     $sorgu=$page+$limit;
                                     $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 "," order by  ".$order, $sorgu,$limit);
                                 }
                                 if($veriler){
                                     $sorgu=$sorgu+$limit;
                                     $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=1 ".$specials," order by  ".$order, $sorgu,$limit);
                                 }
                             }


                         }
                         else{

                             $price_max="";
                             $price_min="";
                             $ads="";
                             $seller="";
                             if($this->input->post("filters")){
                                 $specials="";
                                 parse_str($this->input->post("filters",true),$special);
                                 if($special){
                                     $speVeri=[];

                                     $amount="";
                                     //echo "123";
                                     $str="";
                                     foreach ($special as $key => $vals){
                                         if($key){
                                             if($key=="price_start" ){
                                                 $price_min=$vals;
                                             }else  if($key=="price_en" ){
                                                 $price_max=$vals;
                                             }else  if($key=="ad_name" ){
                                                 $ads=$vals;
                                             }else  if($key=="seller_name" ){
                                                 $seller=$vals;
                                             }else{
                                                 $speVeri[$this->security->xss_clean($key)]=array(
                                                     "no" => $this->security->xss_clean($key),
                                                     "value" => ""
                                                 );
                                                 $keyparse=str_replace("spe-","",$this->security->xss_clean($key));
                                                 $valparse="";
                                                 foreach ($vals as $val) {
                                                     $valparse.=str_replace("spe-","",$this->security->xss_clean($val)).",";
                                                 }
                                                 $valparse=rtrim($valparse,",");
                                                 $parseVale=explode(",",$valparse);
                                                 $speVeri[$this->security->xss_clean($key)]=array("no" => $keyparse ,"value" => $parseVale);
                                             }
                                         }
                                     }



                                     if($speVeri){
                                         $speData=[];
                                         $matchingAds = null;
                                         $matchingAds = null;
                                         foreach ($speVeri as $key => $item) {
                                             $str = " (spe.spe_id = " . $item["no"] . " AND spe.value IN ('" . implode("','", $item["value"]) . "'))";
                                             $query = "SELECT ilan.id FROM table_adverts_spe_field AS spe
                          INNER JOIN table_adverts AS ilan ON spe.ads_id = ilan.id
                          WHERE ilan.status = 1 AND ilan.is_doping = 0 AND " . $str . " GROUP BY ilan.id";

                                             $sorgu = $this->m_tr_model->query($query);
                                             if ($sorgu) {
                                                 $currentAds = array_map(function($s) {
                                                     return $s->id;
                                                 }, $sorgu);

                                                 if (is_null($matchingAds)) {
                                                     $matchingAds = $currentAds;
                                                 } else {
                                                     $matchingAds = array_intersect($matchingAds, $currentAds);
                                                 }
                                             } else {
                                                 $matchingAds = [];
                                                 break;
                                             }
                                         }

                                         if ($matchingAds) {
                                             $match = implode(",", $matchingAds);
                                         }

                                     }


                                     if($price_min || $price_max){
                                         if($price_min>=0 || $price_max>=0){
                                             if($price_min==0 && $price_max>=0){
                                                 //sadece max
                                                 if(is_numeric($price_max) && $price_max<10000000){
                                                     $price_max=$this->security->xss_clean($price_max);
                                                     if($price_max){
                                                         $specials.="  and ( ilan.price<=".$price_max." ) ";
                                                     }
                                                 }else{
                                                     echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                     exit;
                                                 }
                                             }else if($price_min>=0 && $price_max==0){
                                                 //sadece min
                                                 if(is_numeric($price_min) && $price_min<10000000){
                                                     $price_min=$this->security->xss_clean($price_min);
                                                     if($price_min){
                                                         $specials.="  and ( ilan.price>=".$price_min." ) ";
                                                     }
                                                 }else{
                                                     echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                     exit;
                                                 }
                                             }else if($price_min>=0 && $price_max>=0){
                                                 if($price_min<$price_max){
                                                     if(is_numeric($price_min) && $price_min<10000000 && is_numeric($price_max) && $price_max<10000000){
                                                         $price_min=$this->security->xss_clean($price_min);
                                                         $price_max=$this->security->xss_clean($price_max);
                                                         if($price_min && $price_max){
                                                             $specials.="  and ( ilan.price>=".$price_min." and ilan.price<=".$price_max." ) ";
                                                         }
                                                     }else{
                                                         echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                         exit;
                                                     }
                                                 }else{
                                                     echo json_encode(array("hata" => "var","message" => "Başlangıç Fiyatı Bitiş Fiyatından Büyük Olamaz"));
                                                     exit;
                                                 }
                                             }
                                         }
                                     }


                                     if($ads!=""){
                                         $temizAds=strip_tags($this->security->xss_clean($ads));
                                         if($_SESSION["lang"]==1){
                                             $specials.="  and ( ilan.ad_name like '%".$ads."%')  ";
                                         }else{
                                             $specials.="  and ( ilan.ad_name_en like '%".$ads."%')  ";
                                         }
                                     }

                                     if($seller!=""){
                                         $temizSell=strip_tags($this->security->xss_clean($seller));
                                         $specials.="  and ( users.magaza_name like '%".$temizSell."%')  ";
                                     }
                                     /* if($amount){
                                          $kont=explode(" - ",$this->security->xss_clean($amount));
                                          if($kont){
                                              if(is_numeric($kont[0]) && is_numeric($kont[1])){
                                                  $specials.="  and ( ilan.price<=".$kont[1]." and  ilan.price>=".$kont[0]." ) ";
                                              }
                                          }
                                      }*/

                                     if($match){
                                         $specials.=" and ilan.id in(".$match.")";
                                     }else{
                                         $specials.=" and ilan.id in(0)";
                                     }
                                 }

                                 if($k1){
                                     if($pageNormal==0){
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=0 ".$specials," order by  ".$order, "0","24");
                                     }else{
                                         $sorgu=$pageNormal;
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=0 ".$specials," order by  ".$order, $sorgu,$limit);
                                     }
                                 }else{
                                     if($pageNormal==0){
                                         $sorgu=0;
                                     }else{
                                         $sorgu=$pageNormal+$limit;
                                     }
                                     $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=0 ".$specials," order by  ".$order, $sorgu,$limit);
                                 }

                                 if($veriler){
                                     $sorgu=$pageNormal+$limit;
                                     $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=0 ".$specials," order by  ".$order, $sorgu,$limit);
                                 }
                             }else{

                                 if($k1){
                                     if($pageNormal==0){
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=0 "," order by  ".$order, "0","24");
                                     }else{
                                         $sorgu=$pageNormal;
                                         $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=0 "," order by  ".$order, $sorgu,$limit);
                                     }
                                 }else{
                                     $sorgu=$pageNormal+$limit;
                                     $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=0 "," order by  ".$order, $sorgu,$limit);
                                 }
                                 if($veriler){
                                     $sorgu=$sorgu+$limit;
                                     $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top." and ilan.category_parent_id=".$sub." and ilan.is_doping=0 ".$specials," order by  ".$order, $sorgu,$limit);
                                 }
                             }
                         }

                         if($veriler["veri"]){
                            $veri=$this->createListAds($veriler["veri"],$wdata);
                            if($veri["str"]){

                                if($types==1){
                                    if($veri["id"]){
                                        foreach ($veri["id"] as $item) {
                                            $sts.=$item.",";
                                        }
                                    }
                                    $sts=rtrim($sts,",");
                                    if($k1){
                                        if($types==2){
                                            if($pageNormal==0){
                                                //echo json_encode(array("veri" => $veri["str"],"page" => 24,"lasts" => ($sonrasi)?"1":"" ,"s" => $veriler["sorgu"]));
                                                echo json_encode(array("veri" => $veri["str"],"page" => 24,"lasts" => ($sonrasi)?"1":"" ));
                                            }else{
                                                //echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":""  ,"s" => $veriler["sorgu"]));
                                                echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":""  ));
                                            }
                                        }else{
                                            if($page==0){
                                                //echo json_encode(array("veri" => $veri["str"],"page" => 24,"lasts" => ($sonrasi)?"1":"" ,"s" => $veriler["sorgu"]));
                                                echo json_encode(array("veri" => $veri["str"],"page" => 24,"lasts" => ($sonrasi)?"1":"" ));
                                            }else{
                                                //echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":""  ,"s" => $veriler["sorgu"]));
                                                echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":""  ));
                                            }
                                        }
                                    }else{
                                        if($types==2){
                                            //echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":""  ,"s" => $veriler["sorgu"],"ids" => $sts));
                                            echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":"" ,"ids" => $sts));
                                        }else{
                                            //echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":""  ,"s" => $veriler["sorgu"],"ids" => $sts));
                                            echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":"" ,"ids" => $sts));
                                        }
                                    }
                                }else{
                                    if($veri["id"]){
                                        foreach ($veri["id"] as $item) {
                                            $sts.=$item.",";
                                        }
                                    }
                                    $sts=rtrim($sts,",");
                                    if($k1){
                                        if($types==2){
                                            if($pageNormal==0){
                                                //echo json_encode(array("veri" => $veri["str"],"page" => 24,"lasts" => ($sonrasi)?"1":"" ,"s" => $veriler["sorgu"]));
                                                echo json_encode(array("veri" => $veri["str"],"page" => 24,"lasts" => ($sonrasi)?"1":"" ));
                                            }else{
                                                //echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":""  ,"s" => $veriler["sorgu"]));
                                                echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":"" ));
                                            }
                                        }else{
                                            if($page==0){
                                                //echo json_encode(array("veri" => $veri["str"],"page" => 24,"lasts" => ($sonrasi)?"1":"" ,"s" => $veriler["sorgu"]));
                                                echo json_encode(array("veri" => $veri["str"],"page" => 24,"lasts" => ($sonrasi)?"1":"" ));
                                            }else{
                                                //echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":""  ,"s" => $veriler["sorgu"]));
                                                echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":""  ));
                                            }
                                        }
                                    }else{
                                        if($types==2){
                                            //echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":""  ,"s" => $veriler["sorgu"],"ids" => $sts));
                                            echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":""  ,"ids" => $sts));
                                        }else{
                                            //echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":""  ,"s" => $veriler["sorgu"],"ids" => $sts));
                                            echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":""  ,"ids" => $sts));
                                        }
                                    }
                                }
                            }
                         }else{
                             echo json_encode(array("veri" => "nothing"));
                             exit;
                         }


                     }else{
                         redirect(base_url("404"));
                         exit;
                     }
                }
                else{

                    //En Alt Kategori Seçeneği
                    $page=$this->input->post("page",true);
                    $pageNormal=$this->input->post("pageNormal",true);
                    $limit=$this->input->post("limit",true);
                    if(is_numeric($page) && is_numeric($limit)){
                        if($page==-1){
                            $page=0;
                        }else if($page==-3){
                            $page=0;
                        }else{
                            $page=$page;
                        }
                    }else{
                        redirect(base_url("404"));
                        exit;
                    }

                    if(is_numeric($pageNormal) && is_numeric($limit)){
                        if($pageNormal==-1){
                            $pageNormal=0;
                        }else if($pageNormal==-3){
                            $pageNormal=0;
                        }else{
                            $pageNormal=$pageNormal;
                        }
                    }else{
                        redirect(base_url("404"));
                        exit;
                    }

                    $main=$this->input->post("main",true);
                    $top=$this->input->post("top",true);
                    $sub=$this->input->post("sub",true);
                    $types=$this->input->post("types",true);
                    $this->load->model("m_tr_model");
                    $order=$this->input->post("order",true);
                    $sonrasi="";
                    if(is_numeric($main) && is_numeric($top) && is_numeric($sub) && is_numeric($types) ){


                        if($types==2){
                            if($this->input->post("ordernormal") && $this->input->post("ordernormal")!="latest"){
                                if($order=="lat"){
                                    $k1="1";
                                    $order=" ilan.created_at desc ";
                                }else if($order=="most"){
                                    $k1="1";
                                    $order=" ilan.views desc ";
                                }else if($order=="oldest"){
                                    $k1="1";
                                    $order=" ilan.created_at asc ";
                                }else if($order=="inprice"){
                                    $k1="1";
                                    $order=" ilan.price asc ";
                                }else if($order=="deprice"){
                                    $k1="1";
                                    $order=" ilan.price desc ";
                                }
                            }else{
                                $k1="";
                                $order=" rand() ";
                            }
                        }else{
                            if($this->input->post("order") && $this->input->post("order")!="latest"){
                                if($order=="lat"){
                                    $k1="1";
                                    $order=" ilan.created_at desc ";
                                }else if($order=="most"){
                                    $k1="1";
                                    $order=" ilan.views desc ";
                                }else if($order=="oldest"){
                                    $k1="1";
                                    $order=" ilan.created_at asc ";
                                }else if($order=="inprice"){
                                    $k1="1";
                                    $order=" ilan.price asc ";
                                }else if($order=="deprice"){
                                    $k1="1";
                                    $order=" ilan.price desc ";
                                }
                            }else{
                                $k1="";
                                $order=" rand() ";
                            }
                        }

                        if($k1==""){
                            if($types==2){
                                if($this->input->post("idsNormal")){
                                    //$wheres=" and ilanNo not in(";
                                    $explode=explode(",",$this->input->post("idsNormal"));
                                    $explode=array_filter($explode);
                                    foreach ($explode as $itemr) {
                                        $wheres.= "'".$itemr."',";
                                        $wdata[]=$itemr;
                                    }
                                    $wheres=rtrim($wheres,",");
                                    $ordereski=$order;
                                    $order=" ilanNo not in(".$wheres."),".$ordereski;
                                    $wheres="  ";
                                }
                            }else{
                                if($this->input->post("ids")){
                                    //$wheres=" and ilanNo not in(";
                                    $explode=explode(",",$this->input->post("ids"));
                                    $explode=array_filter($explode);
                                    foreach ($explode as $itemr) {
                                        $wheres.= "'".$itemr."',";
                                        $wdata[]=$itemr;
                                    }
                                    $wheres=rtrim($wheres,",");
                                    $ordereski=$order;
                                    $order=" ilanNo not in(".$wheres."),".$ordereski;
                                    $wheres="  ";
                                }
                            }

                        }



                        if($types==1){

                            $price_min=0;
                            $price_max=0;
                            $seller="";
                            $ads="";
                            if($this->input->post("filters")){
                                $specials="";
                                parse_str($this->input->post("filters",true),$special);
                                if($special){

                                    $speVeri=[];

                                    $amount="";
                                    //echo "123";
                                    $str="";
                                    foreach ($special as $key => $vals){
                                        if($key){
                                            if($key=="price_start" ){
                                                $price_min=$vals;
                                            }else  if($key=="price_en" ){
                                                $price_max=$vals;
                                            }else  if($key=="ad_name" ){
                                                $ads=$vals;
                                            }else  if($key=="seller_name" ){
                                                $seller=$vals;
                                            }else{
                                                $speVeri[$this->security->xss_clean($key)]=array(
                                                    "no" => $this->security->xss_clean($key),
                                                    "value" => ""
                                                );
                                                $keyparse=str_replace("spe-","",$this->security->xss_clean($key));
                                                $valparse="";
                                                foreach ($vals as $val) {
                                                    $valparse.=str_replace("spe-","",$this->security->xss_clean($val)).",";
                                                }
                                                $valparse=rtrim($valparse,",");
                                                $parseVale=explode(",",$valparse);
                                                $speVeri[$this->security->xss_clean($key)]=array("no" => $keyparse ,"value" => $parseVale);
                                            }
                                        }
                                    }




                                    if($speVeri){
                                        $speData=[];
                                        $matchingAds = null;
                                        $matchingAds = null;
                                        foreach ($speVeri as $key => $item) {
                                            $str = " (spe.spe_id = " . $item["no"] . " AND spe.value IN ('" . implode("','", $item["value"]) . "'))";
                                            $query = "SELECT ilan.id FROM table_adverts_spe_field AS spe
                          INNER JOIN table_adverts AS ilan ON spe.ads_id = ilan.id
                          WHERE ilan.status = 1 AND ilan.is_doping = 1 AND " . $str . " GROUP BY ilan.id";

                                            $sorgu = $this->m_tr_model->query($query);
                                            if ($sorgu) {
                                                $currentAds = array_map(function($s) {
                                                    return $s->id;
                                                }, $sorgu);

                                                if (is_null($matchingAds)) {
                                                    $matchingAds = $currentAds;
                                                } else {
                                                    $matchingAds = array_intersect($matchingAds, $currentAds);
                                                }
                                            } else {
                                                $matchingAds = [];
                                                break;
                                            }
                                        }

                                        if ($matchingAds) {
                                            $match = implode(",", $matchingAds);
                                        }

                                    }


                                    if($match){
                                        $specials.=" and ilan.id in(".$match.")";
                                    }else{
                                        $specials.=" and ilan.id in(0)";
                                    }

                                    if($price_min || $price_max){
                                        if($price_min>=0 || $price_max>=0){
                                            if($price_min==0 && $price_max>=0){
                                                //sadece max
                                                if(is_numeric($price_max) && $price_max<10000000){
                                                    $price_max=$this->security->xss_clean($price_max);
                                                    if($price_max){
                                                        $specials.="  and ( ilan.price<=".$price_max." ) ";
                                                    }
                                                }else{
                                                    echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                    exit;
                                                }
                                            }else if($price_min>=0 && $price_max==0){
                                                //sadece min
                                                if(is_numeric($price_min) && $price_min<10000000){
                                                    $price_min=$this->security->xss_clean($price_min);
                                                    if($price_min){
                                                        $specials.="  and ( ilan.price>=".$price_min." ) ";
                                                    }
                                                }else{
                                                    echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                    exit;
                                                }
                                            }else if($price_min>=0 && $price_max>=0){
                                                if($price_min<$price_max){
                                                    if(is_numeric($price_min) && $price_min<10000000 && is_numeric($price_max) && $price_max<10000000){
                                                        $price_min=$this->security->xss_clean($price_min);
                                                        $price_max=$this->security->xss_clean($price_max);
                                                        if($price_min && $price_max){
                                                            $specials.="  and ( ilan.price>=".$price_min." and ilan.price<=".$price_max." ) ";
                                                        }
                                                    }else{
                                                        echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                        exit;
                                                    }
                                                }else{
                                                    echo json_encode(array("hata" => "var","message" => "Başlangıç Fiyatı Bitiş Fiyatından Büyük Olamaz"));
                                                    exit;
                                                }
                                            }
                                        }
                                    }


                                    if($ads!=""){
                                        $temizAds=strip_tags($this->security->xss_clean($ads));
                                        if($_SESSION["lang"]==1){
                                            $specials.="  and ( ilan.ad_name like '%".$ads."%')  ";
                                        }else{
                                            $specials.="  and ( ilan.ad_name_en like '%".$ads."%')  ";
                                        }
                                    }

                                    if($seller!=""){
                                        $temizSell=strip_tags($this->security->xss_clean($seller));
                                        $specials.="  and ( users.magaza_name like '%".$temizSell."%')  ";
                                    }
                                }

                                if($k1){

                                    if($page==0){
                                        $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=1 ".$specials," order by  ".$order, "0","24");
                                    }else{
                                        $sorgu=$page;
                                        $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=1 ".$specials," order by  ".$order, $sorgu,$limit);
                                    }
                                }else{

                                    if($page==0){
                                        $sorgu=0;
                                    }else{
                                        $sorgu=$page+$limit;
                                    }
                                    $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=1 ".$specials," order by  ".$order, $sorgu,$limit);
                                }

                                if($veriler){
                                    $sorgu=$page+$limit;
                                    $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=1 ".$specials," order by  ".$order, $sorgu,$limit);
                                }
                            }else{

                                if($k1){
                                    if($page==0){
                                        $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=1 "," order by  ".$order, "0","24");
                                    }else{
                                        $sorgu=$page;
                                        $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=1 "," order by  ".$order, $sorgu,$limit);
                                    }
                                }else{
                                    $sorgu=$page+$limit;
                                    $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=1 "," order by  ".$order, $sorgu,$limit);
                                }
                                if($veriler){
                                    $sorgu=$sorgu+$limit;
                                    $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=1 ".$specials," order by  ".$order, $sorgu,$limit);
                                }
                            }


                        }
                        else{

                            if($this->input->post("filters")){
                                $specials="";
                                parse_str($this->input->post("filters",true),$special);
                                if($special){
                                    $speVeri=[];

                                    $amount="";
                                    $str="";
                                    foreach ($special as $key => $vals){
                                        if($key){
                                            if($key=="price_start" ){
                                                $price_min=$vals;
                                            }else  if($key=="price_en" ){
                                                $price_max=$vals;
                                            }else  if($key=="ad_name" ){
                                                $ads=$vals;
                                            }else  if($key=="seller_name" ){
                                                $seller=$vals;
                                            }else{
                                                $speVeri[$this->security->xss_clean($key)]=array(
                                                    "no" => $this->security->xss_clean($key),
                                                    "value" => ""
                                                );
                                                $keyparse=str_replace("spe-","",$this->security->xss_clean($key));
                                                $valparse="";
                                                foreach ($vals as $val) {
                                                    $valparse.=str_replace("spe-","",$this->security->xss_clean($val)).",";
                                                }
                                                $valparse=rtrim($valparse,",");
                                                $parseVale=explode(",",$valparse);
                                                $speVeri[$this->security->xss_clean($key)]=array("no" => $keyparse ,"value" => $parseVale);
                                            }
                                        }
                                    }



                                    if($speVeri){
                                        $speData=[];
                                        $matchingAds = null;
                                        $matchingAds = null;
                                        foreach ($speVeri as $key => $item) {
                                            $str = " (spe.spe_id = " . $item["no"] . " AND spe.value IN ('" . implode("','", $item["value"]) . "'))";
                                            $query = "SELECT ilan.id FROM table_adverts_spe_field AS spe
                          INNER JOIN table_adverts AS ilan ON spe.ads_id = ilan.id
                          WHERE ilan.status = 1 AND ilan.is_doping = 0 AND " . $str . " GROUP BY ilan.id";

                                            $sorgu = $this->m_tr_model->query($query);
                                            if ($sorgu) {
                                                $currentAds = array_map(function($s) {
                                                    return $s->id;
                                                }, $sorgu);

                                                if (is_null($matchingAds)) {
                                                    $matchingAds = $currentAds;
                                                } else {
                                                    $matchingAds = array_intersect($matchingAds, $currentAds);
                                                }
                                            } else {
                                                $matchingAds = [];
                                                break;
                                            }
                                        }

                                        if ($matchingAds) {
                                            $match = implode(",", $matchingAds);
                                        }

                                    }


                                    if($price_min || $price_max){
                                        if($price_min>=0 || $price_max>=0){
                                            if($price_min==0 && $price_max>=0){
                                                //sadece max
                                                if(is_numeric($price_max) && $price_max<10000000){
                                                    $price_max=$this->security->xss_clean($price_max);
                                                    if($price_max){
                                                        $specials.="  and ( ilan.price<=".$price_max." ) ";
                                                    }
                                                }else{
                                                    echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                    exit;
                                                }
                                            }else if($price_min>=0 && $price_max==0){
                                                //sadece min
                                                if(is_numeric($price_min) && $price_min<10000000){
                                                    $price_min=$this->security->xss_clean($price_min);
                                                    if($price_min){
                                                        $specials.="  and ( ilan.price>=".$price_min." ) ";
                                                    }
                                                }else{
                                                    echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                    exit;
                                                }
                                            }else if($price_min>=0 && $price_max>=0){
                                                if($price_min<$price_max){
                                                    if(is_numeric($price_min) && $price_min<10000000 && is_numeric($price_max) && $price_max<10000000){
                                                        $price_min=$this->security->xss_clean($price_min);
                                                        $price_max=$this->security->xss_clean($price_max);
                                                        if($price_min && $price_max){
                                                            $specials.="  and ( ilan.price>=".$price_min." and ilan.price<=".$price_max." ) ";
                                                        }
                                                    }else{
                                                        echo json_encode(array("hata" => "var","message" => "Lütfen geçerli bir değer giriniz"));
                                                        exit;
                                                    }
                                                }else{
                                                    echo json_encode(array("hata" => "var","message" => "Başlangıç Fiyatı Bitiş Fiyatından Büyük Olamaz"));
                                                    exit;
                                                }
                                            }
                                        }
                                    }


                                     if($ads!=""){
                                         $temizAds=strip_tags($this->security->xss_clean($ads));
                                         if($_SESSION["lang"]==1){
                                             $specials.="  and ( ilan.ad_name like '%".$ads."%')  ";
                                         }else{
                                             $specials.="  and ( ilan.ad_name_en like '%".$ads."%')  ";
                                         }
                                     }

                                    if($seller!=""){
                                        $temizSell=strip_tags($this->security->xss_clean($seller));
                                        $specials.="  and ( users.magaza_name like '%".$temizSell."%')  ";
                                    }

                                    if($match){
                                        $specials.=" and ilan.id in(".$match.")";
                                    }else{
                                        $specials.=" and ilan.id in(0)";
                                    }
                                }




                                if($k1){

                                    if($pageNormal==0){
                                        $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=0 ".$specials," order by  ".$order, "0","24");
                                    }else{
                                        $sorgu=$pageNormal;
                                        $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=0 ".$specials," order by  ".$order, $sorgu,$limit);
                                    }
                                }else{

                                    if($pageNormal==0){
                                        $sorgu=0;
                                    }else{
                                        $sorgu=$pageNormal+$limit;
                                    }
                                    $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=0 ".$specials," order by  ".$order, $sorgu,$limit);


                                }

                                if($veriler){
                                    $sorgu=$pageNormal+$limit;
                                    $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=0 ".$specials," order by  ".$order, $sorgu,$limit);
                                }
                            }else{

                                if($k1){

                                    if($pageNormal==0){
                                        $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=0 "," order by  ".$order, "0","24");
                                    }else{
                                        $sorgu=$pageNormal;
                                        $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."and ilan.is_doping=0 "," order by  ".$order, $sorgu,$limit);
                                    }
                                }else{

                                    $sorgu=$pageNormal+$limit;
                                    $veriler=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=0 "," order by  ".$order, $sorgu,$limit);
                                }
                                if($veriler){
                                    $sorgu=$sorgu+$limit;
                                    $sonrasi=$this->ads_model->get_ads_list("and ilan.category_main_id=".$main." and ilan.category_top_id=".$top."  and ilan.is_doping=0 ".$specials," order by  ".$order, $sorgu,$limit);
                                }
                            }
                        }

                        if($veriler["veri"]){
                            $veri=$this->createListAds($veriler["veri"],$wdata);
                            if($veri["str"]){

                                if($types==1){
                                    if($veri["id"]){
                                        foreach ($veri["id"] as $item) {
                                            $sts.=$item.",";
                                        }
                                    }
                                    $sts=rtrim($sts,",");
                                    if($k1){
                                        if($types==2){
                                            if($pageNormal==0){
                                                echo json_encode(array("veri" => $veri["str"],"page" => 24,"lasts" => ($sonrasi)?"1":"" ));
                                            }else{
                                                echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":""  ));
                                            }
                                        }else{
                                            if($page==0){
                                                echo json_encode(array("veri" => $veri["str"],"page" => 24,"lasts" => ($sonrasi)?"1":"" ));
                                            }else{
                                                echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":""  ));
                                            }
                                        }
                                    }else{
                                        if($types==2){
                                            echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":""  ,"ids" => $sts));
                                        }else{
                                            echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":"" ,"ids" => $sts));
                                        }
                                    }
                                }else{
                                    if($veri["id"]){
                                        foreach ($veri["id"] as $item) {
                                            $sts.=$item.",";
                                        }
                                    }
                                    $sts=rtrim($sts,",");
                                    if($k1){
                                        if($types==2){
                                            if($pageNormal==0){
                                                echo json_encode(array("veri" => $veri["str"],"page" => 24,"lasts" => ($sonrasi)?"1":""));
                                            }else{
                                                echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":""  ));
                                            }
                                        }else{
                                            if($page==0){
                                                echo json_encode(array("veri" => $veri["str"],"page" => 24,"lasts" => ($sonrasi)?"1":"" ));
                                            }else{
                                                echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":""  ));
                                            }
                                        }
                                    }else{
                                        if($types==2){
                                            echo json_encode(array("veri" => $veri["str"],"page" => ($pageNormal+$limit),"lasts" => ($sonrasi)?"1":"" ,"ids" => $sts));
                                        }else{
                                            echo json_encode(array("veri" => $veri["str"],"page" => ($page+$limit),"lasts" => ($sonrasi)?"1":"" ,"ids" => $sts));
                                        }
                                    }
                                }
                            }
                        }else{
                            echo json_encode(array("veri" => "nothing"));
                            exit;
                        }


                    }else{
                        redirect(base_url("404"));
                        exit;
                    }
                }


                if($this->input->post("types",true)==1)

                if($this->input->post("main") && $this->input->post("top") && $this->input->post("sub")){

                }
            }else{
                redirect(base_url("404"));
            }
        }else{
            redirect(base_url("404"));
        }
    }

    private function createListAds($veriler,$ids=[]){
        $magazaSayfa=getLangValue(44,"table_pages",$_SESSION["lang"]);
        $str="";
        $ilanlar=getLangValue(34,"table_pages",$_SESSION["lang"]);
        $tokens=[];
        foreach ($veriler as $v) {
            $ll=getLangValue($v->ilanid,"table_adverts");
            $magaza=getTableSingle("table_users",array("id" => $v->userid,"is_magaza" => 1,"status" => 1,"banned" => 0));
            if($magaza){
               $ids[]=$v->ilanNo;
               $str.='<div class="col-lg-2 mt-4 col-md-6 col-6 col-sm-12" >
                            <div class="product-style-one no-overlay with-placeBid">
                                <div class="card-thumbnail">
                                    <a href="'.base_url(gg().$ilanlar->link."/".$ll->link).'">';
                                        if($v->img_1!=""){
                                            $str.='<img src="'. geti("ilanlar/".$v->img_1) .'" alt="'. $ll->name .'"></a>';
                                        }else if($v->img_2!=""){
                                            $str.='<img src="'. geti("ilanlar/".$v->img_2) .'" alt="'. $ll->name .'"></a>';
                                        }else if($v->img_3!=""){
                                            $str.='<img src="'. geti("ilanlar/".$v->img_3) .'" alt="'. $ll->name .'"></a>';
                                        }else{
                                            $str.='<img src="'.base_url("assets/images/no-photo.png") .'" alt="'. $ll->name .'"></a>';
                                        }
                            $str.='<a href="'.base_url(gg().$ilanlar->link."/".$ll->link).'" class="btn btn-primary">'.langS(182,2,$_SESSION["lang"]).'</a>
                                </div>
                                <div class="product-share-wrapper">
                                    <div class="profile-share">';
                                    if($magaza->magaza_logo!=""){
                                        if($magaza->rozet_dogrulanmis_profil==1) {
                                            $str.='<a href="'.base_url(gg().$magazaSayfa->link."/".$magaza->magaza_link).'" class="avatar" data-tooltip="'.langS(172,2).'"><img src="'. geti("users/store/".$magaza->magaza_logo) .'" alt="'. $magaza->magaza_name .'"></a>';
                                        }else {
                                            $str.='<a href="'.base_url(gg().$magazaSayfa->link."/".$magaza->magaza_link).'" ><img src="'. geti("users/store/".$magaza->magaza_logo) .'" alt="'. $magaza->magaza_name .'"></a>';
                                        }
                                }

                                $str.='<a class="more-author-text" href="'. base_url(gg().$magazaSayfa->link."/".$magaza->magaza_link) .'">'. $magaza->magaza_name .'</a>
                                    </div>
                                        
                                </div>';
                                    if($_SESSION["lang"]==1){
                                        $str.='<a href="'.base_url(gg().$ilanlar->link."/".$ll->link).'" class="mt-4"><span class="mt-3 product-name">'.$v->ad_name;
                                    }else{
                                        $str.='<a href="'.base_url(gg().$ilanlar->link."/".$ll->link).'" class="mt-4"><span class="mt-3 product-name">'.$v->ad_name_en;
                                    }

                                      $str.='<br><small style="color: var(--color-body);">';

                                        if($_SESSION["lang"]==1){
                                            $str.=strip_tags($v->desc_tr);
                                        }else{
                                            $str.=strip_tags($v->desc_en);
                                        }

                                       $str.='</small>';



                                        $str.='</span></a>
                                        
                                        <div class="bid-react-area">
                                            <div class="last-bid " >'. number_format($v->price,2) .' '.getcur().' </div>
                                                <div class="react-area">
                                                    <span class="number"><i class="fa fa-eye"></i> '.$v->vs.'</span>
                                                </div>
                                            </div>';
                                            if($v->type==1){
                                                $set=getTableSingle("table_options",array("id" => 1));

                                                $str.='<div class="adsVitrin">
                                                    <a href="" class="avatar" data-tooltip="'.langS(174,2,$_SESSION["lang"])  .'">
                                                        <img src="'. geti("icon/".$set->icon_otomatik) .'" alt="">
                                                    </a>
                                                </div>';
                                            }

                                            if($v->is_doping==1){
                                                $set=getTableSingle("table_options",array("id" => 1));
                                               $str.='<div class="adsDoping">
                                                    <a href="" class="avatar" data-tooltip="'.langS(181,2,$_SESSION["lang"])  .'">
                                                        <img src="'. geti("icon/".$set->icon_vitrin) .'" alt="">
                                                    </a>
                                                </div>';
                                            }
                                            if($magaza->rozet_dogrulanmis_profil==1){
                                                $set=getTableSingle("table_options",array("id" => 1));
                                                $str.='<div class="dogrulanmis">
                                                        <a href="" class="avatar" data-tooltip="'.langS(181,2,$_SESSION["lang"])  .'">
                                                            <img src="'. geti("icon/".$set->icon_dogrulanmis) .'" alt="">
                                                        </a>
                                                    </div>';
                                            }

                    $str.='</div></div>';
            }
        }

        return array("str" => $str,"id" => $ids);

    }


    //using
    public function getCategoryTopList(){
        if ($_POST) {
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                header('Content-Type: application/json');
                if ($this->input->post("veri", true)) {
                    if($this->input->get("t")){
                        $str="";
                        //üst kategori seçim
                        $kontrol=getTableSingle("table_advert_category",array("id" => $this->input->post("veri")));
                        $cektop=getTableOrder("table_advert_category",array("top_id" => $kontrol->top_id,"status" => 1,"parent_id" => $kontrol->id,"is_delete" => 0),"name","asc");
                        if($cektop){
                            $str.="<option value=''>Seçiniz</option>";
                            foreach ($cektop as $item) {
                                if($this->input->post("t")==1){
                                    $ll=getLangValue($item->id,"table_advert_category",$this->input->post("lang"));
                                    $str.='<option value="'.$item->id.'">'.$ll->name." (Komisyon: %".$item->commission_stoksuz.")".'</option>';
                                }else{
                                    $ll=getLangValue($item->id,"table_advert_category",$this->input->post("lang"));
                                    $str.='<option value="'.$item->id.'">'.$ll->name." (Komisyon: %".$item->commission.")".'</option>';
                                }
                            }
                            $special=$this->getCategorySpecial($kontrol,$cektop,$this->input->post("lang"));

                            if($special){
                                echo json_encode(array("veri" => $str,"spe" => $special));
                            }else{
                                echo json_encode(array("veri" => $str));
                            }

                        }else{
                            echo json_encode(array("veri" => "yok"));
                        }
                    }else{
                        $str="";
                        //ana kategori seçim
                        $cektop=getTableOrder("table_advert_category",array("top_id" => $this->input->post("veri"),"status" => 1,"parent_id" => 0,"is_delete" => 0),"name","asc");
                        if($cektop){
                            $str.="<option value=''>Seçiniz</option>";
                            foreach ($cektop as $item) {
                                if($this->input->post("t")==1){
                                    $ll=getLangValue($item->id,"table_advert_category",$this->input->post("lang"));
                                    $str.='<option value="'.$item->id.'">'.$ll->name." (Komisyon: %".$item->commission.")".'</option>';
                                }else{
                                    $ll=getLangValue($item->id,"table_advert_category",$this->input->post("lang"));
                                    $str.='<option value="'.$item->id.'">'.$ll->name." (Komisyon: %".$item->commission_stoksuz.")".'</option>';
                                }
                            }
                            echo json_encode(array("veri" => $str));
                        }else{
                            echo json_encode(array("veri" => "yok"));
                        }
                    }
                }else{
                    echo json_encode(array("veri" => "yok"));
                }
            }else{
                redirect(base_url("404"));
            }
        }else{
            redirect(base_url("404"));
        }
    }

    //ads special field Create
    private function getCategorySpecial($top,$main,$lang=1){
        if($main){
            $sp=getTableOrder("table_adverts_category_special",array("p_id" => $top->id),"order_id" ,"asc");

            if($sp){
                $strs='';

                foreach ($sp as $item) {
                    if($item->type==2){
                        //secenek
                        $r="";
                        if($lang==1){
                            if($item->is_required==1){
                                $r="required data-msg='".langS(8,2)."'";
                            }
                            $strs.='<div class="col-lg-4">
                                        <div class="input-box pb--20">
                                        <label for="name" class="form-label">'.$item->name_tr.'</label>
                                        <select '.$r.' class="form-control selectss" name="sp'.$item->id.'" >
                                        <option value="">'.langS(86,2,$lang)."</option>";
                            $sec=explode(",",$item->secenek_tr);
                            $order=0;
                            foreach ($sec as $s){
                                $strs.='<option value="'.$order.'">'.$s.'</option>';
                                $order++;
                            }
                            $strs.='</select></div></div>';
                        }else{
                            $strs.='<div class="input-box pb--20">
                                    <label for="name" class="form-label">'.$item->name_en.'</label>';

                        }

                    }
                }
                if($strs!=""){
                    return $strs;
                }else{
                    return false;
                }
            }
        }else{

        }
    }

    //using
    public function setCreateAdNStock(){
        if ($_POST) {
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                header('Content-Type: application/json');
                $user=getActiveUsers();
                if($user){
                    if($user->is_magaza==1){
                        $gl=$this->input->post("lang");
                        $this->load->library("form_validation");
                        $this->form_validation->set_rules("nametr", str_replace("\r\n", "", langS(79, 2,$gl)), "required|trim|min_length[20]|max_length[100]"
                            ,array(
                                "min_length" => str_replace("[field]","{field}",str_replace("[s]","20",langS(59,2,$gl))),
                                "max_length" => str_replace("[field]","{field}",str_replace("[s]","100",langS(60,2,$gl)))
                            ));
                        $this->form_validation->set_rules("icerik_tr", str_replace("\r\n", "", langS(80, 2,$gl)), "required|trim|min_length[20]|max_length[2000]",array(
                            "min_length" => str_replace("[field]","{field}",str_replace("[s]","20",langS(59,2,$gl))),
                            "max_length" => str_replace("[field]","{field}",str_replace("[s]","2000",langS(60,2,$gl)))
                        ));
                        //Kategori bilgileri ve özel alan kontrolü
                        $this->form_validation->set_rules("mainCat", str_replace("\r\n", "", langS(99, 2,$gl)), "required|trim");
                        $mainCat=getTableSingle("table_advert_category",array("id" => $this->input->post("mainCat")));
                        if($mainCat){
                            $topCont=getTableSingle("table_advert_category",array("top_id" => $mainCat->id ,"parent_id" => 0,"status" => 1 ));
                            if($topCont){
                                $this->form_validation->set_rules("topCategory", str_replace("\r\n", "", langS(99, 2,$gl)), "required|trim");
                                if($this->input->post("topCategory")){
                                    $subCont=getTableSingle("table_advert_category",array("top_id" => $mainCat->id ,"parent_id" => $this->input->post("topCategory"),"status" => 1 ));
                                    if($subCont){
                                        $this->form_validation->set_rules("subCategory", str_replace("\r\n", "", langS(99, 2,$gl)), "required|trim");
                                    }
                                }
                            }
                        }
                        if($this->input->post("topCategory")){
                            $ozel=getTableOrder("table_adverts_category_special",array("p_id" => $this->input->post("topCategory"),"status" => 1,"is_required" => 1),"id","asc");
                            if($ozel){
                                foreach ($ozel as $oz) {
                                    if($gl==1){
                                        $names=$oz->name_tr;
                                    }else{
                                        $names=$oz->name_en;
                                    }
                                    $this->form_validation->set_rules("sp".$oz->id,str_replace("\r\n", "",$names));
                                }
                            }
                        }else{
                            $ozel=getTableOrder("table_adverts_category_special",array("p_id" => $this->input->post("mainCat"),"status" => 1,"is_required" => 1),"id","asc");
                            if($ozel){
                                foreach ($ozel as $oz) {
                                    if($gl==1){
                                        $names=$oz->name_tr;
                                    }else{
                                        $names=$oz->name_en;
                                    }
                                    $this->form_validation->set_rules("sp".$oz->id,str_replace("\r\n", "",$names));
                                }
                            }
                        }
                        $this->form_validation->set_rules("price", str_replace("\r\n", "", langS(84, 2,$gl)), "required|trim");
                        $this->form_validation->set_rules("times", str_replace("\r\n", "", langS(85, 2,$gl)), "required|trim");
                        $this->form_validation->set_rules("sozlesme", str_replace("\r\n", "", langS(99, 2,$gl)), "required|trim",array(
                            "required" => langS(102,2,$gl)
                        ));
                        if($_FILES["fatima"]["tmp_name"]!="" || $_FILES["fatima2"]["tmp_name"]!="" || $_FILES["fatima3"]["tmp_name"]!=""){

                        }else{
                            $this->form_validation->set_rules("fatimas", langS(103,2,$gl), "required|trim",array(
                                "required" => langS(103,2,$gl)
                            ));
                        }
                        $this->form_validation->set_message(array(
                            "required"    =>	"{field} ".str_replace("\r\n","",langS(8,2,$gl))));
                        $val = $this->form_validation->run();
                        if($val){
                            $up="";
                            $up2="";
                            $up3="";

                            ///İsim, başlık ve link bilgileri
                            $opt=getTableSingle("options_general",array("id" => 1));
                            $nametr=veriTemizle($this->security->xss_clean($this->input->post("nametr")));
                            $linktr=permalink($nametr)."-".rand(1000000,9999999);
                            $desctr=$this->input->post("icerik_tr");
                            if($this->input->post("nameen")!=""){
                                $nameen=veriTemizle($this->security->xss_clean($this->input->post("nameen")));
                            }else{
                                $nameen=$nametr;
                            }
                            if($this->input->post("icerik_en")!=""){
                                $descen=$this->input->post("icerik_en");
                            }else{
                                $descen=$desctr;
                            }
                            $linken=permalink($nameen)."-".rand(1000000,9999999);
                            ///İsim, başlık ve link bilgileri
                            $enc="";
                            $getLang=getTable("table_langs",array("status" => 1));
                            if($getLang){
                                foreach ($getLang as $item) {
                                    if($item->id==1){
                                        $langValue[]=array(
                                            "lang_id" => $item->id,
                                            "stitle" => $nametr." | ".$opt->site_name,
                                            "sdesc" => $nametr,
                                            "link" => $linktr,
                                        );
                                    }else{
                                        $langValue[]=array(
                                            "lang_id" => $item->id,
                                            "stitle" => $nameen." | ".$opt->site_name,
                                            "sdesc" => $nametr,
                                            "link" => $linken,
                                        );
                                    }

                                }
                                $enc= json_encode($langValue);
                            }

                            if($_FILES["fatima"]["tmp_name"]!=""){
                                if ($_FILES["fatima"]["tmp_name"] != "") {
                                    $ext = pathinfo($_FILES["fatima"]["name"], PATHINFO_EXTENSION);
                                    $up = img_upload($_FILES["fatima"], $nametr."-1-".rand(1,234508), "ilanlar", "", "", "");
                                }
                                if ($_FILES["fatima2"]["tmp_name"] != "") {
                                    $ext = pathinfo($_FILES["fatima2"]["name"], PATHINFO_EXTENSION);
                                    $up2 = img_upload($_FILES["fatima2"], $nametr."-2-".rand(1,234508), "ilanlar", "", "", "");
                                }
                                if ($_FILES["fatima3"]["tmp_name"] != "") {
                                    $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);
                                    $up3 = img_upload($_FILES["fatima3"], $nametr."-3-".rand(1,234508), "ilanlar", "", "", "");
                                }
                            }else{
                                if($_FILES["fatima2"]["tmp_name"]!=""){
                                    $ext = pathinfo($_FILES["fatima2"]["name"], PATHINFO_EXTENSION);
                                    $up1 = img_upload($_FILES["fatima2"], $nametr."-1-".rand(1,234508), "ilanlar", "", "", "");
                                    if ($_FILES["fatima3"]["tmp_name"] != "") {
                                        $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);
                                        $up2 = img_upload($_FILES["fatima3"], $nametr."-3-".rand(1,234508), "ilanlar", "", "", "");
                                    }
                                }else{
                                    if($_FILES["fatima3"]["tmp_name"]!=""){
                                        $ext = pathinfo($_FILES["fatima3"]["name"], PATHINFO_EXTENSION);
                                        $up = img_upload($_FILES["fatima3"], $nametr."-3-".rand(1,234508), "ilanlar", "", "", "");
                                    }
                                }
                            }

                            $token=tokengenerator(9,2);
                            $token=$this->getTokenControlAds($token);
                            if(is_numeric($this->input->post("price")) && $this->input->post("price")>0 ){
                                if($user->magaza_ozel_komisyon!=0 && $user->magaza_ozel_komisyon!=""){
                                    $komisyon_oran=$user->magaza_ozel_komisyon;
                                    $komisyon=($this->input->post("price") * $user->magaza_ozel_komisyon)/100;
                                    $kazanc =$this->input->post("price") - $komisyon;
                                }else{
                                    if($this->input->post("topCategory")){
                                        if($this->input->post("subCategory")){
                                            $sub=getTableSingle("table_advert_category",array("id" => $this->input->post("subCategory")));
                                            if($sub){
                                                $komisyon_oran=$sub->commission_stoksuz;
                                                $komisyon=($this->input->post("price") * $sub->commission_stoksuz)/100;
                                                $kazanc =$this->input->post("price") - $komisyon;
                                            }
                                        }else{
                                            $top=getTableSingle("table_advert_category",array("id" => $this->input->post("topCategory")));
                                            if($top){
                                                $komisyon_oran=$top->commission_stoksuz;
                                                $komisyon=($this->input->post("price") * $top->commission_stoksuz)/100;
                                                $kazanc =$this->input->post("price") - $komisyon;
                                            }
                                        }


                                    }else{
                                        $komisyon_oran=$mainCat->commission_stoksuz;
                                        $komisyon=($this->input->post("price") * $mainCat->commission_stoksuz)/100;
                                        $kazanc =$this->input->post("price") - $komisyon;
                                    }
                                }
                                $ayar=getTableSingle("table_options",array("id" => 1));
                                if($ayar->admin_onay==1){
                                    $status=0;
                                }else{
                                    $status=1;
                                }
                                $kaydet=$this->m_tr_model->add_new(array(
                                    "ad_name" => $nametr,
                                    "cat_name" => $mainCat->name,
                                    "ad_name_en" => $nameen,
                                    "user_id" => $user->id,
                                    "type" => 0,
                                    "ilanNo" => $token,
                                    "category_main_id" => $mainCat->id,
                                    "category_top_id" => $this->input->post("topCategory"),
                                    "category_parent_id" => $this->input->post("subCategory"),
                                    "delivery_time" => $this->input->post("times"),
                                    "price" => $this->input->post("price"),
                                    "sell_price" => $kazanc,
                                    "commission" => $komisyon,
                                    "commission_oran" => $komisyon_oran,
                                    "status" => $status,
                                    "created_at" => date("Y-m-d H:i:s"),
                                    "img_1" => $up,
                                    "img_2" => $up2,
                                    "img_3" => $up3,
                                    "desc_en" => $descen,
                                    "desc_tr" => $desctr,
                                    "field_data" => $enc,
                                ),"table_adverts");
                                if($kaydet){
                                    if($this->input->post("topCategory")){
                                        $ozel=getTableOrder("table_adverts_category_special",array("p_id" => $this->input->post("topCategory"),"status" => 1),"id","asc");
                                        if($ozel){
                                            $order=0;
                                            foreach ($ozel as $oz) {
                                                $kaydetspe=$this->m_tr_model->add_new(array(
                                                    "ads_id" => $kaydet,
                                                    "spe_id" => $oz->id,
                                                    "value" => $this->input->post("sp".$oz->id),
                                                    "created_at" => date("Y-m-d H:i:s")
                                                ),"table_adverts_spe_field");
                                                $order++;
                                            }
                                        }
                                    }else{
                                        $ozel=getTableOrder("table_adverts_category_special",array("p_id" => $this->input->post("mainCat"),"status" => 1),"id","asc");
                                        if($ozel){
                                            $order=0;
                                            foreach ($ozel as $oz) {
                                                $kaydetspe=$this->m_tr_model->add_new(array(
                                                    "ads_id" => $kaydet,
                                                    "spe_id" => $oz->id,
                                                    "value" => $this->input->post("sp".$oz->id),
                                                    "created_at" => date("Y-m-d H:i:s")
                                                ),"table_adverts_spe_field");
                                            }
                                        }
                                    }
                                    if($status==1){
                                        echo json_encode(array("hata" => "yok","message" => langS(104,2,$gl)));
                                    }else{
                                        echo json_encode(array("hata" => "yok","message" => langS(105,2,$gl)));
                                    }
                                }else{
                                    echo json_encode(array("hata" => "var","message" => langS(106,2,$gl)));
                                }
                            }else{
                                echo json_encode(array("hata" =>"var","type" => "oturum"));
                            }
                        }else{
                            echo json_encode(array("hata" => "var","type" => "valid", "message" => validation_errors()));
                        }
                    }else{
                        echo json_encode(array("hata" =>"var","type" => "oturum"));
                    }
                }else{
                    echo json_encode(array("hata" =>"var","type" => "oturum"));
                }
            }else{
                redirect(base_url("404"));
            }
        }else{
            redirect(base_url("404"));
        }
    }

    private function getTokenControlAds($token){
        $cont=getTableSingle("table_adverts",array("ilanNo" => $token));
        if($cont){
            $token=$this->getTokenControlAds(tokengenerator(9,2));
        }else{
            return $token;
        }
    }

    //using
    public function getPriceNStockCom(){
        if ($_POST) {
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                header('Content-Type: application/json');
                $user=getActiveUsers();
                if($user){
                    if($user->is_magaza==1){
                        $gl=$this->input->post("lang");
                        if($this->input->post("price")){
                            if(is_numeric($this->input->post("price")) && $this->input->post("price")>0){
                                if($this->input->post("t")==1){
                                    if($this->input->post("main")){
                                        if($this->input->post("sub")){
                                            $cek=getTableSingle("table_advert_category",array("id" => $this->input->post("sub"),"status" => 1));
                                            $hesapla=($this->input->post("price") * $cek->commission_stoksuz)/100;
                                            echo json_encode(array(
                                                "unit" => number_format($this->input->post("price"),2)." ".getcur(),
                                                "komisyon" => number_format($hesapla,2)." ".getcur(),
                                                "komisyon_oran" => "%".$cek->commission_stoksuz,
                                                "cash" => number_format(($this->input->post("price") - $hesapla),2)." ".getcur()
                                            ));
                                        }else{
                                            if($this->input->post("top")){
                                                $cek=getTableSingle("table_advert_category",array("id" => $this->input->post("top"),"status" => 1));
                                                if($cek){
                                                    if($user->magaza_ozel_komisyon!=0 && $user->magaza_ozel_komisyon!=""){
                                                        $hesapla=($this->input->post("price") * $user->magaza_ozel_komisyon)/100;
                                                        echo json_encode(array(
                                                            "unit" => number_format($this->input->post("price"),2)." ".getcur(),
                                                            "komisyon" => number_format($hesapla,2)." ".getcur(),
                                                            "cash" => number_format(($this->input->post("price") - $hesapla),2)." ".getcur()
                                                        ));
                                                    }else{
                                                        $hesapla=($this->input->post("price") * $cek->commission_stoksuz)/100;
                                                        echo json_encode(array(
                                                            "unit" => number_format($this->input->post("price"),2)." ".getcur(),
                                                            "komisyon" => number_format($hesapla,2)." ".getcur(),
                                                            "komisyon_oran" => "%".$cek->commission_stoksuz,
                                                            "cash" => number_format(($this->input->post("price") - $hesapla),2)." ".getcur()
                                                        ));
                                                    }

                                                }else{
                                                    //hata
                                                }

                                            }else{
                                                //hata
                                            }
                                        }
                                    }else{
                                        //hata
                                    }
                                }else{

                                }
                            }else{
                                //hata
                            }
                        }else{
                            //hata
                        }

                    }else{
                        echo json_encode(array("hata" =>"var","type" => "oturum"));
                    }
                }else{
                    echo json_encode(array("hata" =>"var","type" => "oturum"));
                }
            }else{
                redirect(base_url("404"));
            }
        }else{
            redirect(base_url("404"));
        }
    }

    public function myAdvertsList(){
        if (!getActiveUsers()) {
            redirect(base_url("404"));
            exit;
        }else{
            if($_POST){
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    $w = " s.user_id=".getActiveUsers()->id." ";
                    $join = "   ";
                    $toplam = $this->m_tr_model->query("select count(*) as sayi from table_adverts as s " . $join . " where " . $w);
                    $sql = "select s.id as ssid,
                        s.ilanNo  ,
                        s.ad_name as ilanAdi ,
                        s.type as ilanType ,
                        s.red_nedeni as redNedeni ,
                        s.price as ilanFiyat ,
                        s.img_1 as ilanResim ,
                        s.is_doping as ilanDoping ,
                        s.adet as stokAdet ,
                        s.kalan_adet as satAdet,
                        s.status as ilanDurum from table_adverts as s " . $join;
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
                        $filter = $this->m_tr_model->query("select count(*) as toplam from table_adverts as s  " . $join . (count($where) > 0 ? ' WHERE  ' . $w . ' and ( ' . implode(' or ', $where) : ' ') . "  ) ");
                    } else {
                        $filter = $this->m_tr_model->query("select count(*) as toplam from table_adverts as s " . $join . " where  " . $w);
                    }

                    $response["recordsFiltered"] = $filter[0]->toplam;
                    $iliski = "";
                    foreach ($veriler as $veri) {
                        $end="";
                        /* if($veri->ilanDoping==1){
                             $cek=$this->m_tr_model->getTableSingle("new_ilan_vitrin_user",array("ads_id" => $veri->ssid));
                             if($cek){
                                 $end=date("d-m-Y H:i",strtotime($cek->end_date));
                             }
                         }else {
                             $end="";
                         }*/
                        $link=getLangValue($veri->ssid,"table_adverts");

                        $response["data"][] = [
                            "ilanNo" => $veri->ilanNo,
                            "ilanAdi" => $veri->ilanAdi,
                            "ilanType" => $veri->ilanType,
                            "ilanFiyat" => $veri->ilanFiyat,
                            "redNedeni" => $veri->redNedeni,
                            "ilanResim" => $veri->ilanResim,
                            "ilanDoping" => $veri->ilanDoping,
                            "dopEnd" => $end,
                            "satAdet" => $veri->satAdet,
                            "ilanLink" => $link->link,
                            "stokAdet" => $veri->stokAdet,
                            "ilanDurum" => $veri->ilanDurum,
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
            }else{

            }
        }
    }
}


