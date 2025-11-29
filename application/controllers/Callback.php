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

class Callback extends CI_Controller
{

    public function __construct(){
        parent::__construct();
    }
    public function pinabi() {
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        if(isset($data->status->code) && $data->status->code == 200){
            $uniq_id = explode('_',$data->clientTransactionId);
            $processNo = $uniq_id[0];
            $orderDetailNo = $uniq_id[1];
            $order = $this->db->where(['process_no',$processNo])->get('orders')->first_row();
            if($order) {
                $cart = json_decode($order->cart_json);
                $productKey = array_search($orderDetailNo,array_column($cart,'orderDetailNo'));
                if($productKey) {
                    foreach($data->lstEpin as $key=>$epin) {
                        $this->db->insert('stock_pool', [
                            'code' => $epin,
                            'product_id' => $cart[$productKey]->product->id,
                            'product_json' => json_encode($cart[$productKey]->product),
                            'is_sold' => 1,
                            'user_id' => $order->user_id,
                            'order_id' => $order->id
                        ]);
                    }
                }
            }
        }
    }
    public function paymax(){
        $paymentMethod = $this->db->where([
            'id' => 8
        ])->get('payment_methods')->row();
        if(!isset($paymentMethod->id)){
            redirect();
            return;
        }
        $method_info = json_decode($paymentMethod->api_json);
        $paymax_config = array(
            'userName'=>$method_info->username,
            'password'=>$method_info->password,
            'shopCode'=>$method_info->shop_code,
            'hash'=>$method_info->hash,
        );

        $post = array();
        $post['status'] = $_POST['status'];
        $post['paymentStatus'] = $_POST['paymentStatus'];
        $post['hash'] = $_POST['hash'];
        $post['paymentCurrency'] = $_POST['paymentCurrency'];
        $post['paymentAmount'] = $_POST['paymentAmount'];
        $post['paymentType'] = $_POST['paymentType'];
        $post['paymentTime'] = $_POST['paymentTime'];
        $post['conversationId'] = $_POST['conversationId'];
        $post['orderId'] = $_POST['orderId'];
        $post['shopCode'] = $_POST['shopCode'];
        $post['orderPrice'] = $_POST['orderPrice'];
        $post['productsTotalPrice'] = $_POST['productsTotalPrice'];
        $post['productType'] = $_POST['productType'];
        $post['callbackOkUrl'] = $_POST['callbackOkUrl'];
        $post['callbackFailUrl'] = $_POST['callbackFailUrl'];

        if (empty($post['status']) || empty($post['paymentStatus']) || empty($post['hash']) || empty($post['paymentCurrency']) || empty($post['paymentAmount']) || empty($post['paymentType']) || empty($post['orderId']) || empty($post['shopCode']) || empty($post['orderPrice']) || empty($post['productsTotalPrice']) || empty($post['productType']) || empty($post['callbackOkUrl']) || empty($post['callbackFailUrl']))
        {
            echo 'EKSIK_FORM_DATASI';
            exit();
        }
        else
        {
            $hash_string = $post['orderId'].$post['paymentCurrency'].$post['orderPrice'].$post['productsTotalPrice'].$post['productType'].$paymax_config["shopCode"].$paymax_config["hash"];
            $MY_HASH = base64_encode(pack('H*',sha1($hash_string)));
            if ($MY_HASH!==$post['hash'])
            {
                echo 'HATALI_HASH_IMZASI';
                exit();
            }
            else
            {
                if ($post['paymentStatus']=='paymentOk')
                {
					$payment = $this->db->where([
                        'is_active' => 0,
                        'conversation_id' => $post['orderId']
                    ])->get('payment_log')->row();
                    if (!$payment)
                    {
                        /*Böyle bir sipariş sistemimde yok*/
                        echo 'GECERSIZ_SIPARIS_NUMARASI';
                        exit();
                    }
                    else if($payment->is_active == 1)
                    {
                        /*Zaten ödenmiş ve işlenmiş*/
                        echo 'OK';
                        exit();
                    }
                    else
                    {
                        $this->db->update('payment_log', [
                            'price' => $payment->price,
                            'paid_price' => $post['orderPrice'],
                            'is_active' => 1,
                            'is_okay' => 1
                        ],[
                            'conversation_id' => $this->input->post('id', TRUE)
                        ]);
                        $this->db->query("UPDATE users SET balance = balance + ? WHERE id = ?", [
                            $payment->price,
                            $payment->user_id
                        ]);
                        echo 'OK';
                        exit();
                    }
                }
            }
        }
    }
    public function paymes(){
        $paymentMethod = $this->db->where([
            'id' => 7
        ])->get('payment_methods')->row();
        if(!isset($paymentMethod->id)){
            redirect();
            return;
        }

        if(isset($_POST['payuPaymentReference'])){
            if($this->input->post('message', TRUE) == 'AUTHORIZED'){
                $exploded_id = explode(".", $this->input->post('id', TRUE));
                if($this->db->where([
                        'is_active' => 0,
                        'conversation_id' => $this->input->post('id', TRUE),
                        'user_id' => $exploded_id[1]
                    ])->get('payment_log')->result()>0){
                    $log = $this->db->where([
                        'is_active' => 0,
                        'conversation_id' => $this->input->post('id', TRUE),
                        'user_id' => $exploded_id[1]
                    ])->get('payment_log')->row();
                    $this->db->update('payment_log', [
                        'price' => $log->price,
                        'paid_price' => $this->input->post('amount', TRUE),
                        'is_active' => 1,
                        'is_okay' => 1
                    ],[
                        'conversation_id' => $this->input->post('id', TRUE)
                    ]);
                    $this->db->query("UPDATE users SET balance = balance + ? WHERE id = ?", [
                        $log->price,
                        $exploded_id[1]
                    ]);
                    $this->session->set_userdata('user', $this->db->where('id',$log->user_id)->get('users')->row());
                }
                echo '<script>window.parent.postMessage("payment_success", "*");</script>';
                return;
            }else{
                echo '<script>window.parent.postMessage("payment_failed", "*");</script>';
                return;
            }
        }
        redirect();
    }

