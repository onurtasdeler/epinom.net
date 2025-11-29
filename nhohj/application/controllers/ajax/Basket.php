<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Basket extends CI_Controller
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

    //sepet detay
    public function getBasketProInfo()
    {
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    if ($this->input->post("data", true) && $this->input->post("quantity", true) && $this->input->post("quantity") != 0) {
                        $token = getTableSingle("table_users",array("token" => $this->input->post("token")));
                        if (!$token) {
                            unset($_SESSION["basketTemp"]);
                            echo json_encode(array("err" => "oturum"));
                        } else {
                            $ayarcek=getTableSingle("table_onay_kisit",array("id" => 1));
                            if($ayarcek){
                                $parcaepin=explode("-",$ayarcek->epin_siparis);
                                $urun = getTableSingle("table_products", array("status" => 1, "token" => $this->input->post("data", true)));
                                $getLang = getLangValue($urun->id, "table_products");
                                if($parcaepin[0]==1){
                                    if($token->tel_onay==1){
                                        if ($urun) {
                                            $tc ="2";
                                            $category = getTableSingle("table_products_category", array("id" => $urun->category_id, "status" => 1));
                                            if ($category) {
                                                if ($category->is_tc == 1) {
                                                    $getUser = getActiveUsers();
                                                    if ($getUser) {
                                                        if ($getUser->tc_onay == 0) {
                                                            $tc = "1";
                                                        } else {
                                                            $tc = "2";
                                                        }
                                                    }
                                                }else{
                                                    $tc = "2";
                                                }
                                            }
                                            $this->load->helper("products_helper");
                                            $price = getProductPrice($urun->id);
                                            $price = $this->input->post("quantity") * $price;
                                            $getLang = getLangValue($urun->id, "table_products");
                                            if ($getLang) {
                                                $ozel = $this->getBasketInfoSpecial($urun);
                                                if ($ozel) {
                                                    $this->setSessionTempBasket($urun, $this->input->post("quantity"), $price);
                                                    echo json_encode(array("price" => floor($price*100)/100 . " " . getcur(), "name" => $getLang->name, "uyari" => $getLang->uyari, "tc" => $tc, "image" => $urun->image, "ozel_alanlar" => $ozel));
                                                } else {

                                                    $this->setSessionTempBasket($urun, $this->input->post("quantity"), $price);
                                                    echo json_encode(array("price" => floor($price*100)/100 . " " . getcur(), "name" => $getLang->name, "uyari" => $getLang->uyari, "tc" => $tc, "image" => $urun->image, "ozel_alanlar" => $ozel));
                                                }
                                            }


                                        } else {
                                            unset($_SESSION["basketTemp"]);
                                            echo json_encode(array("errs" => true));
                                        }
                                    }else{
                                        unset($_SESSION["basketTemp"]);
                                        echo json_encode(array("errs" => true,"type" => "nso","name" => $getLang->name));
                                    }
                                }else{
                                    $urun = getTableSingle("table_products", array("status" => 1, "token" => $this->input->post("data", true)));
                                    if ($urun) {
                                        $tc ="2";
                                        $category = getTableSingle("table_products_category", array("id" => $urun->category_id, "status" => 1));
                                        if ($category) {
                                            if ($category->is_tc == 1) {
                                                $getUser = getActiveUsers();
                                                if ($getUser) {
                                                    if ($getUser->tc_onay == 0) {
                                                        $tc = "1";
                                                    } else {
                                                        $tc = "2";
                                                    }
                                                }
                                            }else{
                                                $tc = "2";
                                            }
                                        }
                                        $this->load->helper("products_helper");
                                        $price = getProductPrice($urun->id);
                                        $price = $this->input->post("quantity") * $price;
                                        $getLang = getLangValue($urun->id, "table_products");
                                        if ($getLang) {
                                            $ozel = $this->getBasketInfoSpecial($urun);
                                            if ($ozel) {
                                                $this->setSessionTempBasket($urun, $this->input->post("quantity"), $price);
                                                echo json_encode(array("price" => floor($price*100)/100 . " " . getcur(), "name" => $getLang->name, "uyari" => $getLang->uyari, "tc" => $tc, "image" => $urun->image, "ozel_alanlar" => $ozel));
                                            } else {

                                                $this->setSessionTempBasket($urun, $this->input->post("quantity"), $price);
                                                echo json_encode(array("price" => floor($price*100)/100 . " " . getcur(), "name" => $getLang->name, "uyari" => $getLang->uyari, "tc" => $tc, "image" => $urun->image, "ozel_alanlar" => $ozel));
                                            }
                                        }


                                    } else {
                                        unset($_SESSION["basketTemp"]);
                                        echo json_encode(array("errs" => true));
                                    }
                                }
                            }
                        }
                    } else {

                        echo trim("2");
                        unset($_SESSION["basketTemp"]);
                    }
                } else {
                    addLog("Saldırı Uygulandı.", "getBasketProInfo FormControl", 3);
                }
            } else {
                addLog("Saldırı Uygulandı.", "getBasketProInfo POST", 3);
            }
        } catch (Exception $ex) {
            $urun = getTableSingle("table_products", array("status" => 1, "token" => $this->input->post("data", true)));
            if ($urun) {
                $urun = $urun->p_name;
            } else {
                $urun = "**Bulunamadı**";
            }
            addLog("Sepet POP UP Ajax Hatası", $urun . " adlı ürün sepet pop up açılırken beklenmedik bir hata meydana geldi.");
        }

    }

    //Özel alanlar çekilir
    private function getBasketInfoSpecial($urun)
    {
        try {
            if ($urun) {
                $ozel_alanlar = getTable("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_main" => 1));
                if ($ozel_alanlar) {
                    $str = "";
                    foreach ($ozel_alanlar as $item) {
                        $required = "";
                        $getLang = getLangValue($item->id, "table_products_special");
                        if ($item->type == 1) {

                            $str .= " <label for='special-" . md5($item->id) . "'>" . $getLang->name . "</label>
                                <input type='text' id='special-" . md5($item->id) . "' " . $required . " name='special-" . md5($item->id) . "' >";
                        } else {

                            $str .= " <label for='special-" . md5($item->id) . "'>" . $getLang->name . "</label>";
                            $parcala = explode(",", $getLang->secenek);
                            $str .= "<select style='margin-bottom:15px' " . $required . " id='special-" . md5($item->id) . "' name='special-" . md5($item->id) . "'><option value=''>" . langS(36, 2) . "</option>";
                            foreach ($parcala as $itemw) {
                                $str .= '<option value="' . $itemw . '">' . $itemw . '</option>';
                            }
                            $str .= "</select>";
                        }
                    }
                    return $str;
                } else {
                    return false;
                }
            }
        } catch (Exception $ex) {
            addLog("Sepet Özel Alan Ajax Hatası", $urun->p_name . " adlı ürün özel alanları çekilirken beklenmedik bir hata meydana geldi.");
        }

    }

    //geçici sepet session
    private function setSessionTempBasket($urun, $adet, $price)
    {
        try {
            if ($urun && $adet && $adet != 0 && $price) {

                unset($_SESSION["basketTemp"]);
                $sets = $this->session->set_userdata("basketTemp", array(
                    "token" => $urun->token,
                    "quantity" => $adet,
                    "price" => $price
                ));

            }
        } catch (Exception $ex) {
            addLog("Sepet Temp Session Hatası", $urun->p_name . " adlı ürün temp session oluşturulurken hata meydana geldi.");
        }
    }

    //sepet ekleme ve özel alan kontrol
    public function addBasket()
    {
        try {
            if ($_POST) {
                header('Content-Type: application/json');
                $token = token_control();
                //unset($_SESSION["basketReal"]);
                //exit;
                if ($token == "2") {
                    echo json_encode(array("errorr" => "login"));
                } else {
                    if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                        if ($_SESSION["basketTemp"]) {
                            $urun = getTableSingle("table_products", array("token" => $_SESSION["basketTemp"]["token"]));
                            if ($urun) {
                                if($urun->is_delete==0){
                                    $ozelAlanlar = getTableSingle("table_products_special", array("p_id" => $urun->id, "status" => 1, "is_main" => 1));
                                    $dataSpecial = array();
                                    if ($ozelAlanlar) {

                                        if ($ozelAlanlar->is_required == 1) {
                                            $req = 1;
                                            $langs = getLangValue($ozelAlanlar->id, "table_products_special");
                                            if ($langs) {
                                                $this->form_validation->set_rules("special-" . md5($ozelAlanlar->id), $langs->name, "required|trim");
                                            }
                                        }
                                        $r = 0;
                                        if ($req == 1) {
                                            $this->form_validation->set_message(array(
                                                "required" => "{field} " . str_replace("\r\n", "", langS(12, 2))));
                                            $array = "";
                                            $val = $this->form_validation->run();
                                            if ($val) {
                                                $r = 1;
                                            } else {
                                                $r = 2;
                                            }
                                        }
                                        $k = 0;
                                        if ($r == 1) {
                                            if ($_SESSION["basketReal"][$urun->token]) {

                                                if ($_SESSION["basketReal"][$urun->token][$this->input->post("special-" . md5($ozelAlanlar->id))]) {
                                                    $k = 1;
                                                } else {

                                                    $k = 2;
                                                    $dataSpecial = array(
                                                        "sid" => $ozelAlanlar->id,
                                                        "value" => $this->input->post("special-" . md5($ozelAlanlar->id)),
                                                        "quantity" => $_SESSION["basketTemp"]["quantity"]);
                                                }
                                            } else {

                                                $dataSpecial = array(
                                                    "sid" => $ozelAlanlar->id,
                                                    "value" => $this->input->post("special-" . md5($ozelAlanlar->id)),
                                                    "quantity" => $_SESSION["basketTemp"]["quantity"]);
                                            }
                                        } else {
                                            echo json_encode(array("errorr" => "validation", "message" => validation_errors()));
                                            die();
                                        }


                                        if ($_SESSION["basketReal"]) {
                                            if ($_SESSION["basketReal"][$urun->token]) {
                                                if ($k == 1) {

                                                    $adet = $_SESSION["basketReal"][$urun->token][$this->input->post("special-" . md5($ozelAlanlar->id))]["quantity"];
                                                    $_SESSION["basketReal"][$urun->token][$this->input->post("special-" . md5($ozelAlanlar->id))]["quantity"] = $adet + $_SESSION["basketTemp"]["quantity"];
                                                    $this->basket_total_price();
                                                } else {

                                                    $_SESSION["basketReal"][$urun->token][$this->input->post("special-" . md5($ozelAlanlar->id))] = $dataSpecial;
                                                    $this->basket_total_price();
                                                }
                                                //print_r($_SESSION["basketReal"]);
                                                echo json_encode(array("errorr" => "no","total" => $_SESSION["basketTotal"]["quantity"]));
                                            } else {
                                                $_SESSION["basketReal"][$urun->token][$this->input->post("special-" . md5($ozelAlanlar->id))] = $dataSpecial;
                                                $this->basket_total_price();
                                                echo json_encode(array("errorr" => "no","total" => $_SESSION["basketTotal"]["quantity"]));

                                            }
                                        } else {

                                            $_SESSION["basketReal"][md5($urun->id)][$this->input->post("special-" . md5($ozelAlanlar->id))] = $dataSpecial;
                                            $this->basket_total_price();
                                            //print_r($_SESSION["basketReal"]);
                                            echo json_encode(array("errorr" => "no","total" => $_SESSION["basketTotal"]["quantity"]));
                                        }
                                    } else {

                                        if ($_SESSION["basketReal"][md5($urun->id)]) {
                                            $adet = $_SESSION["basketReal"][md5($urun->id)][0]["quantity"];
                                            $_SESSION["basketReal"][md5($urun->id)][0]["quantity"] = $adet + $_SESSION["basketTemp"]["quantity"];
                                            $this->basket_total_price();
                                        } else {

                                            $_SESSION["basketReal"][md5($urun->id)][] = array("token" => sha1($urun->id),
                                                "quantity" => $_SESSION["basketTemp"]["quantity"],
                                                "special" => 0);
                                            $this->basket_total_price();
                                        }

                                        //print_r($_SESSION["basketReal"]);
                                        echo json_encode(array("errorr" => "no","total" => $_SESSION["basketTotal"]["quantity"]));
                                    }
                                }else{
                                    echo json_encode(array("errorr" => "Not Product"));
                                }



                            } else {
                                echo json_encode(array("errorr" => "Not Product"));
                            }
                        } else {
                            echo json_encode(array("errorr" => "Not Temp"));
                        }
                    } else {
                        addLog("Saldırı Uygulandı.", "getBasketProInfo FormControl", 3);
                    }
                }
                //unset($_SESSION["basketReal"]);

            } else {
                addLog("Saldırı Uygulandı.", "getBasketProInfo POST", 3);
            }
        } catch (Exception $ex) {
            addLog("Sepet Ürün Ekleme Hatası", "Ürün Sepete Eklenirken beklenmedik bir hata meydana geldi.");
        }
    }

    public function deleteProductsBasket()
    {
        try {
            if ($_POST) {
                if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                    header('Content-Type: application/json');
                    if ($this->input->post("data", true) && $this->input->post("quantity", true) && $this->input->post("quantity") != 0) {
                        $token = token_control();
                        if ($token == "2") {
                            unset($_SESSION["basketTemp"]);
                            echo json_encode(array("err" => true));
                        } else {
                            $urun = getTableSingle("table_products", array("status" => 1, "token" => $this->input->post("data", true)));
                            if ($urun) {
                                $tc = 0;
                                $category = getTableSingle("table_products_category", array("id" => $urun->category_id, "status" => 1));
                                if ($category) {
                                    if ($category->is_tc == 1) {
                                        $getUser = getActiveUsers();
                                        if ($getUser) {
                                            if ($getUser->tc_onay == 0) {
                                                $tc = 0;
                                            } else {
                                                $tc = 1;
                                            }
                                        }
                                    }
                                }


                                $this->load->helper("products_helper");
                                $price = getProductPrice($urun->id);
                                $price = $this->input->post("quantity") * $price;
                                $getLang = getLangValue($urun->id, "table_products");
                                if ($getLang) {
                                    $ozel = $this->getBasketInfoSpecial($urun);
                                    if ($ozel) {
                                        $this->setSessionTempBasket($urun, $this->input->post("quantity"), $price);
                                        $price=floor($price*100)/100;
                                        echo json_encode(array("price" => $price . " " . getcur(), "name" => $getLang->name, "uyari" => $getLang->uyari, "tc" => $tc, "image" => $urun->image, "ozel_alanlar" => $ozel));
                                    } else {
                                        $price=floor($price*100)/100;
                                        $this->setSessionTempBasket($urun, $this->input->post("quantity"), $price);
                                        echo json_encode(array("price" => $price . " " . getcur(), "name" => $getLang->name, "uyari" => $getLang->uyari, "tc" => $tc, "image" => $urun->image, "ozel_alanlar" => $ozel));
                                    }
                                }


                            } else {
                                unset($_SESSION["basketTemp"]);
                                echo json_encode(array("errs" => true));
                            }
                        }
                    } else {

                        echo trim("2");
                        unset($_SESSION["basketTemp"]);
                    }
                } else {
                    addLog("Saldırı Uygulandı.", "getBasketProInfo FormControl", 3);
                }
            } else {
                addLog("Saldırı Uygulandı.", "getBasketProInfo POST", 3);
            }
        } catch (Exception $ex) {
            $urun = getTableSingle("table_products", array("status" => 1, "token" => $this->input->post("data", true)));
            if ($urun) {
                $urun = $urun->p_name;
            } else {
                $urun = "**Bulunamadı**";
            }
            addLog("Sepet POP UP Ajax Hatası", $urun . " adlı ürün sepet pop up açılırken beklenmedik bir hata meydana geldi.");
        }
    }


    public function minus_basket(){
        if ($_POST) {
            header('Content-Type: application/json');
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                if($this->input->post("data")){
                    $this->load->model("m_tr_model");
                    if($this->input->post("spe")=="-"){
                        $kontrol=$this->m_tr_model->getTableSingle("table_products",array("token" => $this->input->post("data")));
                        if($kontrol){
                            unset($_SESSION["basketReal"][$kontrol->token]);
                            if(count($_SESSION["basketReal"])==0){
                                unset($_SESSION["basketReal"]);
                            }
                            $this->basket_total_price();
                            echo  json_encode(array("total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"]));
                        }else{
                            $temizle = str_replace("T", "", str_replace("SH", "", str_replace("-", "", $this->input->post("data"))));
                            $kontrol=$this->m_tr_model->getTableSingle("table_adverts",array("id" => $temizle));
                            if($kontrol){
                                unset($_SESSION["basketReal"]["SH-".$kontrol->id."-T"]);
                                if(count($_SESSION["basketReal"])==0){
                                    unset($_SESSION["basketReal"]);
                                }
                                $this->basket_total_price();
                                echo  json_encode(array("total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"]));
                            }
                        }
                    }else{
                        $kontrol=$this->m_tr_model->getTableSingle("table_products",array("token" => $this->input->post("nat")));
                        if($kontrol){
                            unset($_SESSION["basketReal"][$kontrol->token][$this->input->post("spe")]);
                            if(count($_SESSION["basketReal"][$kontrol->token])==0){
                                unset($_SESSION["basketReal"][$kontrol->token]);
                            }
                            $this->basket_total_price();
                            echo  json_encode(array("total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"]));
                        }
                    }
                }else{

                }
            }else{
                addLog("Saldırı Uygulandı.", "minus_basket POST", 3);
            }
        }else{
            addLog("Saldırı Uygulandı.", "minus_basket POST", 3);
        }
    }

    public function add_basket_ads()
    {
        if ($_POST) {
            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                header('Content-Type: application/json');
                if ($this->input->post("data")) {
                    $this->load->model("m_tr_model");
                    $temizle = str_replace("T", "", str_replace("SH", "", str_replace("-", "", $this->input->post("data"))));
                    $kontrol = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $temizle));
                    if ($kontrol) {
                        $veri=getActiveUsers();
                        if($veri){
                            $yarcek=getTableSingle("table_onay_kisit",array("id" => 1));
                            $par=explode("-",$yarcek->ilan_siparis);
                            if($par[0]==1){
                                if($veri->tel_onay==1){
                                    if (!$_SESSION["basketReal"]["SH-" . $kontrol->id . "-T"]) {
                                        $_SESSION["basketReal"]["SH-" . $kontrol->id . "-T"][] = array("token" => "SH-" . $kontrol->id . "-T",
                                            "quantity" => 1,
                                            "special" => 0);
                                        $this->basket_total_price();
                                        echo json_encode(array("errs" => 1, "message" => langS(37, 2),"adet" => $_SESSION["basketTotal"]["quantity"]));
                                    } else {
                                        echo json_encode(array("errs" => 2, "message" => langS(185, 2)));
                                    }
                                }else{
                                    echo json_encode(array("errs" => 2, "message" => langS(511, 2)));
                                }
                            }else{
                                if (!$_SESSION["basketReal"]["SH-" . $kontrol->id . "-T"]) {
                                    $_SESSION["basketReal"]["SH-" . $kontrol->id . "-T"][] = array("token" => "SH-" . $kontrol->id . "-T",
                                        "quantity" => 1,
                                        "special" => 0);
                                    $this->basket_total_price();
                                    echo json_encode(array("errs" => 1, "message" => langS(37, 2),"adet" => $_SESSION["basketTotal"]["quantity"]));
                                } else {
                                    echo json_encode(array("errs" => 2, "message" => langS(185, 2)));
                                }
                            }

                        }else{
                            echo json_encode(array("errs" => 4, "message" => ""));
                        }
                    } else {
                        echo json_encode(array("errs" => 3, "message" => langS(187, 2)));
                    }
                } else {
                    addLog("Saldırı Uygulandı.", "add_basket_ads data", 3);
                }
            } else {
                addLog("Saldırı Uygulandı.", "add_basket_ads POST", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "add_basket_ads POST", 3);
        }
    }

    public function basket_update()
    {
        if ($_POST) {

            if ($this->kontrolSession == $this->session->userdata("userUniqFormRegisterControl")) {
                header('Content-Type: application/json');
                $this->load->model("m_tr_model");
                try {
                    $user=getActiveUsers();
                    if ($this->input->post("data") && $this->input->post("types") && $this->input->post("quantity")) {
                        if ($this->input->post("types") == "-") {
                            //Ürünler ve oyunlar için
                            $kontrol = $this->m_tr_model->getTableSingle("table_products", array("token" => $this->input->post("data")));
                            if ($kontrol) {
                                if ($kontrol->turkpin_id != 0 && $kontrol->turkpin_urun_id != 0) {
                                    $toplamAdet4 = 0;
                                    $specialControl = $this->m_tr_model->getTableSingle("table_products_special", array("status" => 1, "p_id" => $kontrol->id, "is_main" => 1, "is_required" => 1));
                                    if ($specialControl) {
                                        foreach ($_SESSION["basketReal"][$kontrol->token] as $keys => $itemKey) {
                                            if ($_SESSION["basketReal"][$kontrol->token][$keys]) {
                                                $toplamAdet4 = $toplamAdet4 + $_SESSION["basketReal"][$kontrol->token][$keys]["quantity"];
                                            }
                                        }
                                    } else {
                                        $toplamAdet4 = $toplamAdet4 + $_SESSION["basketReal"][$kontrol->token][0]["quantity"];
                                    }

                                    if ($kontrol->turkpin_stok >= $this->input->post("quantity")) {
                                        if ($toplamAdet4 + $this->input->post("quantity") <= $kontrol->turkpin_stok) {
                                            if ($_SESSION["basketReal"][$kontrol->token][0]["quantity"]) {
                                                $_SESSION["basketReal"][$kontrol->token][0]["quantity"] = $this->input->post("quantity");
                                                $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                if ($kontrol->is_discount != 0 && $kontrol->discount != 0) {
                                                    if($user){
                                                        //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                        if(intval($user->balance) > intval($kontrol->price_sell_discount * $this->input->post("quantity"))){
                                                            $par = $kontrol->price_sell_discount * $this->input->post("quantity");
                                                            $par2 = $kontrol->price_sell * $this->input->post("quantity");
                                                            $this->basket_total_price();
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                        }else{
                                                            $par = $kontrol->price_sell_discount * $this->input->post("quantity");
                                                            $par2 = $kontrol->price_sell * $this->input->post("quantity");
                                                            $this->basket_total_price();
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));                                                        }
                                                    }else{
                                                        $par = $kontrol->price_sell_discount * $this->input->post("quantity");
                                                        $par2 = $kontrol->price_sell * $this->input->post("quantity");
                                                        $this->basket_total_price();
                                                        echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                    }

                                                } else {
                                                    if($user){
                                                        //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                        if(intval($user->balance) > intval($kontrol->price_sell * $this->input->post("quantity"))){
                                                            $this->basket_total_price();
                                                            $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            $par=floor($par*100)/100;
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => $par));
                                                        }else{
                                                            $this->basket_total_price();
                                                            $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            $par=floor($par*100)/100;
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => $par));
                                                        }
                                                    }else{
                                                        $this->basket_total_price();
                                                        $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        $par=floor($par*100)/100;
                                                        echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" =>$par));
                                                    }

                                                }
                                            }
                                        } else {
                                            echo json_encode(array("err" => 4, "message" => langS(189, 2)));
                                        }
                                    } else {
                                        echo json_encode(array("err" => 4, "stok" => $kontrol->turkpin_stok, "message" => langS(189, 2)));
                                    }

                                } else {
                                    if ($this->input->post("dat")) {
                                        if ($this->input->post("dat") == "az") {
                                            if ($_SESSION["basketReal"][$kontrol->token][0]["quantity"]) {
                                                $_SESSION["basketReal"][$kontrol->token][0]["quantity"] = $this->input->post("quantity");
                                            }
                                            if ($kontrol->is_discount != 0 && $kontrol->discount != 0) {
                                                if($user){
                                                    //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                    if(intval($user->balance) > intval($kontrol->price_sell_discount * $this->input->post("quantity"))){
                                                        $par = $kontrol->price_sell_discount * $this->input->post("quantity");
                                                        $par2 = $kontrol->price_sell * $this->input->post("quantity");
                                                        $par2=floor($par2*100)/100;
                                                        $par=floor($par*100)/100;
                                                        $this->basket_total_price();
                                                        echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => $par2, "fiyat" => $par));
                                                    }else{
                                                        $par = $kontrol->price_sell_discount * $this->input->post("quantity");
                                                        $par2 = $kontrol->price_sell * $this->input->post("quantity");
                                                        $this->basket_total_price();
                                                        $par2=floor($par2*100)/100;
                                                        $par=floor($par*100)/100;
                                                        echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => $par2, "fiyat" => $par));
                                                    }
                                                }else{
                                                    $par = $kontrol->price_sell_discount * $this->input->post("quantity");
                                                    $par2 = $kontrol->price_sell * $this->input->post("quantity");
                                                    $this->basket_total_price();
                                                    $par2=floor($par2*100)/100;
                                                    $par=floor($par*100)/100;
                                                    echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => $par2, "fiyat" => $par));
                                                }

                                            } else {
                                                if($user){
                                                    //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                    if(intval($user->balance) > intval($kontrol->price_sell * $this->input->post("quantity"))){
                                                        $this->basket_total_price();
                                                        $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        $par=floor($par*100)/100;
                                                        echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" =>$par));
                                                    }else{
                                                        $this->basket_total_price();
                                                        $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        $par=floor($par*100)/100;
                                                        echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => $par));
                                                    }
                                                }else{
                                                    $this->basket_total_price();
                                                    $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                    $par=floor($par*100)/100;
                                                    echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => $par));
                                                }
                                            }
                                        }
                                    } else {
                                        if($kontrol->is_stock==1){

                                            if ($_SESSION["basketReal"][$kontrol->token][0]["quantity"]) {
                                                $_SESSION["basketReal"][$kontrol->token][0]["quantity"] = $this->input->post("quantity");
                                                if ($kontrol->is_discount != 0 && $kontrol->discount != 0) {
                                                    if($user){
                                                        //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                        if(intval($user->balance) > intval($kontrol->price_sell_discount * $this->input->post("quantity"))){
                                                            $par = $kontrol->price_sell_discount * $this->input->post("quantity");
                                                            $par2 = $kontrol->price_sell * $this->input->post("quantity");
                                                            $this->basket_total_price();
                                                            $par2=floor($par2*100)/100;
                                                            $par=floor($par*100)/100;
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => $par2, "fiyat" => $par));
                                                        }else{
                                                            $par = $kontrol->price_sell_discount * $this->input->post("quantity");
                                                            $par2 = $kontrol->price_sell * $this->input->post("quantity");
                                                            $this->basket_total_price();
                                                            $par2=floor($par2*100)/100;
                                                            $par=floor($par*100)/100;
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => $par2, "fiyat" =>$par));                                                        }
                                                    }else{
                                                        $par = $kontrol->price_sell_discount * $this->input->post("quantity");
                                                        $par2 = $kontrol->price_sell * $this->input->post("quantity");
                                                        $this->basket_total_price();
                                                        $par2=floor($par2*100)/100;
                                                        $par=floor($par*100)/100;
                                                        echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" =>$par2, "fiyat" => $par));
                                                    }

                                                } else {
                                                    if($user){
                                                        //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                        if(intval($user->balance) > intval($kontrol->price_sell * $this->input->post("quantity"))){
                                                            $this->basket_total_price();
                                                            $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            $par=floor($par*100)/100;
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => $par));
                                                        }else{
                                                            $this->basket_total_price();
                                                            $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            $par=floor($par*100)/100;
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => $par));
                                                        }
                                                    }else{
                                                        $this->basket_total_price();
                                                        $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        $par=floor($par*100)/100;
                                                        echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" =>$par));
                                                    }


                                                }
                                            }
                                        }else{
                                            $toplamAdet3 = $this->basket_count_item($kontrol);
                                            if ($kontrol->stok >= ($toplamAdet3 + 1)) {
                                                if ($_SESSION["basketReal"][$kontrol->token][0]["quantity"]) {
                                                    $_SESSION["basketReal"][$kontrol->token][0]["quantity"] = $this->input->post("quantity");
                                                    if ($kontrol->is_discount != 0 && $kontrol->discount != 0) {
                                                        if($user){
                                                            //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                            if(intval($user->balance) > intval($kontrol->price_sell_discount * $this->input->post("quantity"))){
                                                                $par = $kontrol->price_sell_discount * $this->input->post("quantity");
                                                                $par2 = $kontrol->price_sell * $this->input->post("quantity");
                                                                $this->basket_total_price();
                                                                $par2=floor($par2*100)/100;
                                                                $par=floor($par*100)/100;
                                                                echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" =>$par2, "fiyat" => $par));
                                                            }else{
                                                                $par = $kontrol->price_sell_discount * $this->input->post("quantity");
                                                                $par2 = $kontrol->price_sell * $this->input->post("quantity");
                                                                $this->basket_total_price();
                                                                $par2=floor($par2*100)/100;
                                                                $par=floor($par*100)/100;
                                                                echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => $par2, "fiyat" => $par));                                                        }
                                                        }else{
                                                            $par = $kontrol->price_sell_discount * $this->input->post("quantity");
                                                            $par2 = $kontrol->price_sell * $this->input->post("quantity");
                                                            $this->basket_total_price();
                                                            $par2=floor($par2*100)/100;
                                                            $par=floor($par*100)/100;
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => $par2, "fiyat" => $par));
                                                        }
                                                    } else {
                                                        if($user){
                                                            //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                            if(intval($user->balance) > intval($kontrol->price_sell * $this->input->post("quantity"))){
                                                                $this->basket_total_price();
                                                                $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                                $par=floor($par*100)/100;
                                                                echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => $par));
                                                            }else{
                                                                $this->basket_total_price();
                                                                $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                                $par=floor($par*100)/100;
                                                                echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => $par));
                                                            }
                                                        }else{
                                                            $this->basket_total_price();
                                                            $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            $par=floor($par*100)/100;
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" =>$par));
                                                        }


                                                    }
                                                }

                                            } else {
                                                echo json_encode(array("err" => 4, "stok" => $kontrol->stok, "message" => langS(189, 2)));
                                            }
                                        }

                                    }
                                }

                            } else {
                                //ilanlar için
                                $temizle = str_replace("T", "", str_replace("SH", "", str_replace("-", "", $this->input->post("data"))));
                                $kontrol = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $temizle));
                                if ($kontrol) {
                                    if ($kontrol->type == 0) {
                                        $par = $kontrol->price;
                                        echo json_encode(array("err" => 4, "fiyat" => floor($par*100)/100, "message" => langS(189, 2)));
                                    } else {
                                        if ($kontrol->stocks != "") {
                                            $cek = $this->m_tr_model->query("SELECT LENGTH(stocks) - LENGTH(REPLACE(stocks, '\n', '')) as Count
                                            FROM table_adverts where id=" . $kontrol->id . "
                                            ORDER BY Count DESC");
                                            if ($cek[0]->Count + 1 >= $this->input->post("quantity")) {
                                                $par = $kontrol->price * floatval($this->input->post("quantity"));
                                                if ($_SESSION["basketReal"]["SH-".$kontrol->id."-T"][0]["quantity"]) {
                                                    $_SESSION["basketReal"]["SH-" . $kontrol->id . "-T"][0]["quantity"] = $this->input->post("quantity");
                                                }
                                                $this->basket_total_price();

                                                echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => floor($par*100)/100));
                                            } else {
                                                echo json_encode(array("err" => 4, "message" => langS(189, 2)));
                                            }
                                        } else {
                                            echo json_encode(array("err" => 4, "message" => langS(189, 2)));
                                        }
                                    }

                                }
                            }
                        }
                        else if ($this->input->post("types") == "*") {
                            $kontrol = $this->m_tr_model->getTableSingle("table_products", array("token" => $this->input->post("data")));
                            if ($kontrol) {

                                $toplamAdet3 = 0;
                                $toplamAdet3 = $this->basket_count_item($kontrol);
                                if($kontrol->is_api==1){
                                    if ($kontrol->turkpin_id != 0 && $kontrol->turkpin_urun_id) {
                                        if ($kontrol->turkpin_stok >= $this->input->post("quantity")) {
                                            if ($this->input->post("quantity") + $toplamAdet3 <= $kontrol->turkpin_stok) {
                                                if ($kontrol->is_discount == 1 && $kontrol->discount != 0) {

                                                    if($user){
                                                        //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                        if(intval($user->balance) > intval($kontrol->price_sell_discount * $this->input->post("quantity"))){
                                                            $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                            $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            echo json_encode(array("err" => 1, "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                        }else{
                                                            $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                            $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            echo json_encode(array("err" => 1, "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                        }
                                                    }else{
                                                        $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                        $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        echo json_encode(array("err" => 1, "fiyatIndirimli" => floor($par2*100)/100, "fiyat" =>floor($par*100)/100));
                                                    }

                                                } else {
                                                    if($user){
                                                        //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                        if(intval($user->balance) > intval($kontrol->price_sell * $this->input->post("quantity"))){
                                                            $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            echo json_encode(array("err" => 1, "fiyat" =>floor($par2*100)/100));
                                                        }else{
                                                            $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            echo json_encode(array("err" => 1, "fiyat" => floor($par2*100)/100));
                                                        }
                                                    }else{
                                                        $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        echo json_encode(array("err" => 1, "fiyat" => floor($par2*100)/100));
                                                    }

                                                }
                                            } else {
                                                echo json_encode(array("err" => 4, "message" => langS(189, 2)));
                                            }

                                        } else {
                                            echo json_encode(array("err" => 4, "message" => langS(189, 2)));
                                        }
                                    }
                                }else{
                                    $toplamAdet3 = $this->basket_count_item($kontrol);
                                    if($kontrol->is_stock==1){
                                        if ($kontrol->is_discount == 1 && $kontrol->discount != 0) {
                                            if($user){
                                                //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                if(intval($user->balance) > intval($kontrol->price_sell_discount * $this->input->post("quantity"))){
                                                    $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                    $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                    echo json_encode(array("err" => 1, "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                }else{
                                                    $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                    $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                    echo json_encode(array("err" => 1, "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                }
                                            }else{
                                                $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                echo json_encode(array("err" => 1, "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                            }

                                        } else {

                                            if($user){
                                                //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                if(intval($user->balance) > intval($kontrol->price_sell * $this->input->post("quantity"))){
                                                    $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                    echo json_encode(array("err" => 1, "fiyat" => floor($par2*100)/100));
                                                }else{
                                                    $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                    echo json_encode(array("err" => 1, "fiyat" => floor($par2*100)/100));
                                                }
                                            }else{
                                                $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                echo json_encode(array("err" => 1, "fiyat" => floor($par2*100)/100));
                                            }

                                        }

                                    }else{
                                        if ($kontrol->stok >= ($toplamAdet3 + $this->input->post("quantity"))) {
                                            if ($kontrol->is_discount == 1 && $kontrol->discount != 0) {
                                                if($user){
                                                    //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                    if(intval($user->balance) > intval($kontrol->price_sell_discount * $this->input->post("quantity"))){
                                                        $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                        $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        echo json_encode(array("err" => 1, "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                    }else{
                                                        $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                        $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        echo json_encode(array("err" => 1, "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                    }
                                                }else{
                                                    $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                    $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                    echo json_encode(array("err" => 1, "fiyatIndirimli" =>floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                }

                                            } else {

                                                if($user){
                                                    //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                    if(intval($user->balance) > intval($kontrol->price_sell * $this->input->post("quantity"))){
                                                        $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        echo json_encode(array("err" => 1, "fiyat" => floor($par2*100)/100));
                                                    }else{
                                                        $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        echo json_encode(array("err" => 1, "fiyat" => floor($par2*100)/100));
                                                    }
                                                }else{
                                                    $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                    echo json_encode(array("err" => 1, "fiyat" => floor($par2*100)/100));
                                                }

                                            }
                                        } else {
                                            echo json_encode(array("err" => 4, "stok" => $kontrol->stok - $toplamAdet3, "message" => langS(189, 2)));
                                        }
                                    }
                                }



                            }

                            //kategori stok kontrol

                        } else {
                            //özel alan olarak eklenen ürünler
                            $kontrol = $this->m_tr_model->getTableSingle("table_products", array("token" => $this->input->post("nat")));
                            if ($kontrol) {
                                if($kontrol->is_api==1){
                                    if ($kontrol->turkpin_id != 0 && $kontrol->turkpin_urun_id != 0) {
                                        $toplamAdet = 0;
                                        $toplamAdet = $this->basket_count_item($kontrol);
                                        if ($this->input->post("dat") == "az") {
                                            $toplamAdet = 0;
                                            if ($_SESSION["basketReal"][$kontrol->token][$this->input->post("types")]["quantity"]) {
                                                $_SESSION["basketReal"][$kontrol->token][$this->input->post("types")]["quantity"] = $this->input->post("quantity");
                                                $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                if ($kontrol->is_discount != 0 && $kontrol->discount != 0) {
                                                    if($user){
                                                        //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                        if(intval($user->balance) > intval($kontrol->price_sell_discount * $this->input->post("quantity"))){
                                                            $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                            $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            $this->basket_total_price();
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                        }else{
                                                            $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                            $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            $this->basket_total_price();
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                        }
                                                    }else{
                                                        $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                        $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        $this->basket_total_price();
                                                        echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                    }

                                                } else {
                                                    if($user){
                                                        //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                        if(intval($user->balance) > intval($kontrol->price_sell * $this->input->post("quantity"))){
                                                            $this->basket_total_price();
                                                            $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => floor($par*100)/100));
                                                        }else{
                                                            $this->basket_total_price();
                                                            $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => floor($par*100)/100));
                                                        }
                                                    }else{
                                                        $this->basket_total_price();
                                                        $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => floor($par*100)/100));
                                                    }

                                                }
                                            }
                                        } else {
                                            if ($kontrol->turkpin_stok >= $this->input->post("quantity")) {
                                                if (($toplamAdet + 1) <= $kontrol->turkpin_stok) {
                                                    if ($_SESSION["basketReal"][$kontrol->token][$this->input->post("types")]["quantity"]) {
                                                        $_SESSION["basketReal"][$kontrol->token][$this->input->post("types")]["quantity"] = $this->input->post("quantity");
                                                        $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                        if ($kontrol->is_discount != 0 && $kontrol->discount != 0) {
                                                            if($user){
                                                                //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                                if(intval($user->balance) > intval($kontrol->price_sell_discount * $this->input->post("quantity"))){
                                                                    $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                                    $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                                    $this->basket_total_price();
                                                                    echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" =>floor($par2*100)/100, "fiyat" => floor($par2*100)/100));
                                                                }else{
                                                                    $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                                    $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                                    $this->basket_total_price();
                                                                    echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" =>floor($par2*100)/100, "fiyat" =>floor($par*100)/100));                                                            }
                                                            }else{
                                                                $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                                $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                                $this->basket_total_price();
                                                                echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" =>floor($par2*100)/100, "fiyat" =>floor($par*100)/100));
                                                            }


                                                        } else {
                                                            if($user){
                                                                //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                                if(intval($user->balance) > intval($kontrol->price_sell * $this->input->post("quantity"))){
                                                                    $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                                    $this->basket_total_price();
                                                                    echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => floor($par*100)/100));
                                                                }else{
                                                                    $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                                    $this->basket_total_price();
                                                                    echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => floor($par*100)/100));                                                            }
                                                            }else{
                                                                $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                                $this->basket_total_price();
                                                                echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => floor($par*100)/100));
                                                            }


                                                        }
                                                    }
                                                } else {
                                                    echo json_encode(array("err" => 4, "message" => langS(189, 2)));
                                                }
                                            } else {
                                                echo json_encode(array("err" => 4, "message" => langS(189, 2)));
                                            }
                                        }

                                    }
                                }else{
                                    $toplamAdet2 = 0;
                                    foreach ($_SESSION["basketReal"][$kontrol->token] as $keys => $itemKey) {
                                        $toplamAdet2 = $toplamAdet2 + $_SESSION["basketReal"][$kontrol->token][$keys]["quantity"];
                                    }
                                    if ($this->input->post("dat") == "az") {
                                        if ($_SESSION["basketReal"][$kontrol->token][$this->input->post("types")]["quantity"]) {
                                            $_SESSION["basketReal"][$kontrol->token][$this->input->post("types")]["quantity"] = $this->input->post("quantity");
                                            $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                            if ($kontrol->is_discount != 0 && $kontrol->discount != 0) {
                                                if($user){
                                                    //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                    if(intval($user->balance) > intval($kontrol->price_sell_discount * $this->input->post("quantity"))){
                                                        $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                        $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        $this->basket_total_price();
                                                        echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                    }else{
                                                        $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                        $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        $this->basket_total_price();
                                                        echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));                                                    }
                                                }else{
                                                    $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                    $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                    $this->basket_total_price();
                                                    echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                }

                                            } else {
                                                if($user){
                                                    //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                    if(intval($user->balance) > intval($kontrol->price_sell * $this->input->post("quantity"))){
                                                        $this->basket_total_price();
                                                        $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => floor($par*100)/100));
                                                    }else{
                                                        $this->basket_total_price();
                                                        $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => floor($par*100)/100));
                                                    }
                                                }else{
                                                    $this->basket_total_price();
                                                    $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                    echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => floor($par*100)/100));
                                                }


                                            }
                                        }
                                    } else {
                                        if($kontrol->is_stock==1){
                                            if ($_SESSION["basketReal"][$kontrol->token][$this->input->post("types")]["quantity"]) {
                                                $_SESSION["basketReal"][$kontrol->token][$this->input->post("types")]["quantity"] = $this->input->post("quantity");
                                                $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                if ($kontrol->is_discount != 0 && $kontrol->discount != 0) {
                                                    if($user){
                                                        //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                        if(intval($user->balance) > intval($kontrol->price_sell_discount * $this->input->post("quantity"))){
                                                            $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                            $this->basket_total_price();
                                                            $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                        }else{
                                                            $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                            $this->basket_total_price();
                                                            $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                        }
                                                    }else{
                                                        $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                        $this->basket_total_price();
                                                        $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                    }

                                                } else {

                                                    if($user){
                                                        //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                        if(intval($user->balance) > intval($kontrol->price_sell * $this->input->post("quantity"))){
                                                            $this->basket_total_price();
                                                            $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => floor($par*100)/100));
                                                        }else{
                                                            $this->basket_total_price();
                                                            $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => floor($par*100)/100));
                                                        }
                                                    }else{
                                                        $this->basket_total_price();
                                                        $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                        echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => floor($par*100)/100));
                                                    }

                                                }
                                            }
                                        }else{
                                            if ($kontrol->stok >= ($toplamAdet2 + 1)) {
                                                if ($_SESSION["basketReal"][$kontrol->token][$this->input->post("types")]["quantity"]) {
                                                    $_SESSION["basketReal"][$kontrol->token][$this->input->post("types")]["quantity"] = $this->input->post("quantity");
                                                    $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                    if ($kontrol->is_discount != 0 && $kontrol->discount != 0) {
                                                        if($user){
                                                            //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                            if(intval($user->balance) > intval($kontrol->price_sell_discount * $this->input->post("quantity"))){
                                                                $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                                $this->basket_total_price();
                                                                $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                                echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                            }else{
                                                                $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                                $this->basket_total_price();
                                                                $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                                echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                            }
                                                        }else{
                                                            $par = $kontrol->price_sell_discount * floatval($this->input->post("quantity"));
                                                            $this->basket_total_price();
                                                            $par2 = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyatIndirimli" => floor($par2*100)/100, "fiyat" => floor($par*100)/100));
                                                        }

                                                    } else {

                                                        if($user){
                                                            //echo $kontrol->price_sell_discount * $this->input->post("quantity");
                                                            if(intval($user->balance) > intval($kontrol->price_sell * $this->input->post("quantity"))){
                                                                $this->basket_total_price();
                                                                $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                                echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => floor($par*100)/100));
                                                            }else{
                                                                $this->basket_total_price();
                                                                $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                                echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => floor($par*100)/100));
                                                            }
                                                        }else{
                                                            $this->basket_total_price();
                                                            $par = $kontrol->price_sell * floatval($this->input->post("quantity"));
                                                            echo json_encode(array("err" => 1,"total" => $_SESSION["basketTotal"]["total"],"adet" => $_SESSION["basketTotal"]["quantity"], "fiyat" => floor($par*100)/100));
                                                        }

                                                    }
                                                }
                                            } else {
                                                echo json_encode(array("err" => 4, "message" => langS(189, 2)));
                                            }
                                        }

                                    }
                                }



                            }
                        }
                    } else {
                        //addLog("Saldırı Uygulandı.", "basket_update data", 3);
                    }
                } catch (Exception $ex) {

                }
            } else {
                addLog("Saldırı Uygulandı.", "basket_update POST", 3);
            }
        } else {
            addLog("Saldırı Uygulandı.", "basket_update POST", 3);
        }
    }

    private function basket_count_item($kontrol)
    {
        $this->load->model("m_tr_model");
        $specialControl = $this->m_tr_model->getTableSingle("table_products_special", array("status" => 1, "p_id" => $kontrol->id, "is_main" => 1, "is_required" => 1));
        $toplamAdet3 = 0;
        if ($specialControl) {
            foreach ($_SESSION["basketReal"][$kontrol->token] as $keys => $itemKey) {
                if ($_SESSION["basketReal"][$kontrol->token][$keys]) {
                    $toplamAdet3 = $toplamAdet3 + $_SESSION["basketReal"][$kontrol->token][$keys]["quantity"];
                }
            }
        } else {
            $toplamAdet3 = $_SESSION["basketReal"][$kontrol->token][0]["quantity"];
        }
        return $toplamAdet3;
    }

    private function basket_total_price(){
        if($_SESSION["basketReal"]){
            $toplamAdet=0;
            $toplamFiyat=0;
            $toplamIndirimli=0;
            if(count($_SESSION["basketReal"])>0){
                foreach ($_SESSION["basketReal"]  as $keys => $item) {
                    if($item[0]){
                        $cek=getTableSingle("table_products",array("token" => $keys,"status" => 1));
                        if($cek){
                            if($cek->is_discount==1 && $cek->discount!=0){
                                $toplamFiyat=$toplamFiyat + ($cek->price_sell_discount * $item[0]["quantity"]);
                                $toplamIndirimli= $toplamIndirimli + ($cek->price_sell * $item[0]["quantity"]);
                                $toplamAdet=$toplamAdet+ $item[0]["quantity"];
                            }else{
                                $toplamFiyat=$toplamFiyat + ($cek->price_sell * $item[0]["quantity"]);
                                $toplamAdet=$toplamAdet+ $item[0]["quantity"];
                            }
                        }else{
                            $temizle = str_replace("T", "", str_replace("SH", "", str_replace("-", "", $keys)));
                            $kontrol = $this->m_tr_model->getTableSingle("table_adverts", array("id" => $temizle));
                            if($kontrol){
                                if($kontrol->stocks!=""){
                                    $toplamAdet=$toplamAdet+$_SESSION["basketReal"][$keys][0]["quantity"];
                                    $toplamFiyat=$toplamFiyat + ($kontrol->price *  $_SESSION["basketReal"][$keys][0]["quantity"]);
                                }else{
                                    $toplamAdet=$toplamAdet+1;
                                    $toplamFiyat=$toplamFiyat + ($kontrol->price);
                                }
                            }
                        }
                    }else{
                        if($_SESSION["basketReal"][$keys]){
                            $cek=getTableSingle("table_products",array("token" => $keys,"status" => 1));
                            if($cek){
                                foreach ($_SESSION["basketReal"][$keys] as $key => $item) {
                                    if($cek->is_discount==1 && $cek->discount!=0){
                                        $toplamFiyat=$toplamFiyat + ($cek->price_sell_discount * $item["quantity"]);
                                        $toplamIndirimli= $toplamIndirimli + ($cek->price_sell * $item["quantity"]);
                                        $toplamAdet=$toplamAdet+ $item["quantity"];
                                    }else{
                                        $toplamFiyat=$toplamFiyat + ($cek->price_sell * $item["quantity"]);
                                        $toplamAdet=$toplamAdet+ $item["quantity"];
                                    }
                                }
                            }
                        }
                    }
                }
                $_SESSION["basketTotal"]=array("total" => floor($toplamFiyat*100)/100,"quantity" => $toplamAdet,"indirimliToplam" => floor($toplamIndirimli*100)/100);
            }else{
                $_SESSION["basketTotal"]=array("total" => 0,"quantity" => 0,"indirimliToplam" => 0);
            }

        }else{
            $_SESSION["basketTotal"]=array("total" => 0,"quantity" => 0,"indirimliToplam" => 0);
        }
    }

    public function get_basket_total()
    {
        $this->basket_total_price();
        exit;
        $order_id = date("YmdHis");
        $HashedPassword = base64_encode(sha1("134679", "ISO-8859-9"));
        $veri = 100;
        $HashData = base64_encode(sha1("3422"  . $order_id . $veri."https://webpsoft.com/itemilani/sepet-totals" . "https://webpsoft.com/itemilani/sepet-totalss" . "webapi" . $HashedPassword, "ISO-8859-9"));
        $xml = '';
        $xml .= '<form id="payform" action="https://boa.vakifkatilim.com.tr/VirtualPOS.Gateway/CommonPaymentPage/CommonPaymentPage" method="post">
 <div>
 <table style="">
 <tr>
 <td style="width:200px">webapi</td>
 </tr>
 <tr>
 <td style="width:200px">' . $HashedPassword . '</td>
 </tr>
 <tr>
 <td style="width:200px">3422</td>
 </tr>
 <tr>
     <td style="width:200px">' . $order_id . '</td>
 </tr>
 <tr>
 <td style="width:200px">100</td>
 </tr>
 <tr>
 <td style="width:200px">0949</td>
 </tr>
 <tr>
 <td style="width:200px">https://webpsoft.com/itemilani/sepet-totals</td>
 </tr>
 <tr>
 <td style="width:200px">https://webpsoft.com/itemilani/sepet-totalss</td>
 </tr>
 <tr>
 <td style="width:200px">1</td>
 </tr>  
 <tr>
 <td style="width:200px">' . $HashData . '</td>
 </tr>
 </table>   
 <div>
 <input  type="submit" value="Submit"/>
 </div>
 </div>
</form>
<script> document.getElementById("payform").submit(); </script>';
        echo $xml;
        /* $ch = curl_init("https://boa.vakifkatilim.com.tr/VirtualPOS.Gateway/Home/ThreeDModelPayGate");
                curl_setopt($ch, CURLOPT_MUTE, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($ch);
                curl_close($ch);
                echo $output;
            }*/
    }

    public function get_basket_totalss(){
    }
}


