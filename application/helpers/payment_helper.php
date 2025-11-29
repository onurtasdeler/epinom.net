<?php

use Shopier\Exceptions\NotRendererClassException;
use Shopier\Exceptions\RendererClassNotFoundException;
use Shopier\Exceptions\RequiredParameterException;
use Shopier\Models\Address;
use Shopier\Models\Buyer;
use Shopier\Renderers\AutoSubmitFormRenderer;
use Shopier\Renderers\ButtonRenderer;
use Shopier\Enums\ProductType;
use Shopier\Shopier;

function getPaymentMethod($data = array()){
    $CI = &get_instance();
    switch($CI->db->where('id=1')->get('config')->row()->payment_method){
        case 1:
            return iyzicoPaymentForm($data['price'], $data['user']);
        break;
        case 2:
            return paytrPaymentForm($data['price'], $data['user']);
        break;
        case 3:
            return shopierPaymentForm($data['price'], $data['user']);
        break;
        case 4:
            return gpayPaymentForm($data['price'], $data['user']);
        break;
        case 5:
            return payreksPaymentForm($data['price'], $data['user']);
        break;
        case 6:
            return payreksPaymentForm($data['price'], $data['user'],2);
        break;
        default:
            return FALSE;
        break;
    }
}

function shopierPaymentForm($price, $user){

    $CI = &get_instance();
    $paymentMethod = $CI->db->where([
        'id' => 3
    ])->get('payment_methods')->row();
    if(!isset($paymentMethod->id)){
        return FALSE;
    }

    $paymentMethodData = json_decode($paymentMethod->api_json);
    $shopier = new Shopier($paymentMethodData->api_key, $paymentMethodData->api_secret);
    
    $user_exploded_full_name = explode(" ", trim($user->full_name));
    if(count($user_exploded_full_name)>2){
        $user_first_name = $user_exploded_full_name[0] . " " . $user_exploded_full_name[1];
        $user_last_name = $user_exploded_full_name[2];
    }else{
        $user_first_name = $user_exploded_full_name[0];
        $user_last_name = $user_exploded_full_name[1];
    }

    // Satın alan kişi bilgileri
    $buyer = new Buyer([
        'id' => $user->id,
        'name' => $user_first_name,
        'surname' => $user_last_name,
        'email' => $user->email,
        'phone' => $user->phone_number
    ]);
    
    // Fatura ve kargo adresi birlikte tanımlama
    // Ayrı ayrı da tanımlabilir
    $address = new Address([
        'address' => $user->address,
        'city' => $user->city,
        'country' => 'Turkey',
        'postcode' => '83440',
    ]);
    
    // shopier parametlerini al
    $params = $shopier->getParams();
    
    // Satın alan kişi bilgisini ekle
    $params->setBuyer($buyer);
    
    // Fatura ve kargo adresini aynı şekilde ekle
    $params->setAddress($address);
    
    $conversationId = uniqid() . '_' . $user->id;
    // Sipariş numarsı ve sipariş tutarını ekle
    $shopier->setOrderData($conversationId, $price);
    
    // Sipariş edilen ürünü ekle
    $shopier->setProductData($price . 'TL Site İçi Bakiye', ProductType::DOWNLOADABLE_VIRTUAL);
    
    try {
    
        /**
         * Otomarik ödeme sayfasına yönlendiren renderer
         *
         * @var AutoSubmitFormRenderer $renderer
         */
        $renderer = $shopier->createRenderer(AutoSubmitFormRenderer::class);

        $CI->db->insert('payment_log', [
            'conversation_id' => $conversationId,
            'method_id' => 4,
            'json' => '{}',
            'price' => $price,
            'paid_price' => $price,
            'user_id' => getActiveUser()->id,
            'is_active' => 0
        ]);

        $shopier->goWith($renderer);
    
    } catch (RequiredParameterException $e) {
        // Zorunlu parametlerden bir ve daha fazlası eksik
        return FALSE;
    } catch (NotRendererClassException $e) {
        // $shopier->createRenderer(...) metodunda verilen class adı AbstracRenderer sınıfından türetilmemiş !
        return FALSE;
    } catch (RendererClassNotFoundException $e) {
        // $shopier->createRenderer(...) metodunda verilen class bulunamadı !
        return FALSE;
    }
}