    public function shopier(){
        if(isset($_POST['signature']) && isset($_POST['platform_order_id'])){
            $paymentMethod = $this->db->where([
                'id' => 3
            ])->get('payment_methods')->row();
            if(!isset($paymentMethod->id)){
                redirect();
                return;
            }
            $paymentMethodData = json_decode($paymentMethod->api_json);
            $shopier = new Shopier($paymentMethodData->api_key, $paymentMethodData->api_secret);
            $isValidPaymentResponse = $shopier->verifyResponse($_POST);
            if($isValidPaymentResponse){
                if($this->input->post('status', TRUE) == 'success'){
                    $payLogs = $this->db->where([
                        'conversation_id' => $this->input->post('platform_order_id', TRUE)
                    ])->get('payment_log')->result();
                    if(count($payLogs)>0){
                        $user_id = explode('_', $this->input->post('platform_order_id', TRUE))[1];
                        $this->db->update('payment_log', [
                            'conversation_id' => $this->input->post('platform_order_id', TRUE),
                            'method_id' => 4,
                            'json' => json_encode($_POST),
                            'is_active' => 1
                        ], [
                            'conversation_id' => $this->input->post('platform_order_id', TRUE)
                        ]);
                        $this->db->query("UPDATE `users` SET balance = balance + ? WHERE id = ?", [
                            $payLogs[0]->price,
                            $payLogs[0]->user_id
                        ]);
                        insertUserStep($user_id, 'shopier', [
                            'status' => TRUE,
                            'paid_price' => $payLogs[0]->paid_price,
                            'add_balance' => $payLogs[0]->price
                        ]);
                        redirect('odeme-yontemleri?payment_success');
                        return;
                    }else{
                        redirect('odeme-yontemleri?payment_success');
                        return;
                    }
                }else{
                    insertUserStep($user_id, 'iyzico', [
                        'status' => FALSE,
                        'paid_price' => $payLogs[0]->paid_price,
                        'add_balance' => $payLogs[0]->price
                    ]);
                    redirect('odeme-yontemleri?payment_failed');
                    return;
                }
            }else{
                redirect();
            }
            return;
        }
        redirect();
    }

