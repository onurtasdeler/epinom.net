<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Order extends CI_Controller

{



    public $viewFile = "";

    public $viewFolder = "";

    public $kontrolSession = "";



    public function __construct()

    {

        parent::__construct();

        $this->load->library("form_validation");

        $this->load->helper("functions_helper");

        $this->load->helper("user_helper");

        if (!$this->session->userdata("userUniqFormRegisterControl")) {

            setSession2("userUniqFormRegisterControl", uniqid());

            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");

        } else {

            setSession2("userUniqFormRegisterControl", uniqid());

            $this->kontrolSession = $this->session->userdata("userUniqFormRegisterControl");

        }

        //$this->load->helper("netgsm_helper");



    }



    private function checkThrottle($uniqueKey)

    {

        $this->load->library('session');



        $lastRequestTime = $this->session->userdata($uniqueKey . '_last_request_time');

        $requestCount = $this->session->userdata($uniqueKey . '_request_count');



        if (empty($lastRequestTime) || (time() - $lastRequestTime) > $this->config->item('throttle_time_interval')) {

            // Zaman aşımı veya ilk istek, sıfırla

            $this->session->set_userdata($uniqueKey . '_last_request_time', time());

            $this->session->set_userdata($uniqueKey . '_request_count', 1);

            return true;

        } elseif ($requestCount < $this->config->item('throttle_limit')) {

            // Limit aşılmadı, arttır ve işleme devam et

            $this->session->set_userdata($uniqueKey . '_request_count', $requestCount + 1);

            return true;

        }



        return false;

    }





    private function getCartItemQty($productId)

    {

        foreach ($this->cart->contents() as $item) {

            //print_r($item);

            if ($item['id'] == $productId) {

                //print_r(array("adet" =>$item['qty'],"row" => $item["rowid"]));

                return array("adet" => $item['qty'], "row" => $item["rowid"]);

            }

        }



        // Eğer ürün sepette bulunamazsa 0 değerini döndür

        return 0;

    }





    private function updateBasketCardControl()

    {

        if($this->cart->contents()){

                        $degisen="";

                        $yenile="";

                        foreach ($this->cart->contents() as $cc){

                            $urun=getTableSingle("table_products",array("pro_token" => $cc["id"],"status" => 1));

                            if($urun){

                                if ($urun->is_discount == 1) {

                                    if($cc["price"]!=getProductPrice($urun->id)){

                                        //İndirimli ürünler için

                                        $data["price"] = $urun->price_sell_discount;

                                        $data["rowid"] = $cc["rowid"];

                                        $this->cart->update($data);

                                        $cur=getcur();

                                        $total=custom_number_format($this->cart->total())." ".$cur;

                                        $islem=$urun->price_sell_discount * $cc["qty"];

                                        $islem2=$urun->price_sell * $cc["qty"];

                                        $price=custom_number_format(($islem))." ".$cur;

                                        $price2=custom_number_format(($islem2))." ".$cur;

                                        $degisen.='$("#totalBasket").html(\''.$total.'\');$("#priceMain-'.$urun->pro_token.'").html("'.$price.'");';

                                        $degisen.='$("#priceDis-'.$urun->pro_token.'").html("'.$price2.'");';

                                    }



                                    $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                                    if ($ozelAlan) {

                                        if ($urun->stok >= $cc["qty"]) {



                                        }else{

                                            $data["qty"] = $urun->stok;

                                            $data["rowid"] = $cc["rowid"];

                                            $this->cart->update($data);

                                            $degisen.='$("#totalBasket").html(\''.$this->cart->total()." ".getcur().'\');$(".quantity[data-id=\''.$urun->pro_token.'\']").val('.$urun->stok.');$("#priceMain-'.$urun->pro_token.'").html("'.custom_number_format(($urun->price_sell_discount * $urun->stok))." ".getcur().'");$("#priceDis-'.$urun->pro_token.'").html("'.custom_number_format(($urun->price_sell * $urun->stok))." ".getcur().'");';

                                        }

                                    }else{

                                        if($urun->is_stock==1){



                                        }else{

                                            if($urun->is_api==0){

                                                $stokbak = getTable("table_products_stock", array("p_id" => $urun->id, "status" => 1,"prevision" => 0));

                                                if ($stokbak) {



                                                    if (count($stokbak) >= $cc["qty"]) {



                                                    }else{

                                                        $data["qty"] = count($stokbak);

                                                        $data["rowid"] = $cc["rowid"];

                                                        $this->cart->update($data);

                                                        $cur=getcur();

                                                        $total=custom_number_format($this->cart->total())." ".$cur;

                                                        $islem=($urun->price_sell_discount * count($stokbak));

                                                        $islem2=($urun->price_sell * count($stokbak));

                                                        $price=custom_number_format($islem)." ".$cur;

                                                        $price2=custom_number_format($islem2)." ".$cur;

                                                        $degisen.='$("#totalBasket").html(\''.$total.'\');$(".quantity[data-id=\''.$urun->pro_token.'\']").val('.count($stokbak).');$("#priceMain-'.$urun->pro_token.'").html("'.$price.'");$("#priceDis-'.$urun->pro_token.'").html("'.$price2.'");';

                                                    }

                                                }else{

                                                    $yenile="1";

                                                    $this->cart->remove($cc["rowid"]);

                                                }

                                            }else{

                                                if ($urun->pinabi_id > 0){
                                                    if ($urun->pinabi_stok >= $cc["qty"]) {



                                                    }else{
    
                                                        $data["qty"] = $urun->pinabi_stok;
    
                                                        $data["rowid"] = $cc["rowid"];
    
                                                        $this->cart->update($data);
    
                                                        $cur=getcur();
    
                                                        $total=custom_number_format($this->cart->total())." ".$cur;
    
                                                        $pr= ($urun->price_sell_discount * $urun->pinabi_stok);
    
                                                        $pr2= ($urun->price_sell * $urun->pinabi_stok);
    
                                                        $price=custom_number_format($pr)." ".$cur;
    
                                                        $price2=custom_number_format($pr2)." ".$cur;
    
                                                        $degisen.='var s=1;$("#totalBasket").html(\''.$total.'\');$(".quantity[data-id=\''.$urun->pro_token.'\']").val('.$urun->pinabi_stok.');$("#priceDis-'.$urun->pro_token.'").html("'.$price2.'");$("#priceMain-'.$urun->pro_token.'").html("'.$price.'");';
    
                                                    }
                                                }elseif ($urun->turkpin_id > 0){
                                                    if ($urun->turkpin_stok >= $cc["qty"]) {



                                                    }else{
    
                                                        $data["qty"] = $urun->turkpin_stok;
    
                                                        $data["rowid"] = $cc["rowid"];
    
                                                        $this->cart->update($data);
    
                                                        $cur=getcur();
    
                                                        $total=custom_number_format($this->cart->total())." ".$cur;
    
                                                        $pr= ($urun->price_sell_discount * $urun->turkpin_stok);
    
                                                        $pr2= ($urun->price_sell * $urun->turkpin_stok);
    
                                                        $price=custom_number_format($pr)." ".$cur;
    
                                                        $price2=custom_number_format($pr2)." ".$cur;
    
                                                        $degisen.='var s=1;$("#totalBasket").html(\''.$total.'\');$(".quantity[data-id=\''.$urun->pro_token.'\']").val('.$urun->turkpin_stok.');$("#priceDis-'.$urun->pro_token.'").html("'.$price2.'");$("#priceMain-'.$urun->pro_token.'").html("'.$price.'");';
    
                                                    }
                                                }

                                            }

                                        }

                                    }

                                } else {

                                    if($cc["price"]!=getProductPrice($urun->id)){

                                        $data["price"] = $urun->price_sell;

                                        $data["rowid"] = $cc["rowid"];

                                        $this->cart->update($data);

                                        $degisen.='$("#totalBasket").html(\''.$this->cart->total()." ".getcur().'\');$("#priceMain-'.$urun->pro_token.'").html("'.custom_number_format(($urun->price_sell * $cc["qty"]))." ".getcur().'");';

                                    }



                                    $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                                    if ($ozelAlan) {

                                        if ($urun->stok >= $cc["qty"]) {



                                        }else{

                                            $data["qty"] = $urun->stok;

                                            $data["rowid"] = $cc["rowid"];

                                            $this->cart->update($data);

                                            $degisen.='$("#totalBasket").html(\''.$this->cart->total()." ".getcur().'\');$(".quantity[data-id=\''.$urun->pro_token.'\']").val('.$urun->stok.');$("#priceMain-'.$urun->pro_token.'").html("'.custom_number_format(($urun->price_sell * $urun->stok))." ".getcur().'");';

                                        }

                                    }else{

                                        if($urun->is_stock==1){



                                        }else{

                                            if($urun->is_api==0){



                                                $stokbak = getTable("table_products_stock", array("p_id" => $urun->id, "status" => 1,"prevision" => 0));

                                                if ($stokbak) {



                                                    if (count($stokbak) >= $cc["qty"]) {



                                                    }else{

                                                        $data["qty"] = count($stokbak);

                                                        $data["rowid"] = $cc["rowid"];

                                                        $this->cart->update($data);

                                                        $degisen.='$("#totalBasket").html(\''.$this->cart->total()." ".getcur().'\');$(".quantity[data-id=\''.$urun->pro_token.'\']").val('.count($stokbak).');$("#priceMain-'.$urun->pro_token.'").html("'.custom_number_format(($urun->price_sell * count($stokbak)))." ".getcur().'");';

                                                    }

                                                }else{

                                                    $yenile="1";

                                                    $this->cart->remove($cc["rowid"]);

                                                }

                                            }else{

                                               if ($urun->pinabi_id > 0){
                                                if ($urun->pinabi_stok >= $cc["qty"]) {



                                                }else{

                                                    $data["qty"] = $urun->pinabi_stok;

                                                    $data["rowid"] = $cc["rowid"];

                                                    $this->cart->update($data);

                                                    $cur=getcur();

                                                    $total=custom_number_format($this->cart->total())." ".$cur;

                                                    $pr= ($urun->price_sell * $urun->pinabi_stok);

                                                    $price=custom_number_format($pr)." ".$cur;

                                                    $degisen.='var s=1;$("#totalBasket").html(\''.$total.'\');$(".quantity[data-id=\''.$urun->pro_token.'\']").val('.$urun->pinabi_stok.');$("#priceDis-'.$urun->pro_token.'").html("");$("#priceMain-'.$urun->pro_token.'").html("'.$price.'");';

                                                }
                                               }elseif($urun->turkpin_id > 0){
                                                if ($urun->turkpin_stok >= $cc["qty"]) {



                                                }else{

                                                    $data["qty"] = $urun->turkpin_stok;

                                                    $data["rowid"] = $cc["rowid"];

                                                    $this->cart->update($data);

                                                    $cur=getcur();

                                                    $total=custom_number_format($this->cart->total())." ".$cur;

                                                    $pr= ($urun->price_sell * $urun->turkpin_stok);

                                                    $price=custom_number_format($pr)." ".$cur;

                                                    $degisen.='var s=1;$("#totalBasket").html(\''.$total.'\');$(".quantity[data-id=\''.$urun->pro_token.'\']").val('.$urun->turkpin_stok.');$("#priceDis-'.$urun->pro_token.'").html("");$("#priceMain-'.$urun->pro_token.'").html("'.$price.'");';

                                                }
                                               }

                                            }

                                        }

                                    }

                                }

                            }else{

                                $par=explode("-",$cc["id"]);

                                if($par[1]){

                                    $urun=getTableSingle("table_products",array("pro_token" => $par[0],"status" => 1));

                                    if($urun){

                                        if ($urun->is_discount == 1) {

                                            //İndirimli ürünler için

                                            $data["price"] = $urun->price_sell_discount;

                                            $data["rowid"] = $cc["rowid"];

                                            $this->cart->update($data);

                                            $cur=getcur();

                                            $total=custom_number_format($this->cart->total())." ".$cur;

                                            $islem=$urun->price_sell_discount * $cc["qty"];

                                            $islem2=$urun->price_sell * $cc["qty"];

                                            $price=custom_number_format(($islem))." ".$cur;

                                            $price2=custom_number_format(($islem2))." ".$cur;

                                            $degisen.='$("#totalBasket").html(\''.$total.'\');$("#priceMain-'.$urun->pro_token."-".$par[1].'").html("'.$price.'");';

                                            $degisen.='$("#priceDis-'.$urun->pro_token."-".$par[1].'").html("'.$price2.'");';





                                            $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                                            if ($ozelAlan) {

                                                if ($urun->stok >= $cc["qty"]) {



                                                }else{

                                                    $data["qty"] = $urun->stok;

                                                    $data["rowid"] = $cc["rowid"];

                                                    $this->cart->update($data);

                                                    $degisen.='$("#totalBasket").html(\''.$this->cart->total()." ".getcur().'\');$(".quantity[data-id=\''.$urun->pro_token."-".$par[1].'\']").val('.$urun->stok.');$("#priceMain-'.$urun->pro_token."-".$par[1].'").html("'.custom_number_format(($urun->price_sell * $urun->stok))." ".getcur().'");';

                                                }

                                            }else{

                                                if($urun->is_stock==1){



                                                }else{

                                                    if($urun->is_api==0){

                                                        $stokbak = getTable("table_products_stock", array("p_id" => $urun->id, "status" => 1,"prevision" => 0));

                                                        if ($stokbak) {



                                                            if (count($stokbak) >= $cc["qty"]) {



                                                            }else{

                                                                $data["qty"] = count($stokbak);

                                                                $data["rowid"] = $cc["rowid"];

                                                                $this->cart->update($data);

                                                                $cur=getcur();

                                                                $total=custom_number_format($this->cart->total())." ".$cur;

                                                                $islem=($urun->price_sell_discount * count($stokbak));

                                                                $islem2=($urun->price_sell * count($stokbak));

                                                                $price=custom_number_format($islem)." ".$cur;

                                                                $price2=custom_number_format($islem2)." ".$cur;

                                                                $degisen.='$("#totalBasket").html(\''.$total.'\');$(".quantity[data-id=\''.$urun->pro_token.'\']").val('.count($stokbak).');$("#priceMain-'.$urun->pro_token.'").html("'.$price.'");$("#priceDis-'.$urun->pro_token.'").html("'.$price2.'");';

                                                            }

                                                        }else{

                                                            $yenile="1";

                                                            $this->cart->remove($cc["rowid"]);

                                                        }

                                                    }else{

                                                        if ($urun->turkpin_stok >= $cc["qty"]) {



                                                        }else{

                                                            $data["qty"] = $urun->turkpin_stok;

                                                            $data["rowid"] = $cc["rowid"];

                                                            $this->cart->update($data);

                                                            $cur=getcur();

                                                            $total=custom_number_format($this->cart->total())." ".$cur;

                                                            $pr= ($urun->price_sell_discount * $urun->turkpin_stok);

                                                            $pr2= ($urun->price_sell * $urun->turkpin_stok);

                                                            $price=custom_number_format($pr)." ".$cur;

                                                            $price2=custom_number_format($pr2)." ".$cur;

                                                            $degisen.='var s=1;$("#totalBasket").html(\''.$total.'\');$(".quantity[data-id=\''.$urun->pro_token.'\']").val('.$urun->turkpin_stok.');$("#priceDis-'.$urun->pro_token.'").html("'.$price2.'");$("#priceMain-'.$urun->pro_token.'").html("'.$price.'");';

                                                        }

                                                    }

                                                }

                                            }

                                        }

                                        else {



                                            $data["price"] = $urun->price_sell;

                                            $data["rowid"] = $cc["rowid"];

                                            $this->cart->update($data);

                                            $degisen.='$("#totalBasket").html(\''.$this->cart->total()." ".getcur().'\');$("#priceMain-'.$urun->pro_token."-".$par[1].'").html("'.custom_number_format(($urun->price_sell * $cc["qty"]))." ".getcur().'");';





                                            $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                                            if ($ozelAlan) {

                                                if ($urun->stok >= $cc["qty"]) {



                                                }else{

                                                    $data["qty"] = $urun->stok;

                                                    $data["rowid"] = $cc["rowid"];

                                                    $this->cart->update($data);

                                                    $degisen.='$("#totalBasket").html(\''.$this->cart->total()." ".getcur().'\');$(".quantity[data-id=\''.$urun->pro_token."-".$par[1].'\']").val('.$urun->stok.');$("#priceMain-'.$urun->pro_token."-".$par[1].'").html("'.custom_number_format(($urun->price_sell * $urun->stok))." ".getcur().'");';

                                                }

                                            }else{

                                                if($urun->is_stock==1){



                                                }else{

                                                    if($urun->is_api==0){



                                                        $stokbak = getTable("table_products_stock", array("p_id" => $urun->id, "status" => 1,"prevision" => 0));

                                                        if ($stokbak) {



                                                            if (count($stokbak) >= $cc["qty"]) {



                                                            }else{

                                                                $data["qty"] = count($stokbak);

                                                                $data["rowid"] = $cc["rowid"];

                                                                $this->cart->update($data);

                                                                $degisen.='$("#totalBasket").html(\''.$this->cart->total()." ".getcur().'\');$(".quantity[data-id=\''.$urun->pro_token.'\']").val('.count($stokbak).');$("#priceMain-'.$urun->pro_token.'").html("'.custom_number_format(($urun->price_sell * count($stokbak)))." ".getcur().'");';

                                                            }

                                                        }else{

                                                            $yenile="1";

                                                            $this->cart->remove($cc["rowid"]);

                                                        }

                                                    }else{

                                                        if ($urun->turkpin_stok >= $cc["qty"]) {



                                                        }else{

                                                            $data["qty"] = $urun->turkpin_stok;

                                                            $data["rowid"] = $cc["rowid"];

                                                            $this->cart->update($data);

                                                            $cur=getcur();

                                                            $total=custom_number_format($this->cart->total())." ".$cur;

                                                            $pr= ($urun->price_sell * $urun->turkpin_stok);

                                                            $price=custom_number_format($pr)." ".$cur;

                                                            $degisen.='var s=1;$("#totalBasket").html(\''.$total.'\');$(".quantity[data-id=\''.$urun->pro_token."-".$par[1].'\']").val('.$urun->turkpin_stok.');$("#priceDis-'.$urun->pro_token."-".$par[1].'").html("");$("#priceMain-'.$urun->pro_token."-".$par[1].'").html("'.$price.'");';

                                                        }

                                                    }

                                                }

                                            }

                                        }

                                    }

                                }

                                //$this->cart->remove($cc["rowid"]);

                            }

                        }



                    }

    }





    private function sepetToken($token="")

    {

        $tokenr=getTableSingle("table_orders",array("sipNo" => $token));

        if($tokenr){

            $tokens=tokengenerator(10,2);

            return $this->sepetToken($tokens);

        }else{

            return $token;

        }

    }

    public function setBasketComplate()

    {

        $this->load->model("m_tr_model");

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

                    header('Content-Type: application/json');

                    if (getActiveUsers()) {

                        if ($this->cart->contents()) {



                            $this->updateBasketCardControl();

                            if(count($this->cart->contents())<=20){

                                if (getActiveUsers()->balance >= $this->cart->total()) {

                                    $token=tokengenerator(10,2);

                                    $token=$this->sepetToken($token);

                                    foreach ($this->cart->contents() as $basket) {

                                        $urun = getTableSingle("table_products", array("pro_token" => $basket["id"], "status" => 1));

                                        if($urun){

                                            $kaydet=$this->m_tr_model->add_new(

                                                array(

                                                    "user_id" => getActiveUsers()->id,

                                                    "product_id" => $urun->id,

                                                    "price_gelis" => $urun->price,

                                                    "price" => $urun->price_sell,

                                                    "price_discount" => $urun->price_sell_discount,

                                                    "quantity" => $basket["qty"],

                                                    "total_price" => $basket["subtotal"],

                                                    "status" => 1,

                                                    "created_at" => date("Y-m-d H:i:s"),

                                                    "sipNo" => $token,

                                                    "marj" => $urun->price_marj,

                                                    "prevision" => 1,

                                                ),"table_orders");

                                            if(!$kaydet){

                                                $hata=1;

                                            }

                                        }else{

                                            $par=explode("-",$basket["id"]);

                                            if($par[1]){

                                                $urun = getTableSingle("table_products", array("pro_token" => $par[0], "status" => 1));

                                                if($urun){

                                                    $spe="";

                                                    if($basket["options"]){

                                                        foreach ($basket["options"] as $key => $opt){

                                                            $spe=$opt;

                                                        }

                                                    }

                                                    $kaydet=$this->m_tr_model->add_new(

                                                        array(

                                                            "user_id" => getActiveUsers()->id,

                                                            "product_id" => $urun->id,

                                                            "price_gelis" => $urun->price,

                                                            "price" => $urun->price_sell,

                                                            "price_discount" => $urun->price_sell_discount,

                                                            "quantity" => $basket["qty"],

                                                            "total_price" => $basket["subtotal"],

                                                            "status" => 1,

                                                            "created_at" => date("Y-m-d H:i:s"),

                                                            "sipNo" => $token,

                                                            "marj" => $urun->price_marj,

                                                            "prevision" => 1,

                                                            "special_field" => json_encode($basket["options"]),

                                                        ),"table_orders");

                                                    if(!$kaydet){

                                                        $hata=1;

                                                    }

                                                }else{

                                                    $this->cart->remove($basket["rowid"]);

                                                }

                                            }else{

                                                $this->cart->remove($basket["rowid"]);



                                            }

                                        }

                                    }

                                    if(!$hata){

                                        $start=$this->orderComplateStart($token);

                                    }



                                    //Sipariş kaydı yaoıldı buradan sonra sipariş analizi yapılarak koşula göre gönderim sağlanacak





                                } else {



                                }

                            }else{

                                echo json_encode(array("error" => true,"type" => "refresh","message" => ((lac()==1)?"Max Ürün Adedine Ulaştınız.":"You have reached the maximum number of products.") ));

                            }

                        }else{

                            echo json_encode(array("error" => true,"type" => "refresh","message" => ((lac()==1)?"Sepetinizde Ürün bulunamadı":"Your Basket is empty") ));

                        }

                    } else {

                        echo json_encode(array("error" => true, "type" => "refresh"));

                    }



                } else {

                    echo "Bu sayfaya erişiminiz yoktur";

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

    }





    private function orderComplateStart($token="")

    {

        $siparisler=getTableOrder("table_orders",array("sipNo" => $token,"status" => 1,"prevision" => 1),"id","asc");

        if($siparisler){

            $hata="";

            $hatalar=array();

            foreach ($siparisler as $item) {

                $urun=getTableSingle("table_products",array("id" => $item->product_id));

                if($urun){

                    $ozelAlan = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_required" => 1, "is_main" => 1));

                    if ($ozelAlan) {

                        $siparisStokluManuel=$this->isStockManuel($item,$urun);

                        if($siparisStokluManuel["hata"]==""){



                        }else{

                            array_push($hatalar,$siparisStokluManuel["hatalar"]);

                        }

                    }else{

                        if($urun->is_api==1){

							if ($urun->pinabi_id > 0){
								$siparisPinabiStock=$this->isStockApiPinabi($item,$urun);

								if($siparisPinabiStock["hata"] ==""){
								}else{
									//hata var
									array_push($hatalar,$siparisPinabiStock["hatalar"]);
								}
							}elseif ($urun->turkpin_id > 0){
								$siparisTurkpinStock=$this->isStockApiTurkpin($item,$urun);

								if($siparisTurkpinStock["hata"] ==""){
								}else{
									//hata var
									array_push($hatalar,$siparisTurkpinStock["hatalar"]);
								}
							}
                        }else{

                            if($urun->is_stock==1){

                                $siparisStokluSinirsiz=$this->isStockNo($item,$urun);

                            }else{

                                $siparisStokluManuel=$this->isStockManuel($item,$urun);

                                if($siparisStokluManuel["hata"]==""){



                                }else{

                                    array_push($hatalar,$siparisStokluManuel["hatalar"]);

                                }

                            }

                        }

                    }

                }

            }

            if($hata!=""){

                echo json_encode(array("error" => true));

            }else{

                $this->cart->destroy();

                echo json_encode(array("error" => false,"message" => langS(384,2)));

            }









        }

    }



    private function balanceLog($order,$urun,$eski)

    {



        $kaydet=$this->m_tr_model->add_new(

            array(

                "user_id" => getActiveUsers()->id,

                "type" => 0,

                "quantity" => $order->total_price,

                "qty" => $order->quantity,

                "description" => $urun->p_name." adlı ürün için ".$order->quantity." adet ürün alımı sağlanmıştır. ".custom_number_format($order->total_price)." ".getcur()." tutarında sipariş ücreti alıcıdan düşülmüştür. Alıcının önceki bakiyesi ".$eski." ".getcur()." - Yeni Bakiyesi :".getActiveUsers()->balance." ".getcur(),

                "product_id" => $urun->id,

                "created_at" =>date("Y-m-d H:i:s"),

                "status" => 2,

                "order_id" => $order->id,

            ),"table_users_balance_history");

        if($kaydet){

            $guncelle=$this->m_tr_model->updateTable("table_users_balance_history",array("islemNo" => "T-B".$kaydet."-".rand(100,999)),array("id" => $kaydet));

            return true;

        }else{

            return false;

        }

    }



    private function isStockManuel($item,$urun)

    {

        //stoksuz manuel gönderim

        $kontrolstok=getTableOrder("table_products_stock",array("p_id" => $urun->id,"status" => 1,"prevision" => 0),"id","asc",$item->quantity);

        if($kontrolstok){

            if(count($kontrolstok)>=$item->quantity){

                //sipariş gerçekleşecek

                $stoklar=array();

                $guncellenenler=array();

                $hata="";

                $hatavar="";

                $hatalar=array();

                foreach ($kontrolstok as $stok) {

                    $kontrol2=getTableSingle("table_products_stock",array("id" => $stok->id));

                    if($kontrol2->status==1 && $kontrol2->prevision==0){

                        $guncelleKod=$this->m_tr_model->updateTable("table_products_stock",array("status" => 2,

                            "sell_at" => date("Y-m-d H:i:s"),

                            "price" => $item->price,

                            "price_dis" => $item->price_discount,

                            "sell_user" => getActiveUsers()->id,

                            "prevision" => 1,

                            "order_id" => $item->id,

                            "prevision_time" => time()),

                            array("id" => $kontrol2->id));

                        array_push($stoklar,$kontrol2->stock_code);

                        array_push($guncellenenler,$kontrol2->id);

                    }else{

                        $hata=1;

                        //hata iptal edilecek

                    }

                }



                if($hata==""){

                    $user=getActiveUsers();

                    if($user->balance>=$item->total_price){

                        foreach ($kontrolstok as $stok) {

                            $guncelleKod = $this->m_tr_model->updateTable("table_products_stock",array(

                                "status" => 2,

                                "prevision" => 1,

                            ),

                                array("id" => $stok->id));

                        }

                        $dus = floatval($user->balance) - floatval($item->total_price);

                        $bakiyeGuncelle = $this->m_tr_model->updateTable("table_users",array("balance" => $dus),array("id" => $user->id));

                        $balanceHis = $this->balanceLog($item,$urun,$user->balance);

                        if($urun->bayi_id!=0){

                            $bayi_idd=$urun->bayi_id;

                            $bayi=getTableSingle("table_users",array("id" => $urun->bayi_id));

                            if($bayi){

                                $komisyon_bayi=$bayi->bayi_komisyon;

                                if($urun->is_discount==1){

                                    if($komisyon_bayi==0){

                                        $price = ($item->price_discount * $item->quantity);

                                        $hes = 0 ;

                                        $komisyon_bayi_tutar=0;

                                        $bayi_net_kazanc=$price;

                                    }else{

                                        $price = ($item->price_discount * $item->quantity);

                                        $hes = ($price * $komisyon_bayi)/100 ;

                                        $komisyon_bayi_tutar=$hes;

                                        $bayi_net_kazanc=$price - $hes;

                                    }



                                }else{

                                    if($komisyon_bayi==0){

                                        $price = ($item->price * $item->quantity);

                                        $hes = 0;

                                        $komisyon_bayi_tutar=0;

                                        $bayi_net_kazanc=$price ;

                                    }else{

                                        $price = ($item->price * $item->quantity);

                                        $hes = ($price * $komisyon_bayi)/100 ;

                                        $komisyon_bayi_tutar=$hes;

                                        $bayi_net_kazanc=$price - $hes;

                                    }



                                }

                            }

                            $updateOrder=$this->m_tr_model->updateTable("table_orders",array(

                                    "status" => 2,

                                    "bayi_idd" => $bayi_idd,

                                    "komisyon_bayi" => $komisyon_bayi,

                                    "komisyon_bayi_tutar" => $komisyon_bayi_tutar,

                                    "bayi_net_kazanc" => $bayi_net_kazanc,

                                    "codes" => json_encode($stoklar),

                                    "sell_at" => date("Y-m-d H:i:s"),

                                    "stock_id" => json_encode($guncellenenler),

                                )

                                ,array("id" =>$item->id));

                            $kazanc=$bayi->ilan_balance + $bayi_net_kazanc;

                            $bayiKazanc=$this->m_tr_model->updateTable("table_users",array("ilan_balance" => $kazanc),array("id" => $bayi->id));

                            $referrer_settings = getTableSingle('table_referral_settings',array('id'=>1));

                            if($referrer_settings->status) {

                                $userCek = getTableSingle('table_users',array('id'=>getActiveUsers()->id));

                                $referrerUserCek = getTableSingle('table_users',array('nick_name'=>$userCek->reference_username));

                                if($referrerUserCek) {

                                    $referansKazanc = ($referrer_settings->referral_type == 0 ? ($referrer_settings->referral_amount):(($item->total_price*$referrer_settings->referral_amount)/100));

                                    $insertEarning = $this->m_tr_model->add_new(

                                        array(

                                            "user_id" => $referrerUserCek->id,

                                            "referrer_id" => getActiveUsers()->id,

                                            "order_id" => $item->id,

                                            "amount" => $referansKazanc,

                                            "status" => 1,

                                            "created_at" => date("Y-m-d H:i:s")

                                        ),"table_referral_orders");

                                    $updateBalance = $this->m_tr_model->updateTable("table_users",array(

                                            'ilan_balance'=>$referrerUserCek->ilan_balance + $referansKazanc,

                                        ),

                                        array("id"=>$referrerUserCek->id)

                                    );

                                }

                            }

                        }else{

                            $updateOrder=$this->m_tr_model->updateTable("table_orders",array(

                                    "status" => 2,

                                    "codes" => json_encode($stoklar),

                                    "sell_at" => date("Y-m-d H:i:s"),

                                    "stock_id" => json_encode($guncellenenler),

                                )

                                ,array("id" =>$item->id));

                                $referrer_settings = getTableSingle('table_referral_settings',array('id'=>1));

                                if($referrer_settings->status) {

                                    $userCek = getTableSingle('table_users',array('id'=>getActiveUsers()->id));

                                    $referrerUserCek = getTableSingle('table_users',array('nick_name'=>$userCek->reference_username));

                                    if($referrerUserCek) {

                                        $referansKazanc = ($referrer_settings->referral_type == 0 ? ($referrer_settings->referral_amount):(($item->total_price*$referrer_settings->referral_amount)/100));

                                        $insertEarning = $this->m_tr_model->add_new(

                                            array(

                                                "user_id" => $referrerUserCek->id,

                                                "referrer_id" => getActiveUsers()->id,

                                                "order_id" => $item->id,

                                                "amount" => $referansKazanc,

                                                "status" => 1,

                                                "created_at" => date("Y-m-d H:i:s")

                                            ),"table_referral_orders");

                                        $updateBalance = $this->m_tr_model->updateTable("table_users",array(

                                                'ilan_balance'=>$referrerUserCek->ilan_balance + $referansKazanc,

                                            ),

                                            array("id"=>$referrerUserCek->id)

                                        );

                                    }

                                }

                        }



                        if($updateOrder && $bakiyeGuncelle){



                        }else{

                            $hatavar="1";

                            array_push($hatalar,$item->id);

                        }



                    }else{

                        foreach ($guncellenenler as $stok) {

                            $guncelleKod = $this->m_tr_model->updateTable("table_products_stock",array("status" => 1,

                                "sell_at" => null,

                                "price" => 0,

                                "sell_user" => 0,

                                "prevision" => 0,

                                "order_id" => 0,

                                "prevision_time" => null),

                                array("id" => $stok));

                            $siparis = $this->m_tr_model->updateTable("table_orders",array("status" => 5,"iptal_nedeni" => "Bakiyeniz Yetersiz olduğu için iptal edilmiştir."),array("id" => $item->id));

                        }



                    }

                }

            }else{

                //iptal edilecek

            }

        }else{

            $user=getActiveUsers();

            $dus = floatval($user->balance) - floatval($item->total_price);

            $bakiyeGuncelle = $this->m_tr_model->updateTable("table_users",array("balance" => $dus),array("id" => $user->id));

            $balanceHis = $this->balanceLog($item,$urun,$user->balance);

            if($urun->bayi_id!=0) {

                $bayi_idd = $urun->bayi_id;

                $bayi = getTableSingle("table_users", array("id" => $urun->bayi_id));

                if ($bayi) {

                    $komisyon_bayi = $bayi->bayi_komisyon;

                    if ($urun->is_discount == 1) {

                        if ($komisyon_bayi == 0) {

                            $price = ($item->price_discount * $item->quantity);

                            $hes = 0;

                            $komisyon_bayi_tutar = 0;

                            $bayi_net_kazanc = $price;

                        } else {

                            $price = ($item->price_discount * $item->quantity);

                            $hes = ($price * $komisyon_bayi) / 100;

                            $komisyon_bayi_tutar = $hes;

                            $bayi_net_kazanc = $price - $hes;

                        }



                    } else {

                        if ($komisyon_bayi == 0) {

                            $price = ($item->price * $item->quantity);

                            $hes = 0;

                            $komisyon_bayi_tutar = 0;

                            $bayi_net_kazanc = $price;

                        } else {

                            $price = ($item->price * $item->quantity);

                            $hes = ($price * $komisyon_bayi) / 100;

                            $komisyon_bayi_tutar = $hes;

                            $bayi_net_kazanc = $price - $hes;

                        }



                    }

                }

            }

        }



        return array("hata" => $hatavar,"hatalar" => $hatalar);

    }

    private function isStockNo($item,$urun)

    {

        if($item->quantity<getTableSingle("table_options",array("id" => 1))->default_max_sepet){

            $user=getActiveUsers();

            if($user){

                $dus = floatval($user->balance) - floatval($item->total_price);

                $bakiyeGuncelle = $this->m_tr_model->updateTable("table_users",array("balance" => $dus),array("id" => $user->id));

                $balanceHis = $this->balanceLog($item,$urun,$user->balance);

                $updateOrder=$this->m_tr_model->updateTable("table_orders",array( "status" => 1, ),array("id" =>$item->id));

                adminNot(getActiveUsers()->id,"siparis-guncelle/".$item->id,"Yeni Sipariş Geldi. Sipariş Beklemede",$urun->p_name." adlı ürün sipariş edildi. Manuel teslim etmeniz gerekiyor.");

                return true;

            }else{

                $hatavar=1;

                return array("hata" => $hatavar,"message" => ((lac()==1)?"Üye Yok":"No User"));

            }



        }else{

            $hatavar=1;

            return array("hata" => $hatavar,"message" => ((lac()==1)?"Max Adete ulaştınız":"Max Stock"));

        }

    }









    private function isStockApiTurkpin($item,$urun)

    {

        //stoklu apili gönderim

        $order=getTableSingle("table_orders",array("id" => $item->id,"status" => 1));

        if($order){

            $hata="";

            $hatavar="";

            $hatalar=array();

            $uruns=getTableSingle("table_products",array("id" => $urun->id));

            if($uruns){

                $user=getActiveUsers();

                if($user->status==1){

                    if($user->balance>=$order->total_price){

                        if($uruns->turkpin_stok>$order->quantity){

                            $dus=$user->balance - $order->total_price;

                            $bakiyeGuncelle = $this->m_tr_model->updateTable("table_users",array("balance" => $dus),array("id" => $user->id));

                            $balanceHis = $this->balanceLog($order,$uruns,$user->balance);

                            $guncelleJob=$this->m_tr_model->updateTable("table_orders",array(

                                "is_api_connect" => 1,

                                "is_api_job" => 0,

                                "update_at" => date("Y-m-d H:i:s")

                            ),array("id" => $order->id));

                            if(!$guncelleJob || !$bakiyeGuncelle){

                                $hatavar==1;

                            }

                        }else{

                            //Büyük ama olduğu kadar gönder

                        }

                    }else{

                        $siparis = $this->m_tr_model->updateTable("table_orders",array("status" => 5,"iptal_nedeni" => "Bakiyeniz Yetersiz Olduğu için iptal edildi."),array("id" => $item->id));

                    }

                }else{

                    $siparis = $this->m_tr_model->updateTable("table_orders",array("status" => 5,"iptal_nedeni" => "Üye Bulunamadı veya pasif olduğu için iptal edildi."),array("id" => $item->id));

                }

            }else{

                $siparis = $this->m_tr_model->updateTable("table_orders",array("status" => 5,"iptal_nedeni" => "Ürün Bulunamadı İptal Edildi."),array("id" => $item->id));

            }





        }

        return array("hata" => $hatavar,"hatalar" => $hatalar);

    }





	private function isStockApiPinabi($item,$urun)

    {

        //stoklu apili gönderim

        $order=getTableSingle("table_orders",array("id" => $item->id,"status" => 1));

        if($order){

            $hata="";

            $hatavar="";

            $hatalar=array();

            $uruns=getTableSingle("table_products",array("id" => $urun->id));

            if($uruns){

                $user=getActiveUsers();

                if($user->status==1){

                    if($user->balance>=$order->total_price){

                        if($uruns->pinabi_stok>$order->quantity){

                            $dus=$user->balance - $order->total_price;

                            $bakiyeGuncelle = $this->m_tr_model->updateTable("table_users",array("balance" => $dus),array("id" => $user->id));

                            $balanceHis = $this->balanceLog($order,$uruns,$user->balance);

                            $guncelleJob=$this->m_tr_model->updateTable("table_orders",array(

                                "is_api_connect" => 1,

                                "is_api_job" => 0,

                                "update_at" => date("Y-m-d H:i:s")

                            ),array("id" => $order->id));

                            if(!$guncelleJob || !$bakiyeGuncelle){

                                $hatavar==1;

                            }

                        }else{

                            //Büyük ama olduğu kadar gönder

                        }

                    }else{

                        $siparis = $this->m_tr_model->updateTable("table_orders",array("status" => 5,"iptal_nedeni" => "Bakiyeniz Yetersiz Olduğu için iptal edildi."),array("id" => $item->id));

                    }

                }else{

                    $siparis = $this->m_tr_model->updateTable("table_orders",array("status" => 5,"iptal_nedeni" => "Üye Bulunamadı veya pasif olduğu için iptal edildi."),array("id" => $item->id));

                }

            }else{

                $siparis = $this->m_tr_model->updateTable("table_orders",array("status" => 5,"iptal_nedeni" => "Ürün Bulunamadı İptal Edildi."),array("id" => $item->id));

            }





        }

        return array("hata" => $hatavar,"hatalar" => $hatalar);

    }





















}





