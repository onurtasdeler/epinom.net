<?php
class TurkPin
{
    public $api_url = 'https://www.turkpin.com/api.php';
    public $username = '';
    public $password = '';

    function Curl($address, $xml)
    {
        try {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $address);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
            return curl_exec($ch);
        }catch (Exception $ex){
           return false;
        }

    }
    function send($xml = NULL)
    {
        $l = $this->Curl($this->api_url, 'DATA=' . $xml);
        if($l){
            $xml = new SimpleXMLElement($l);
            return json_decode(json_encode($xml));
        }else{
            return false;
        }

    }

    function returnData($result)
    {
        if (isset($result->params))
        {
            if ($result->params->error == '000')
            {
                return $result->params;
            }
            else
            {
                return FALSE;
            }
        } else
        {
            return FALSE;
        }
    }

    function siparisVer($oyun, $urun, $adet, $character = NULL)
    {
        $t=&get_instance();
        $t->load->model("m_tr_model");
        $cek=$t->m_tr_model->getTableSingle("table_integration",array("id" => 1));
        if($cek->status==1 && $cek->username!="" && $cek->password!=""){
            $xml = '<?xml version="1.0" encoding="utf-8"?>
            <APIRequest>
                <params>
                    <cmd>epinSiparisYarat</cmd>
                    <username>' . $cek->username . '</username>
                    <password>' . $cek->password . '</password>
                    <oyunKodu>' . $oyun . '</oyunKodu>
                    <urunKodu>' . $urun . '</urunKodu>
                    <adet>' . $adet . '</adet>
                    <character>' . $character . '</character>
                </params>
            </APIRequest>';
            $eX=$this->send($xml);
            if($eX){
                return $eX->params;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }
    function oyunListesi()
    {
        try {
            $t=&get_instance();
            $t->load->model("m_tr_model");
            $cek=$t->m_tr_model->getTableSingle("table_integration",array("id" => 1));
            if($cek->status==1 && $cek->username!="" && $cek->password!=""){
                $xml = '<?xml version="1.0" encoding="utf-8"?>
            <APIRequest>
                <params>
                    <cmd>epinOyunListesi</cmd>
                    <username>' . $cek->username . '</username>
                    <password>' . $cek->password . '</password>
                </params>
            </APIRequest>';

                $result = $this->returnData($this->send($xml));
                if ($result == FALSE)
                {
                    return FALSE;
                }else
                {
                    return $result->oyunListesi->oyun;
                }
            }else{
                return FALSE;
            }

        }catch (Exception $ex){
            return FALSE;
        }

    }

    function urunListesi($oyunkodu)
    {
        try {
            $t=&get_instance();
            $t->load->model("m_tr_model");
            $cek=$t->m_tr_model->getTableSingle("table_integration",array("id" => 1));
            if($cek->status==1 && $cek->username!="" && $cek->password!=""){
                    $xml = '<?xml version="1.0" encoding="utf-8"?>
                <APIRequest>
                    <params>
                        <cmd>epinUrunleri</cmd>
                        <username>' . $cek->username . '</username>
                        <password>' . $cek->password . '</password>
                        <oyunKodu>' . $oyunkodu . '</oyunKodu>
                    </params>
                </APIRequest>';
                    $result = $this->returnData($this->send($xml));
                    if ($result == FALSE)
                    {
                        return FALSE;
                    }
                    else
                    {
                        return $result->epinUrunListesi->urun;
                    }
            }

        }catch (Exception $ex){
            return false;
        }
    }
    function getBalance()
    {
        $t=&get_instance();
        $t->load->model("m_tr_model");

        $cek=$t->m_tr_model->getTableSingle("table_integration",array("id" => 1));
        if($cek->status==1 && $cek->username!="" && $cek->password!=""){
            $xml = '<?xml version="1.0" encoding="utf-8"?>
                    <APIRequest>
                        <params>
                            <cmd>balance</cmd>
                            <username>' . $cek->username . '</username>
                            <password>' . $cek->password . '</password>
                        </params>
                    </APIRequest>
                ';
            $result = $this->send($xml);

            if($result->params->HATA_NO=="000"){
                return $result->params->balanceInformation->balance;
            }else{
                return FALSE;
            }


        }


    }


    function TurkpinData()
    {
        $t=&get_instance();
        $t->load->model("m_tr_model");
        $cek=$t->m_tr_model->getTableSingle("table_integration",array("id" => 1));

        $xml = '<APIRequest>
					<params>
						<cmd>balance</cmd>
						 <username>' . $cek->username . '</username>
                            <password>' . $cek->password . '</password>
					</params>
            	</APIRequest>';
        return $this->send($xml)->params;

    }


}