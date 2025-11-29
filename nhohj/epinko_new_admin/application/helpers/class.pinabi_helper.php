<?php
class PinAbi
{
    public $api_url = 'https://api.pinabi.com/api';
    public $apiUser = '';
    public $secretKey = '';
	public $Authorization = '';

	function get_auth_data(){
		$t=&get_instance();
        $t->load->model("m_tr_model");
        $cek=$t->m_tr_model->getTableSingle("table_integration",array("id" => 2));

		return [
			'apiUser' => $cek->username,
			'secretKey' => $cek->password,
			'Authorization' => $cek->authkey,
		];
	}
	
    function Curl($address, $header, $data, $post = false)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $address);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			if ($post){
            	curl_setopt($ch, CURLOPT_POST, 1);
            	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			}
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				"apiUser: ".$header['apiUser'],
				"secretKey: ".$header['secretKey'],
				"Authorization: Basic ". $header['Authorization'],
				"X-Forwarded-For: 213.238.179.156",
				"Content-Type:application/json"
			]);
            return curl_exec($ch);
        }catch (Exception $ex){
            return false;
        }

    }
    function send($param = NULL, $header = NULL, $data = [], $post = false)
    {
        $l = $this->Curl($this->api_url . $param, $header, $data, $post);
        if($l){
            return $l;
        }else{
            return false;
        }
    }

    function returnData($result)
    {
       return $result;
    }

    function getBalance()
    {
        $t=&get_instance();
        $t->load->model("m_tr_model");
        $cek=$t->m_tr_model->getTableSingle("table_integration",array("id" => 2));
        if($cek->status==1 && $cek->username!="" && $cek->password!=""){
            $result = $this->send('/getBalance', $this->get_auth_data());
            return json_decode($result, true)['balances'];
        }
    }
	
	function getAllCategoriesAndProducts()
	{
		$t=&get_instance();
        $t->load->model("m_tr_model");
        $cek=$t->m_tr_model->getTableSingle("table_integration",array("id" => 2));
        if($cek->status==1 && $cek->username!="" && $cek->password!=""){
            $result = $this->send('/getAllCategoriesAndProducts', $this->get_auth_data());
            return json_decode($result, true);
        }
	}
	
	function getAllCategoriesAndProductsByType($type)
	{
		$t=&get_instance();
        $t->load->model("m_tr_model");
        $cek=$t->m_tr_model->getTableSingle("table_integration",array("id" => 2));
        if($cek->status==1 && $cek->username!="" && $cek->password!=""){
            $result = $this->send('/getAllCategoriesAndProductsByType', $this->get_auth_data(), json_encode(['type'=>$type]), true);
            return json_decode($result, true);
        }
	}
	
	function getProductImage($product_id){
		$t=&get_instance();
        $t->load->model("m_tr_model");
        $cek=$t->m_tr_model->getTableSingle("table_integration",array("id" => 2));
        if($cek->status==1 && $cek->username!="" && $cek->password!=""){
            $result = $this->send('/getAllCategoriesAndProducts', $this->get_auth_data());
            $games = json_decode($result, true)['gameList'];
			foreach($games as $game){
				foreach($game['productList'] as $product){
					if ($product['id'] == $product_id){
						return $product['imageUrl'];
						break;
					}
				}
			}
        }
	}
	
}