function iyzicoPaymentForm($price, $user){
    require APPPATH . 'third_party/iyzipay/IyzipayBootstrap.php';
    IyzipayBootstrap::init();

    $CI = &get_instance();
    $paymentMethod = $CI->db->where([
        'id' => 1
    ])->get('payment_methods')->row();
    if(!isset($paymentMethod->id)){
        return FALSE;
    }

    $paymentMethodData = json_decode($paymentMethod->api_json);

    $options = new \Iyzipay\Options();
    $options->setApiKey($paymentMethodData->api_key);
    $options->setSecretKey($paymentMethodData->api_secret_key);
    $options->setBaseUrl($paymentMethodData->base_url);

    $conversationId = uniqid();
    $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
    $request->setLocale(\Iyzipay\Model\Locale::TR);
    $request->setConversationId($conversationId);
    $request->setPrice($price);
    $request->setPaidPrice($price);
    $request->setCurrency(\Iyzipay\Model\Currency::TL);
    $request->setBasketId(uniqid() . '.' . $user->id . '.' . permalink($user->email));
    $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
    $request->setCallbackUrl(base_url("api/pay/iyzico"));
    $request->setEnabledInstallments(array(2, 3, 6, 9, 12));
    $buyer = new \Iyzipay\Model\Buyer();
    $buyer->setId($user->id);
    $user_exploded_full_name = explode(" ", trim($user->full_name));
    if(count($user_exploded_full_name)>2){
        $user_first_name = $user_exploded_full_name[0] . " " . $user_exploded_full_name[1];
        $user_last_name = $user_exploded_full_name[2];
    }else{
        $user_first_name = $user_exploded_full_name[0];
        $user_last_name = $user_exploded_full_name[1];
    }
    $buyer->setName($user_first_name);
    $buyer->setSurname($user_last_name);
    $buyer->setGsmNumber("+9" . $user->phone_number);
    $buyer->setEmail($user->email);
    $buyer->setIdentityNumber($user->tc_no);
    $buyer->setLastLoginDate(date("Y-m-d H:i:s"));
    $buyer->setRegistrationDate($user->created_at);
    $buyer->setRegistrationAddress($user->address);
    $buyer->setIp(getIPAddress());
    $buyer->setCity($user->city);
    $buyer->setCountry("Turkey");

    $request->setBuyer($buyer);
    $shippingAddress = new \Iyzipay\Model\Address();
    $shippingAddress->setContactName($user->full_name);
    $shippingAddress->setCity($user->city);
    $shippingAddress->setCountry("Turkey");
    $shippingAddress->setAddress($user->address);
    $request->setShippingAddress($shippingAddress);

    $billingAddress = new \Iyzipay\Model\Address();
    $billingAddress->setContactName($user->full_name);
    $billingAddress->setCity($user->city);
    $billingAddress->setCountry("Turkey");
    $billingAddress->setAddress($user->address);
    $request->setBillingAddress($billingAddress);

    $basketItems = array();
    $firstBasketItem = new \Iyzipay\Model\BasketItem();
    $firstBasketItem->setId(uniqid() . '.' . $user->id . '.' . permalink($user->email));
    $firstBasketItem->setName("Site İçi Bakiye Yüklemesi");
    $firstBasketItem->setCategory1("Site İçi");
    $firstBasketItem->setCategory2("Bakiye Yükleme");
    $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
    $firstBasketItem->setPrice($price);
    $basketItems[0] = $firstBasketItem;

    $request->setBasketItems($basketItems);

    $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, $options);
    if(empty($checkoutFormInitialize->getCheckoutFormContent())){
        return FALSE;
    }else{
        return '<div id="iyzipay-checkout-form" class="responsive"></div>' . $checkoutFormInitialize->getCheckoutFormContent();
    }
}

