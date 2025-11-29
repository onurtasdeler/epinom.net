<?php
function smsGonder($gsm, $mesaj)
{

    $t=&get_instance();
    $t->load->model("m_tr_model");
    $t->load->helper("functions_helper");
    $ayarCek=$t->m_tr_model->getTableSingle("table_options_sms",array("id" => 1));
    //print_r($ayarCek);
    $username = $ayarCek->user;
    $pass = $ayarCek->pass;
    $header = $ayarCek->header;
    $notemizle=trim(str_replace(" ","",str_replace("-","",str_replace(")","",str_replace("(","",$gsm)))));
    $gsm=$notemizle;
    //echo $gsm;

    $telefonbas =substr($gsm,0,3);

    $startdate = date('d.m.Y H:i');
    $startdate = str_replace('.', '', $startdate);
    $startdate = str_replace(':', '', $startdate);
    $startdate = str_replace(' ', '', $startdate);
    $stopdate = date('d.m.Y H:i', strtotime('+1 day'));
    $stopdate = str_replace('.', '', $stopdate);
    $stopdate = str_replace(':', '', $stopdate);
    $stopdate = str_replace(' ', '', $stopdate);
    $mesaj = str_replace(" ","%20",$mesaj).".B12".rand(1,1000);
    $url = "https://api.netgsm.com.tr/bulkhttppost.asp?usercode=$username&password=$pass&gsmno=+90$gsm&message=$mesaj&msgheader=$header&dil=TR";
    //echo $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //  curl_setopt($ch,CURLOPT_HEADER, false);
    $output = curl_exec($ch);
    $pars=explode(" ",$output);
    curl_close($ch);
    $adet=strlen($mesaj)/150;
    $adet=explode(".",$adet);
    $adet=$adet[0];
    if($adet==0){
        $adet=1;
    }

    //echo $output;

    if($pars[0]=="00" || $pars[0]=="02"){

        $ekle=$t->m_tr_model->add_new(array(
            "number" => $gsm,
            "message" => $mesaj,
            "ip" => $_SERVER["REMOTE_ADDR"],
            "created_at" => date("Y-m-d"),
            "status" => 1,
            "karakter" => strlen($mesaj),
            "adet" => $adet,
            "response" => $output
        ),"sms_log");
        $guncelle=$t->m_tr_model->getTableSingle("sms_paketler",array("id" => 1));
        if($guncelle){
            $guncelle=$t->m_tr_model->updateTable("sms_paketler",array("kalan" => ($guncelle->kalan-$adet)),array("id" => 1));

        }
    }


    return $output;
}
?>