<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pinabi
{

    protected $CI;

    public $api_url = 'https://api.pinabi.com/api/';
    public $username = '';
    public $secret_key = '';
    public $auth_key = '';
    function __construct() {
        $this->CI=&get_instance();
        $config = $this->CI->db->where('method_name','Pinabi')->get('seller_integrations')->row();
        $credentials = json_decode($config->api_json, true);
        $this->username = $credentials['username'];
        $this->secret_key = $credentials['secretKey'];
        $this->auth_key = $credentials['authKey'];
    }
    function productList() {
        return json_decode($this->getResult('getAllCategoriesAndProducts'))->gameList;
    }
    function productsByType($type) {
        echo $this->getResult('getAllCategoriesAndProductsByType',"POST",["type"=>$type]);
    }
    function getResult($method,$type="GET",$parameters=[]) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url.$method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, ($type == "POST" ?1:0));
        if($type== "POST") {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'apiUser: '.$this->username,
            'secretKey: '.$this->secret_key,
            'Authorization: Basic '.$this->auth_key,
            'Content-Type: application/json'
        ]);
        return curl_exec($ch);
    }
}