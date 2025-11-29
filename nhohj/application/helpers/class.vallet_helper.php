<?php
class Vallet
{
    private $userName,$password,$shopCode,$hash;
    public function __construct($userName,$password,$shopCode,$hash)
    {
        $this->userName = $userName;
        $this->password = $password;
        $this->shopCode = $shopCode;
        $this->hash = $hash;
    }
    private function hash_generate($string)
    {
        $hash = base64_encode(pack('H*',sha1($this->userName.$this->password.$this->shopCode.$string.$this->hash)));
        return $hash;
    }
    public function create_payment_link($order_data,$okurl="",$failurl="")
    {
        $post_data = array(
            'userName' => $this->userName,
            'password' => $this->password,
            'shopCode' => $this->shopCode,
            'productName' => $order_data['productName'],
            'productData' => $order_data['productData'],
            'productType' => $order_data['productType'],
            'productsTotalPrice' => $order_data['productsTotalPrice'],
            'orderPrice' => $order_data['orderPrice'],
            'currency' => $order_data['currency'],
            'orderId' => $order_data['orderId'],
            'locale' => $order_data['locale'],
            'conversationId' => $order_data['conversationId'],
            'buyerName' => $order_data['buyerName'],
            'buyerSurName' => $order_data['buyerSurName'],
            'buyerGsmNo' => $order_data['buyerGsmNo'],
            'buyerIp' => $order_data['buyerIp'],
            'buyerMail' => $order_data['buyerMail'],
            'buyerAdress' => $order_data['buyerAdress'],
            'buyerCountry' => $order_data['buyerCountry'],
            'buyerCity' => $order_data['buyerCity'],
            'buyerDistrict' => $order_data['buyerDistrict'],
            'callbackOkUrl' => $okurl,
            'callbackFailUrl' => $failurl,
            'module'=>'NATIVE_PHP'
        );
        $post_data['hash'] = $this->hash_generate($post_data['orderId'].$post_data['currency'].$post_data['orderPrice'].$post_data['productsTotalPrice'].$post_data['productType'].$post_data['callbackOkUrl'].$post_data['callbackFailUrl']);

        $response = $this->send_post('https://www.vallet.com.tr/api/v1/create-payment-link',$post_data);
        if ($response['status']=='success' && isset($response['payment_page_url']))
        {
            return array("st" => "success","veri" => $response);
        }
        else
        {
            return array("st" => "error","veri" => $response);
        }
    }
    private function send_post($post_url,$post_data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$post_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1) ;
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_REFERER, $_SERVER['SERVER_NAME']);
        $result_origin = curl_exec($ch);
        $response = array();
        if (curl_errno($ch))
        {
            /*Curl sırasında bir sorun oluştu*/
            $response = array(
                'status'=>'error',
                'errorMessage'=>'Curl Geçersiz bir cevap aldı',
            );
        }
        else
        {
            /*Curl Cevabını Alın*/

            /*Curl Cevabını jsondan array'a dönüştür*/
            $result = json_decode($result_origin,true);
            if (is_array($result))
            {
                $response = (array) $result;
            }
            else
            {
                $response = array(
                    'status'=>'error',
                    'errorMessage'=>'Dönen cevap Array değildi',
                );
            }
        }
        curl_close($ch);
        return $response;
    }
}
?>