function iyzicoPaymentCallback($token){
    require APPPATH . 'third_party/iyzipay/IyzipayBootstrap.php';
    IyzipayBootstrap::init();

    $CI = &get_instance();
    $paymentMethod = $CI->db->where([
        'id' => 1
    ])->get('payment_methods')->row();
    if(!isset($paymentMethod->id)){
        return FALSE;
    }

    $paymentMethodData = json_decode($paymentMethod->api_json);

    $options = new \Iyzipay\Options();
    $options->setApiKey($paymentMethodData->api_key);
    $options->setSecretKey($paymentMethodData->api_secret_key);
    $options->setBaseUrl($paymentMethodData->base_url);

    $conversationId = uniqid();
    $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
    $request->setLocale(\Iyzipay\Model\Locale::TR);
    $request->setConversationId($conversationId);
    $request->setToken($token);

    $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $options);
    return json_decode($checkoutForm->getRawResult());
}

function paytrPaymentForm($price, $user){
    $CI = &get_instance();
    $paymentMethod = $CI->db->where([
        'id' => 2
    ])->get('payment_methods')->row();
    if(!isset($paymentMethod->id)){
        return FALSE;
    }
    $paytrAPIDetails = json_decode($paymentMethod->api_json);
    $oid = time() + rand(1, 999);
    $merchant_id = $paytrAPIDetails->merchant_id;
    $merchant_key = $paytrAPIDetails->merchant_key;
    $merchant_salt = $paytrAPIDetails->merchant_salt;
    $email = $user->email;
    $paid_price = $price + ($price * (2.99/100));
    $payment_amount = $paid_price * 100;
    $merchant_oid =  $oid;
    $user_name = $user->full_name;
    //$user_address = $user->address;
    $user_address = 'Fiziksel Adres';
    $user_phone = '+9' . $user->phone_number;
    $merchant_ok_url = base_url('odeme-yontemleri?payment_success');
    $merchant_fail_url = base_url('odeme-yontemleri?payment_failed');

    $user_basket = base64_encode(json_encode(array(
        array('Site İçi Bakiye Yüklemesi' , $price, '1')
    )));

    if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
        $ip = $_SERVER["REMOTE_ADDR"];
    }

    $user_ip = $ip;
    $timeout_limit = "30";
    $debug_on = 0;
    $test_mode = 0;
    $no_installment  = 1;
    $max_installment = 0;

    $currency = 'TL';
    $hash_str = $merchant_id .$user_ip .$merchant_oid . $email . floor($payment_amount) .$user_basket.$no_installment.$max_installment.$currency.$test_mode;
    $paytr_token = base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt, $merchant_key, true));

    $post_vals = array(
        'merchant_id'=>$merchant_id,
        'user_ip'=>$user_ip,
        'merchant_oid'=>$merchant_oid,
        'email'=>$email,
        'payment_amount'=>floor($payment_amount),
        'paytr_token'=>$paytr_token,
        'user_basket'=>$user_basket,
        'debug_on'=>$debug_on,
        'no_installment'=>$no_installment,
        'max_installment'=>$max_installment,
        'user_name'=>$user_name,
        'user_address'=>$user_address,
        'user_phone'=>$user_phone,
        'merchant_ok_url'=>$merchant_ok_url,
        'merchant_fail_url'=>$merchant_fail_url,
        'timeout_limit'=>$timeout_limit,
        'currency'=>$currency,
        'test_mode'=>$test_mode
    );
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1) ;
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    $result = @curl_exec($ch);
    if(curl_errno($ch))
        //die("PAYTR IFRAME connection error. err:".curl_error($ch));
        return FALSE;
    curl_close($ch);
    $result = json_decode($result,1);
    if($result['status'] == 'success') {
        $CI->db->insert('payment_log', [
            'conversation_id' => $oid,
            'method_id' => 2,
            'price' => $price,
            'paid_price' => $paid_price,
            'user_id' => getActiveUser()->id,
            'is_active' => 0
        ]);
        return '<script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
                <iframe src="https://www.paytr.com/odeme/guvenli/' . $result['token'] . '" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
                <script>iFrameResize({},\'#paytriframe\');</script>';
    }else{
        //die("PAYTR IFRAME failed. reason:".$result['reason']);
        return FALSE;
    }
}

