<?php

function XMLPOST($PostAddress, $xmlData){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$PostAddress);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);
    $result = curl_exec($ch);
    return $result;
}

function sendSMS($numbers, $message = null){
    $CI = &get_instance();
    $config = $CI->db->where('id=1')->get('config')->row();
    if($config->is_sms_active == 1) {
        if(!empty($message)):
            $xml='<?xml version="1.0" encoding="UTF-8"?>
            <mainbody>
            <header>
            <company dil="TR">Netgsm</company>        
            <usercode>' . $config->sms_username . '</usercode>
            <password>' . $config->sms_password . '</password>
            <type>1:n</type>
            <msgheader>' . $config->sms_heading . '</msgheader>
            </header>
            <body>
            <msg>
            <![CDATA[' . $message . ']]>
            </msg>';
            if(is_array($numbers)){
                foreach($numbers as $n):
                    $xml .= '<no>' . $n . '</no>';
                endforeach;
            }else{
                $xml .= '<no>' . $numbers . '</no>';
            }
            $xml .= '</body>
            </mainbody>';
            $result = XMLPOST('https://api.netgsm.com.tr/sms/send/xml', $xml);
            return $result;
        endif;
        return false;
    }
}