    public function paytr(){
        $paymentMethod = $this->db->where([
            'id' => 2
        ])->get('payment_methods')->row();
        if(!isset($paymentMethod->id)){
            redirect();
            return;
        }

        $paymentMethodAPIDetails = json_decode($paymentMethod->api_json);

        $merchant_key = $paymentMethodAPIDetails->merchant_key;
        $merchant_salt = $paymentMethodAPIDetails->merchant_salt;

        $hash = base64_encode( hash_hmac('sha256', $this->input->post('merchant_oid',TRUE) . $merchant_salt . $this->input->post('status',TRUE) . $this->input->post('total_amount',TRUE), $merchant_key, true) );
        if( $hash != $this->input->post('hash',TRUE) )
            exit('PAYTR notification failed: bad hash');

        if($this->input->post('status', TRUE) == 'success') {
            $logs = $this->db->where([
                'conversation_id' => $this->input->post('merchant_oid',TRUE),
                'is_okay' => 0
            ])->get('payment_log')->result();
            if(count($logs)>0){
                $user_id = $logs[0]->user_id;
                $this->db->update('payment_log', [
                    'method_id' => 2,
                    'json' => json_encode($_POST),
                    'paid_price' => $this->input->post('total_amount',TRUE) / 100,
                    'user_id' => $user_id,
                    'is_active' => 1,
                    'is_okay' => 1
                ], [
                    'conversation_id' => $this->input->post('merchant_oid',TRUE)
                ]);
                $this->db->query("UPDATE `users` SET balance = balance + ? WHERE id = ?", [
                    $logs[0]->price,
                    $user_id
                ]);
                //sendSMS($this->db->where('id=' . $user_id)->get('users')->row()->phone_number, date("d.m.Y H:i", strtotime($logs[0]->created_at)) . '  tarihinde yaptığınız ödemeniz onaylanmıştır. İlgili tutar bakiyenize eklenmiştir. ' . base_url());
                insertUserStep($user_id, 'paytr', [
                    'status' => TRUE,
                    'paid_price' => $this->input->post('total_amount', TRUE) / 100,
                    'add_balance' => $logs[0]->price
                ]);
            }
        }else{
            $logs = $this->db->where([
                'conversation_id' => $this->input->post('merchant_oid',TRUE),
                'is_okay' => 0
            ])->get('payment_log')->result();
            if (count($logs)>0) {
                $this->db->update('payment_log', [
                    'method_id' => 2,
                    'json' => json_encode($_POST),
                    'paid_price' => $this->input->post('total_amount',TRUE) / 100,
                    'user_id' => $logs[0]->user_id,
                    'is_active' => 1,
                    'is_okay' => 0
                ], [
                    'conversation_id' => $this->input->post('merchant_oid',TRUE)
                ]);
                insertUserStep($logs[0]->user_id, 'paytr', [
                    'status' => FALSE,
                    'paid_price' => $this->input->post('total_amount'),
                    'add_balance' => $logs[0]->price
                ]);
            }
        }
        echo "OK";
    }

    public function iyzico(){
        if(isset($_POST['token'])):
            $response = iyzicoPaymentCallback($this->input->post('token', TRUE));
            if($response->paymentStatus == 'SUCCESS'){
                if(count($this->db->where([
                    'conversation_id' => $response->conversationId
                ])->get('payment_log')->result())==0){
                    $user_id = explode('.', $response->basketId)[1];
                    $this->db->insert('payment_log', [
                        'conversation_id' => $response->conversationId,
                        'method_id' => 1,
                        'json' => json_encode($response),
                        'price' => $response->price,
                        'paid_price' => $response->paidPrice,
                        'user_id' => $user_id
                    ]);
                    $this->db->query("UPDATE `users` SET balance = balance + ? WHERE id = ?", [
                        $response->price,
                        $user_id
                    ]);
                    insertUserStep($user_id, 'iyzico', [
                        'status' => TRUE,
                        'paid_price' => $response->paidPrice,
                        'add_balance' => $response->price
                    ]);
                    redirect('odeme-yontemleri?payment_success');
                    return;
                }else{
                    redirect('odeme-yontemleri?payment_success');
                    return;
                }
            }else{
                insertUserStep($user_id, 'iyzico', [
                    'status' => FALSE,
                    'paid_price' => $response->paidPrice,
                    'add_balance' => $response->price
                ]);
                redirect('odeme-yontemleri?payment_failed');
                return;
            }
        endif;
        redirect();
        return;
    }