function paytrEftForm($price, $user){
    $CI = &get_instance();
    $paymentMethod = $CI->db->where([
        'id' => 2
    ])->get('payment_methods')->row();
    if(!isset($paymentMethod->id)){
        return FALSE;
    }
    $paytrAPIDetails = json_decode($paymentMethod->api_json);
    $oid = time() + rand(1, 999);
    $merchant_id = $paytrAPIDetails->merchant_id;
    $merchant_key = $paytrAPIDetails->merchant_key;
    $merchant_salt = $paytrAPIDetails->merchant_salt;
    $email = $user->email;
    $paid_price = round($price + ($price * (1/100)));
    $paid_price = $price;
    $payment_amount = $price * 100;
    $payment_type = 'eft';
    $merchant_oid =  $oid;
    $user_name = $user->full_name;
    $user_address = $user->address;
    $user_phone = '+9' . $user->phone_number;
    $merchant_ok_url = base_url('odeme-yontemleri?payment_success');
    $merchant_fail_url = base_url('odeme-yontemleri?payment_failed');

    $user_basket = base64_encode(json_encode(array(
        array('Site İçi Bakiye Yüklemesi' , $price, '1')
    )));

    if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
        $ip = $_SERVER["REMOTE_ADDR"];
    }

    $user_ip = $ip;
    $timeout_limit = "30";
    $debug_on = 0;
    $test_mode = 0;
    $no_installment  = 1;
    $max_installment = 0;

    $currency = 'TL';

    $hash_str=$merchant_id.$user_ip.$merchant_oid.$email.$payment_amount.$payment_type.$test_mode;
    $paytr_token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));

    $post_vals=array(
        'merchant_id'=>$merchant_id,
        'user_ip'=>$user_ip,
        'merchant_oid'=>$merchant_oid,
        'email'=>$email,
        'payment_amount'=>$payment_amount,
        'payment_type'=>$payment_type,
        'paytr_token'=>$paytr_token,
        'debug_on'=>$debug_on,
        'timeout_limit'=>$timeout_limit,
        'test_mode'=>$test_mode
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1) ;
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    $result = @curl_exec($ch);
    if(curl_errno($ch)) {
        //die("PAYTR IFRAME connection error. err:".curl_error($ch));
        return FALSE;
    }
    curl_close($ch);
    $result = json_decode($result,1);
    if($result['status'] == 'success') {
        $CI->db->insert('payment_log', [
            'conversation_id' => $oid,
            'method_id' => 2,
            'price' => $price,
            'paid_price' => $paid_price,
            'user_id' => getActiveUser()->id,
            'is_active' => 0
        ]);
        return '<script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
        <iframe src="https://www.paytr.com/odeme/api/' . $result['token'] . '" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
        <script>iFrameResize({},"#paytriframe");</script>';
    }else{
        //die("PAYTR IFRAME failed. reason:".$result['reason']);
        return FALSE;
    }
}

