<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Turkpin
{

    protected $CI;

    public $api_url = 'https://www.turkpin.com/api.php';
    public $username = '';
    public $password = '';
    function __construct() {
        $this->CI=&get_instance();
        $config = $this->CI->db->where('method_name','Turkpin')->get('seller_integrations')->row();
        $credentials = json_decode($config->api_json, true);
        $this->username = $credentials['username'];
        $this->password = $credentials['password'];
    }
    function newEpinOrder($gameCode, $productCode, $qty, $character = NULL)
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>
            <APIRequest>
                <params>
                    <cmd>epinSiparisYarat</cmd>
                    <username>' . $this->username . '</username>
                    <password>' . $this->password . '</password>
                    <oyunKodu>' . $gameCode . '</oyunKodu>
                    <urunKodu>' . $productCode . '</urunKodu>
                    <adet>' . $qty . '</adet>
                    <character>' . $character . '</character>
                </params>
            </APIRequest>';
        return $this->send($xml)->params;
    }

    function getEpinGameList()
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>
            <APIRequest>
                <params>
                    <cmd>epinOyunListesi</cmd>
                    <username>' . $this->username . '</username>
                    <password>' . $this->password . '</password>
                </params>
            </APIRequest>';
        $result = $this->returnData(
            $this->send($xml)
        );
        if ($result == FALSE)
            return FALSE;
        else
            return $result->oyunListesi->oyun;
    }

    function getEpinProductList($gameCode)
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>
            <APIRequest>
                <params>
                    <cmd>epinUrunleri</cmd>
                    <username>' . $this->username . '</username>
                    <password>' . $this->password . '</password>
                    <oyunKodu>' . $gameCode . '</oyunKodu>
                </params>
            </APIRequest>';
        $result = $this->returnData(
            $this->send($xml)
        );
        if ($result == FALSE)
            return FALSE;
        else
            return $result->epinUrunListesi->urun;
    }

    function returnData($result) {
        if (isset($result->params)) {
            if ($result->params->error == '000')
                return $result->params;
            else
                return FALSE;
        } else {
            return FALSE;
        }
    }

    function send($xml = NULL)
    {
        $l = $this->_curl($this->api_url, 'DATA=' . $xml);
        $xml = new SimpleXMLElement($l);
        return json_decode(json_encode($xml));
    }

    function _curl($address, $xml)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $address);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        return curl_exec($ch);
    }

}