    public function gpay() {
        $paymentMethod = $this->db->where([
            'id' => 4
        ])->get('payment_methods')->row();
        if(!isset($paymentMethod->id)){
            redirect();
            return;
        }

        $paymentMethodAPIDetails = json_decode($paymentMethod->api_json);

        $callback_ip = ["77.223.135.234", "185.197.196.51", "185.197.196.99"];
        $has_ip = false;

        /**
         * Gelen verileri değişkene atıyoruz. Lütfen test ederken ve hatta üretimde dahi bu gelen verilerin logunu tutunuz.
         */

        $callback_data = $_POST;
        $bayiiKey = $paymentMethodAPIDetails->key;
        $siparis_id = $callback_data['siparis_id'];
        $tutar = $callback_data['tutar'];
        $islem_sonucu = $callback_data['islem_sonucu'];

        $hash = md5(base64_encode(substr($bayiiKey, 0, 7) . substr($siparis_id, 0, 5) . strval($tutar) . $islem_sonucu));

        if (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
            if (strstr($ip, ',')) {
                $tmp = explode(',', $ip);
                $ip = trim($tmp[0]);
            }
        } else {
            $ip = getenv("REMOTE_ADDR");
        }

        foreach ($callback_ip as $c_ip) {
            if ($ip === $c_ip) {
                $has_ip = true;
                break;
            }
        }

        if($has_ip != true || $hash != $callback_data['hash']){
            die('4');
        }

        // burada siparis id ye göre diğer verileri çekeceğiz. örn $res = mysql_fetch_object(mysql_query("select * from table where siparis_id='$siparis_id'"))
        // burada örnek bir row yapıyorum burasını yukarıdaki gibi değiştirebilirsiniz
        if($this->db->where([
                'conversation_id' => base64_decode($callback_data['siparis_id']),
                'is_okay' => 1
            ])->get('payment_log')->num_rows()>0){
            die('2');
        }
        // burada kendinize özel bir kontrol yapıp eğer hatalı sonuç döndürürse ekrana 3 yazabilirsiniz. örn: die('3') gibi...
        // ...

        $log = $this->db->where([
            'conversation_id' => base64_decode($callback_data['siparis_id'])
        ])->get('payment_log')->row();

        if(!isset($log->id)) {
            die('2');
        }

        if($islem_sonucu == 2) {

            $this->db->update('payment_log', [
                'method_id' => 4,
                'json' => json_encode($_POST),
                'user_id' => $log->user_id,
                'is_active' => 1,
                'is_okay' => 1
            ], [
                'conversation_id' => base64_decode($callback_data['siparis_id'])
            ]);
            $this->db->query("UPDATE `users` SET balance = balance + ? WHERE id = ?", [
                $log->price,
                $log->user_id
            ]);

            insertUserStep($log->user_id, 'gpay', [
                'status' => TRUE,
                'paid_price' => $log->paid_price,
                'add_balance' => $log->price
            ]);
        } else {
            $this->db->update('payment_log', [
                'method_id' => 4,
                'json' => json_encode($_POST),
                'user_id' => $log->user_id,
                'is_active' => 1,
                'is_okay' => 0
            ], [
                'conversation_id' => base64_decode($callback_data['siparis_id'])
            ]);
            insertUserStep($log->user_id, 'gpay', [
                'status' => FALSE,
                'paid_price' => $log->paid_price,
                'add_balance' => $log->price
            ]);
        }
        echo "1";
    }
	