function gpayPaymentForm($price, $user, $type = '') {
    $CI = &get_instance();
    $paymentMethod = $CI->db->where([
        'id' => 4
    ])->get('payment_methods')->row();
    if(!isset($paymentMethod->id)){
        return FALSE;
    }

    $paymentMethodData = json_decode($paymentMethod->api_json);

    if($paymentMethod->commission == 1) {
        $paid_price = $price + ($price*(2/100));
    } else {
        $paid_price = $price;
    }

    $order_id = time();

    $url = 'https://gpay.com.tr/ApiRequest';
    /*$url = 'https://demo.gpay.com.tr/ApiRequest';*/
    $data = array(
        'username' => $paymentMethodData->username,
        'key' => $paymentMethodData->key,
        'order_id' => base64_encode($order_id),
        'currency' => '949',
        'return_url' => base_url('odeme-yontemleri?gpay_return'),
        'products' => array(
            array(
                'product_name' => str_replace(['https://','http://','/'], NULL, base_url()) . ' Bakiye Yüklemesi',
                'product_amount' => $price,
                'product_currency' => '949',
                'product_type' => 'oyun',
                'product_img' => base_url('logo.png')
            )
        )
    );

    if ($type) {
        $data['selected_payment'] = $type;

        switch($type) {
            case 'havale':
                if($paymentMethod->commission == 1) {
                    $paid_price = $price + ($price * (1 / 100));
                }
                $data['amount'] = $paid_price;
            break;
            case 'bkmexpress':
                $paid_price = $price + ($price*(3/100));
                $data['amount'] = $paid_price;
            break;
            case 'krediKarti':
                if($paymentMethod->commission == 1) {
                    $paid_price = $price + ($price*(2/100));
                }
                $data['amount'] = $paid_price;
            break;
            case 'ininal':
                if($paymentMethod->commission == 1) {
                    $paid_price = $price + ($price*(2.2/100));
                }
                $data['amount'] = $paid_price;
            break;
            case 'mobilOdeme':
                $paid_price = $price + ($price*(100/100));
                $data['amount'] = $paid_price;
            break;
        }
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    curl_close($ch);

    $json_data = json_decode($result);
    if ($json_data->state === 0) {
        //var_dump($json_data->error_code, $json_data->message);
        return FALSE;
    } else {
        $CI->db->insert('payment_log', [
            'conversation_id' => $order_id,
            'method_id' => 4,
            'price' => $price,
            'paid_price' => $paid_price,
            'user_id' => $user->id,
            'is_active' => 0
        ]);
        return $json_data->link;
    }
}

function payreksPaymentForm($price, $user, $method=3){
    $CI = &get_instance();
    $paymentMethod = $CI->db->where([
        'id' => 5
    ])->get('payment_methods')->row();
    if(!isset($paymentMethod->id)){
        return FALSE;
    }

    $paymentMethodData = json_decode($paymentMethod->api_json);

    function curlRequest($url,$data)
    {
        $_ch = curl_init($url);
        curl_setopt($_ch, CURLOPT_CUSTOMREQUEST, "POST");
        if (is_array($data))
            curl_setopt($_ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($_ch, CURLOPT_SSL_VERIFYPEER, false);
        $_output = curl_exec($_ch);
        curl_close($_ch);
        return $_output;
    }

    //Token Create Function
    function APITokenCreate($apiKey, $secretKey)
    {
        $context = hash_init("sha256", HASH_HMAC, $secretKey);
        hash_update($context, $apiKey);
        $return = hash_final($context);
        $context2 = hash_init("md5", HASH_HMAC, $secretKey);
        hash_update($context2, $return);
        return hash_final($context2);
    }

    //Client IP Address Function
    function getRealIpAddress()
    {
        $ipAddress = null;
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            $ipAddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipAddress = 'UNKNOWN';
        return $ipAddress;
    }

    $order_id = time() + rand(0,999);

    $apiKey = $paymentMethodData->api_key; //Mağaza api key
    $secretKey = $paymentMethodData->secret_key; //Mağaza secret key

    $APIToken = APITokenCreate($apiKey, $secretKey); //Api token
    $userID = $user->id; //Alıcı ID numarası
    $userInfo = $user->email; //Alıcı e-posta adresi veya kullanıcı adı
    $userIP = getRealIpAddress(); //Alıcı IP adresi
    $callbackUrl = base_url('api/pay/payreks'.($method==1?'KrediKarti':'')); //Ödeme sonrası verilerin gönderileceği geri dönüş adresi
    $redirectUrl = base_url('bakiye-yukle/payreks/'.($method==3?'mobilodeme':'kredikarti')); //Ödeme sonrası alıcının yönlendirileceği adres
    $productName = $price . " AZN Bakiye"; //Ürün Adı
    $returnData = $order_id; // Ödeme sonra hesaba yüklenecek değer (Aynı şekilde geri döner)
    $amount = $price; //Ödemesi yapılacak ürünün fiyatı
    $payment = $method; //Kredi kartı : 1 , Havale/EFT : 2 , Mobil Ödeme : 3 , İninal Kart : 4
    $commission_type = 2; //Komisyonu ben ödeyeceğim : 1 , Komisyonu alıcı ödeyecek : 2

    //Api istek adresi
    $requestURL = "https://api.payreks.com/gateway/v2";
    //Api istek dizisi
    $requestData = [
        "api_key" => $apiKey, // Zorunlu
        "token" => $APIToken, // Zorunlu
        "return_type" => "json", // Opsiyonel
        "return_data" => $returnData, // Zorunlu
        "callback_url" => $callbackUrl, // Opsiyonel
        "redirect_url" => $redirectUrl, // Opsiyonel
        "product_name" => $productName, // Zorunlu
        "user_id" => $userID, // Zorunlu
        "user_info" => $userInfo, // Zorunlu
        "user_ip" => $userIP, // Zorunlu
        "amount" => $amount, // Zorunlu
        "payment" => $payment, // Zorunlu
        "commission_type" => $commission_type, // Opsiyonel
    ];

    $APIRequest = curlRequest($requestURL,$requestData);
    $APIResponse =  json_decode($APIRequest);

    $APIStatus = $APIResponse->status; //Api cevap durum kodu
    $APIMessage = $APIResponse->message; //Payreks hata mesajı
    if ($APIStatus == 200) {
        $CI->db->insert('payment_log', [
            'conversation_id' => $order_id,
            'method_id' => ($method == 1)?6:5,
            'json' => json_encode($APIResponse),
            'price' => $price,
            'paid_price' => ($price * ($method == 1 ? 1.08:1.67)),
            'user_id' => $user->id,
            'is_active' => 0
        ]);
        return $APIResponse->link;
    }
    return FALSE;
}

function payBrothersPaymentForm($price, $user) {
    $CI = &get_instance();
    $paymentMethod = $CI->db->where([
        'id' => 6
    ])->get('payment_methods')->row();
    if(!isset($paymentMethod->id)){
        return FALSE;
    }
    $apiInf = json_decode($paymentMethod->api_json);

    $order_id = time() + rand(0,rand(111,999));

    $paid_price = $price + ($price * (1/100));

    $hash = hash('sha256', $order_id . ($paid_price * 100) . $apiInf->app_id);

    $postFields = [
        'CurrencyCode' => 949,
        'OrderId' => $order_id,
        'BaseAmount' => ($paid_price * 100),
        'SuccessUrl' => base_url('bakiye-yukle/paybrothers/kredi-karti?payment_success'),
        'FailUrl' => base_url('bakiye-yukle/paybrothers/kredi-karti?payment_failed'),
        'PaymentMethodCode' => 'CC',
        'Ip' => getIPAddress(),
        'Hash' => NULL,
        'ProductList' => [
            [
                'title' => number_format($price,2) . 'TL Site İçi Bakiye Yüklemesi',
                'qty' => 1,
                'amount' => $price
            ]
        ]
    ];

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://apistg.paybrothers.com/Payment/startcreditcardpayment",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($postFields),
        CURLOPT_HTTPHEADER => array(
            "AppId: " . $apiInf->app_id,
            "AppSecret: " . $apiInf->app_secret,
            "Content-Type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return FALSE;
    } else {
        $_response = json_decode($response);
        if ($_response->Success == true) {
            $CI->db->insert('payment_log', [
                'conversation_id' => $order_id,
                'method_id' => $paymentMethod->id,
                'json' => json_encode($_response),
                'price' => $price,
                'paid_price' => $paid_price,
                'user_id' => $user->id,
                'is_active' => 0
            ]);
            redirect($_response->Data->RedirectUrl);
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

function payByMePaymentForm($price, $user) {
    $CI = &get_instance();
    $paymentMethod = $CI->db->where([
        'id' => 7
    ])->get('payment_methods')->row();
    if(!isset($paymentMethod->id)){
        return FALSE;
    }
    $apiInf = json_decode($paymentMethod->api_json);

    $order_id = time() + rand(0,rand(111,999));

    $paid_price = $price + ($price * (1/100));

    $hash = hash('sha256', $order_id . ($paid_price * 100) . $apiInf->app_id);

    $postvar = array(
        'username' => $apiInf->username,
        'password' => $apiInf->password,
        'syncId' => $order_id,
        'subCompany' => str_replace(['https://', 'http://', '/'], null, base_url()),
        'assetName' => number_format($price, 2) . 'TL Bakiye Yüklemesi',
        'assetPrice' => ($price * 100),
        'clientIp' => getIPAddress(),
        'countryCode' => 'TR',
        'currencyCode' => 'TRY',
        'languageCode' => 'tr',
        'notifyPage' => base_url('api/pay/paybyme'),
        'errorPage' => base_url('bakiye-yukle/paybyme/kredi-karti?payment_failed'),
        'redirectPage' => base_url('bakiye-yukle/paybyme/kredi-karti?payment_success'),
        'paymentType' => 'vpos'
    );

    $postvar = http_build_query($postvar);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://pos.payby.me/webpayment/request.aspx');
    curl_setopt($curl, CURLOPT_REFERER, base_url());
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postvar);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    $response = curl_exec($curl);
    curl_close($curl);
    print_r($response);
    exit;
}
function paymaxPaymentForm($price, $user) {
    $CI = &get_instance();
    $paymentMethod = $CI->db->where([
        'id' => 8
    ])->get('payment_methods')->row();
    if(!isset($paymentMethod->id)){
        return FALSE;
    }
    $apiInf = json_decode($paymentMethod->api_json);

    $order_id = time();

    $paid_price = $price + ($price * (3/100));
    
    $user_exploded_full_name = explode(" ", trim($user->full_name));
    if(count($user_exploded_full_name)>2){
        $user_first_name = $user_exploded_full_name[0] . " " . $user_exploded_full_name[1];
        $user_last_name = $user_exploded_full_name[2];
    }else{
        $user_first_name = $user_exploded_full_name[0];
        $user_last_name = $user_exploded_full_name[1];
    }

    $CI->load->library('paymax_light_api',[
        $apiInf->username,
        $apiInf->password,
        $apiInf->shop_code,
        $apiInf->hash]);
    /*Sınıfı Api bilgilerinizle başlatın*/
    $paymax = new Paymax_light_api([
        $apiInf->username,
        $apiInf->password,
        $apiInf->shop_code,
        $apiInf->hash]);
    /*Sipariş Bilgilerinizi Tanımlayın*/
    $order_data = array(
        'productName' => number_format($price, 2) . 'TL Bakiye Yüklemesi',
        'productData' => array(
            array(
                'productName'=>number_format($price, 2) . 'TL Bakiye Yüklemesi',
                'productPrice'=>$price,
                'productType'=>'DIJITAL_URUN',
            ),
        ),
        'productType' => 'DIJITAL_URUN',
        'productsTotalPrice' => $price,
        'orderPrice' => $paid_price,
        'currency' => 'TRY',
        'orderId' => $order_id,
        'locale' => 'tr',
        'conversationId' => '',
        'buyerName' => $user_first_name,
        'buyerSurName' => $user_last_name,
        'buyerGsmNo' => $user->phone_number,
        'buyerIp' => getIPAddress(),
        'buyerMail' => $user->email,
        'buyerAdress' => "Çavuşbaşı Mah. Hesap Sokak 7/A",
        'buyerCountry' => "Türkiye",
        'buyerCity' => "Ankara",
        'buyerDistrict' => ''
    );
    /*Sipariş Bilgilerinizi link oluşturmak için sınıfa gönderin*/
    $request = $paymax->create_payment_link($order_data);
    
    $CI->db->insert('payment_log', [
        'conversation_id' => $order_id,
        'method_id' => 8,
        'json' => json_encode($request),
        'price' => $price,
        'paid_price' => ($price * 1.03),
        'user_id' => $user->id,
        'is_active' => 0
    ]);
    return $request;
}

function paymesPaymentForm($price, $user, $creditCardInformation = array()){
    $CI = &get_instance();
    $paymentMethod = $CI->db->where([
        'id' => 7
    ])->get('payment_methods')->row();
    if(!isset($paymentMethod->id)){
        return FALSE;
    }

    $paymentMethodData = json_decode($paymentMethod->api_json);

    $user_exploded_full_name = explode(" ", trim($user->full_name));
    if(count($user_exploded_full_name)>2){
        $user_first_name = $user_exploded_full_name[0] . " " . $user_exploded_full_name[1];
        $user_last_name = $user_exploded_full_name[2];
    }else{
        $user_first_name = $user_exploded_full_name[0];
        $user_last_name = $user_exploded_full_name[1];
    }

    $paid_price = ($price + ($price * (3.49/100)));

    $api_url = 'https://web.paym.es/api/authorize';
    $conversationId = uniqid() . '.' . $user->id;
    $postData = [
        'secret' => $paymentMethodData->secret_key,
        'operationId' => $conversationId,
        'number' => $creditCardInformation->creditCardNumber,
        'installmentsNumber' => 1,
        'expiryMonth' => $creditCardInformation->expiryMonth,
        'expiryYear' => $creditCardInformation->expiryYear,
        'cvv' => $creditCardInformation->cvv,
        'owner' => $creditCardInformation->owner,
        'billingFirstname' => $user_first_name,
        'billingLastname' => $user_last_name,
        'billingEmail' => $user->email,
        'billingPhone' => $user->phone_number,
        'billingCountrycode' => 'TR',
        'billingAddressline1' => 'Çavuşbaşı Mah. Hesap Sokak 7/A',
        'billingCity' => 'Ankara',
        'deliveryFirstname' => $user_first_name,
        'deliveryLastname' => $user_last_name,
        'deliveryPhone' => $user->phone_number,
        'deliveryAddressline1' => 'Çavuşbaşı Mah. Hesap Sokak 7/A',
        'deliveryCity' => 'Ankara',
        'clientIp' => getIPAddress(),
        'productName' => number_format($price, 2, ',', '.') . 'TL Bakiye Yüklemesi',
        'productSku' => 'STOKTA VAR',
        'productQuantity' => 1,
        'productPrice' => $paid_price,
        'currency' => 'TRY',
        'comment' => base_url() . ' ' . number_format($price, 2, ',', '.') . 'TL Bakiye Yüklemesi',
    ];

    $request = _curl($api_url, $postData);

    $json = json_decode($request);
    if(isset($json->status)){
        if($json->status == 'SUCCESS'){
            if(isset($json->paymentResult->url)){
                $CI->db->insert('payment_log', [
                    'conversation_id' => $conversationId,
                    'method_id' => 4,
                    'json' => $request,
                    'price' => $price,
                    'paid_price' => $paid_price,
                    'user_id' => $user->id,
                    'is_active' => 0
                ]);
                //redirect($json->paymentResult->url);
                //return TRUE;
                return '<iframe id="paymesIframe" src="' . $json->paymentResult->url . '" frameBorder="0" width="100%" height="600"></iframe>';
            }else{
                $CI->db->insert('payment_log', [
                    'conversation_id' => $conversationId,
                    'method_id' => 4,
                    'json' => $request,
                    'price' => $price,
                    'paid_price' => $paid_price,
                    'user_id' => $user->id,
                    'is_active' => 1
                ]);
                $CI->db->query("UPDATE users SET balance = balance + ? WHERE id = ?", [
                    $price,
                    $user->id
                ]);
                //sendSMS($CI->db->where('id=' . $user->id)->get('users')->row()->phone_number, date("d.m.Y H:i") . '  tarihinde yaptığınız ödemeniz onaylanmıştır. İlgili tutar bakiyenize eklenmiştir. ' . base_url());
                insertUserStep($user->id, 'paymes', [
                    'status' => TRUE,
                    'paid_price' => $paid_price,
                    'add_balance' => $price
                ]);
                return TRUE;
            }
        }else{
            return FALSE;
        }
    } else {
        return FALSE;
    }

}