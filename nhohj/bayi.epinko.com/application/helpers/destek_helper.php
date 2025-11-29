<?php
    function destek_mesaj_cek($talep_id){
        $t=&get_instance();
        $t->load->model("makale_backend_model");
        $getir=$t->makale_backend_model->query("select * from ft_users_destek_chat where talep_id='".$talep_id."' order by cevap_date asc");
        if($getir){
            return $getir;
        }else{
            return false;
        }
    }

    function gecen_sure($tarih)
    {
        $time_difference = time() - $tarih;
        $seconds = $time_difference;
        $minutes = round($time_difference / 60);
        $hours = round($time_difference / 3600);
        $days = round($time_difference / 86400);
        $weeks = round($time_difference / 604800);
        $months = round($time_difference / 2419200);
        $years = round($time_difference / 29030400);
        // Seconds
        if ($seconds <= 60) {
            return  "$seconds saniye önce";
        } else if ($minutes <= 60) {
            if ($minutes == 1) {
                return "1 dakika önce";
            } else {
                return "$minutes dakika önce";
            }
        } else if ($hours <= 24) {
            if ($hours == 1) {
                return "1 saat önce";
            } else {
                return "$hours saat önce";
            }
        } else if ($days <= 7) {
            if ($days == 1) {
                return "1 gün önce";
            } else {
                return "$days gün önce";
            }
        } else if ($weeks <= 4) {
            if ($weeks == 1) {
                return "1 hafta önce";
            } else {
                return "$weeks hafta önce";
            }
        } else if ($months <= 12) {
            if ($months == 1) {
                return "1 ay önce";
            } else {
                return "$months ay önce";
            }
        } else {
            if ($years == 1) {
                return "1 yıl önce";
            } else {
                return "$years yıl önce";
            }
        }
    }



?>