    public function payreksKrediKarti() {

        $paymentMethod = $this->db->where([
            'id' => 5
        ])->get('payment_methods')->row();
        if(!isset($paymentMethod->id)){
            redirect();
            return;
        }
        $paymentMethodAPIDetails = json_decode($paymentMethod->api_json);

        //Payreks Hash Control Function
        function payreksHashControl($type, $data, $key)
        {
            $context = hash_init($type, HASH_HMAC, $key);
            hash_update($context, $data);
            return hash_final($context);
        }

        //Post Control
        if (!$_POST)
            die("do not have post values");

        //Get Post Values
        $orderID = isset($_POST['order_id']) ? $this->input->post('order_id', TRUE) : null;
        $credit = isset($_POST['credit']) ? $this->input->post('credit', TRUE) : null;
        $userID = isset($_POST['user_id']) ? $this->input->post('user_id', TRUE) : null;
        $userInfo = isset($_POST['user_info']) ? $this->input->post('user_info', TRUE) : null;
        $payLabel = isset($_POST['pay_label']) ? $this->input->post('pay_label', TRUE) : null;
        $totalPrice = isset($_POST['total_price']) ? $this->input->post('total_price', TRUE) : null;
        $netPrice = isset($_POST['net_price']) ? $this->input->post('net_price', TRUE) : null;
        $hash = isset($_POST['hash']) ? $_POST['hash'] : null;

        //Control Post Keys
        if ($orderID === null || $credit === null || $userID === null || $userInfo === null || $payLabel === null ||
            $totalPrice === null || $netPrice === null || $hash === null)
            die("missing value");

        //Control Post Values
        if ($orderID === "" || $credit === "" || $userID === "" || $userInfo === "" || $payLabel === "" ||
            $totalPrice === "" || $netPrice === "" || $hash === "")
            die("empty value");

        $apiKey = $paymentMethodAPIDetails->api_key; //Mağaza api key
        $secretKey = $paymentMethodAPIDetails->secret_key; //Mağaza secret key

        $hashData = md5($orderID . $credit . $userID . $userInfo . $payLabel . $totalPrice . $netPrice . $apiKey);
        $hashCreate = payreksHashControl('sha256', $hashData, $secretKey);

        //Hash Control
        if ($hash !== $hashCreate)
            die("wrong hash");

        #Bu bölüme user_id ve user_info parametreleriyle gelen değerleri kontrol ettirerek alıcının doğrulunu kontrol ettiriniz.
        #Örnek (Kendi altyapınıza göre düzenleyiniz)
        $controlUser = $this->db->where([
            'id' => $userID,
            'email' => $userInfo
        ])->get('users')->row();

        //User Control
        if (!isset($controlUser->id))
            die("user not found");

        #Bu bölüme sipariş log kaydı ve order_id parametresini kullanarak log kaydı olup olmadığını kontrol ettiriniz.
        #Örnek (Kendi altyapınıza göre düzenleyiniz)
        $paymentLog = $this->db->where('conversation_id', $credit)->get('payment_log')->row();

        //Log Control
        if ($paymentLog->is_active == 1)
            die("order already have");

        //Insert Log Data
        $this->db->update('payment_log', [
            'json' => json_encode($_POST),
            'is_active' => 1,
            'is_okay' => 1
        ], [
            'id' => $paymentLog->id
        ]);

        //If Log Can Not Insert
        if ($this->db->affected_rows() == 0)
            die("log can not insert");

        #Bu bölüme alıcı hesabına kredi yükleme işlemini yaptırınız.
        #Örnek (Kendi altyapınıza göre düzenleyiniz)
        //Update Customer Credit
        $this->db->query("UPDATE users SET balance = balance + ? WHERE id = ?", [
            $netPrice,
            $paymentLog->user_id
        ]);

        //If Credit Can Not Upload
        if ($this->db->affected_rows() == 0)
            die("credit can not upload");

        //Tüm kontroller sağlandıktan ve alıcıya kredi yüklendikten sonra ekrana OK yazdırmalısınız.
        die("OK");
    }
    
