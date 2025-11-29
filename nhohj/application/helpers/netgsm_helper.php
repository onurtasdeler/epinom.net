<?php

function smsGonder($gsm, $mesaj)
{
    $t = &get_instance();
    $t->load->model("m_tr_model");
    $t->load->helper("functions_helper");

    $ayarCek = getTableSingle("table_options_sms", ["modul_aktif" => 1]);

    $username = $ayarCek->user;
    $pass = $ayarCek->pass;
    $header = $ayarCek->header;

    $gsm = trim(str_replace([" ", "-", ")", "("], "", $gsm));
    $vatanmsg = $mesaj;
    $mesaj = str_replace(" ", "%20", $mesaj);


    if ($ayarCek->name == 'Netgsm') {
        $url = "https://api.netgsm.com.tr/bulkhttppost.asp?usercode=$username&password=$pass&gsmno=+90$gsm&message=$mesaj&msgheader=$header&dil=TR";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        $pars = explode(" ", $output);
        $adet = ceil(strlen($mesaj) / 150);

        if ($pars[0] === "00" || $pars[0] === "02") {
            $t->m_tr_model->add_new([
                "number" => $gsm,
                "message" => $mesaj,
                "ip" => $_SERVER["REMOTE_ADDR"],
                "created_at" => date("Y-m-d"),
                "status" => 1,
                "karakter" => strlen($mesaj),
                "adet" => $adet,
                "response" => $output
            ], "sms_log");
            return true;
        }

        return $output;
    } else if ($ayarCek->name == 'VatanSMS') {
        $curl = curl_init();

        $params = [
            'api_id' => $username,
            'api_key' => $pass,
            'sender' => $header,
            'message_type' => 'normal',
            'message' => $vatanmsg,
            'message_content_type' => 'bilgi',
            'phones' => [$gsm]
        ];

        $curl_options = [
            CURLOPT_URL => 'https://api.vatansms.net/api/v1/1toN',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ]
        ];

        curl_setopt_array($curl, $curl_options);

        $response = curl_exec($curl);

        curl_close($curl);

        if ($response) {
            $response = json_decode($response, true);
            if ($response['status'] == 'success') {
                return true;
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
}