        //Payreks Hash Control Function
    function payreksHashControl($type, $data, $key)
    {
        $context = hash_init($type, HASH_HMAC, $key);
        hash_update($context, $data);
        return hash_final($context);
    }
    public function payreks() {
        $paymentMethod = $this->db->where([
            'id' => 5
        ])->get('payment_methods')->row();
        if(!isset($paymentMethod->id)){
            redirect();
            return;
        }
        $paymentMethodAPIDetails = json_decode($paymentMethod->api_json);

        //Post Control
        if (!$_POST)
            die("do not have post values");

        //Get Post Values
        $orderID = isset($_POST['order_id']) ? $this->input->post('order_id', TRUE) : null;
        $credit = isset($_POST['credit']) ? $this->input->post('credit', TRUE) : null;
        $userID = isset($_POST['user_id']) ? $this->input->post('user_id', TRUE) : null;
        $userInfo = isset($_POST['user_info']) ? $this->input->post('user_info', TRUE) : null;
        $payLabel = isset($_POST['pay_label']) ? $this->input->post('pay_label', TRUE) : null;
        $totalPrice = isset($_POST['total_price']) ? $this->input->post('total_price', TRUE) : null;
        $netPrice = isset($_POST['net_price']) ? $this->input->post('net_price', TRUE) : null;
        $hash = isset($_POST['hash']) ? $_POST['hash'] : null;

        //Control Post Keys
        if ($orderID === null || $credit === null || $userID === null || $userInfo === null || $payLabel === null ||
            $totalPrice === null || $netPrice === null || $hash === null)
            die("missing value");

        //Control Post Values
        if ($orderID === "" || $credit === "" || $userID === "" || $userInfo === "" || $payLabel === "" ||
            $totalPrice === "" || $netPrice === "" || $hash === "")
            die("empty value");

        $apiKey = $paymentMethodAPIDetails->api_key; //Mağaza api key
        $secretKey = $paymentMethodAPIDetails->secret_key; //Mağaza secret key

        $hashData = md5($orderID . $credit . $userID . $userInfo . $payLabel . $totalPrice . $netPrice . $apiKey);
        $hashCreate = $this->payreksHashControl('sha256', $hashData, $secretKey);

        //Hash Control
        if ($hash !== $hashCreate)
            die("wrong hash");

        #Bu bölüme user_id ve user_info parametreleriyle gelen değerleri kontrol ettirerek alıcının doğrulunu kontrol ettiriniz.
        #Örnek (Kendi altyapınıza göre düzenleyiniz)
        $controlUser = $this->db->where([
            'id' => $userID,
            'email' => $userInfo
        ])->get('users')->row();

        //User Control
        if (!isset($controlUser->id))
            die("user not found");

        #Bu bölüme sipariş log kaydı ve order_id parametresini kullanarak log kaydı olup olmadığını kontrol ettiriniz.
        #Örnek (Kendi altyapınıza göre düzenleyiniz)
        $paymentLog = $this->db->where('conversation_id', $credit)->get('payment_log')->row();

        //Log Control
        if ($paymentLog->is_active == 1)
            die("order already have");

        //Insert Log Data
        $this->db->update('payment_log', [
            'json' => json_encode($_POST),
            'is_active' => 1,
            'is_okay' => 1
        ], [
            'id' => $paymentLog->id
        ]);
        //If Log Can Not Insert
        if ($this->db->affected_rows() == 0)
            die("log can not insert");

        #Bu bölüme alıcı hesabına kredi yükleme işlemini yaptırınız.
        #Örnek (Kendi altyapınıza göre düzenleyiniz)
        //Update Customer Credit
        $this->db->query("UPDATE users SET balance = balance + ? WHERE id = ?", [
            $netPrice,
            $paymentLog->user_id
        ]);

        //If Credit Can Not Upload
        if ($this->db->affected_rows() == 0)
            die("credit can not upload");

        //Tüm kontroller sağlandıktan ve alıcıya kredi yüklendikten sonra ekrana OK yazdırmalısınız.
        die("OK");
    }

    public function paybrothers() {

        $paymentMethod = $this->db->where([
            'id' => 6
        ])->get('payment_methods')->row();
        if(!isset($paymentMethod->id)){
            redirect();
            return;
        }

        $paymentMethodAPIDetails = json_decode($paymentMethod->api_json);

        $OrderId = $this->input->post('OrderId', TRUE);
        $RequestId = $this->input->post('RequestId', TRUE);
        $Date = $this->input->post('Date', TRUE);
        $Price = $this->input->post('Price', TRUE);
        $Success = $this->input->post('Success', TRUE);
        $PaymentChannel = $this->input->post('PaymentChannel', TRUE);

        file_put_contents('son.txt', json_encode($_POST));

        $log = $this->db->where([
            'is_active' => 0,
            'conversation_id' => $OrderId
        ])->get('payment_log')->row();

        if (isset($log->id)) {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://apistg.paybrothers.com/payment/paymentresultbyorderid",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'OrderId' => $log->conversation_id,
                    'Hash' => NULL
                ]),
                CURLOPT_HTTPHEADER => array(
                    "AppId: " . $paymentMethodAPIDetails->app_id,
                    "AppSecret: " . $paymentMethodAPIDetails->app_secret,
                    "Content-Type: application/json"
                ),
            ));
            $_apiResponse = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            $apiResponse = json_decode($_apiResponse);

            print_r($apiResponse);
            exit;

            if (count($apiResponse->ErrorMessages) == 0) {

                if ($apiResponse->Success == TRUE) {
                    $this->db->query("UPDATE users SET balance = balance + ? WHERE id = ?", [
                        $log->price,
                        $log->user_id
                    ]);
                }

                $this->db->update('payment_log', [
                    'price' => $log->price,
                    'paid_price' => ($apiResponse->Price / 100),
                    'json' => json_encode($_POST),
                    'is_active' => 1
                ], [
                    'id' => $log->id
                ]);

            }

            //echo 'OK';
            return;
        }

        redirect('odeme-yontemleri');
    }

}