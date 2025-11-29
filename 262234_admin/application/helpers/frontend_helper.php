<?php

function getSiteLogo() {
    $CI = &get_instance();
    $configLogo = $CI->db->where([
        'id' => 1
    ])->get('config')->row()->logo_image_url;
    if (!empty($configLogo))
        return orj_site_url('public/theme/' . $configLogo);
    else
        return orj_site_url('assets/dist/images/logo.png');
}

function orderStatus($order_status, $return_type = null){
    $status = null;
    switch($order_status){
        default:
        case 0:
            $badge_class = "warning";
            $status = "Beklemede";
        break;
        case 1:
            $badge_class = "warning";
            $status = "Hazırlanıyor";
        break;
        case 2:
            $badge_class = "success";
            $status = "Teslim Edildi";
        break;
        case 3:
            $badge_class = "danger";
            $status = "İptal Edildi";
        break;
    }
    if($return_type == "badge"){
        return '<div class="badge badge-' . $badge_class . '">' . $status . '</div>';
    }else{
        return $status;
    }
}

function orderStatusGameMoneys($order_status, $return_type = null){
    $status = null;
    switch($order_status){
        default:
        case 0:
            $badge_class = "warning";
            $status = "Beklemede";
        break;
        case 1:
            $badge_class = "warning";
            $status = "Karakter Oyuna Giriyor";
        break;
        case 2:
            $badge_class = "success";
            $status = "Teslim Alındı";
        break;
        case 3:
            $badge_class = "danger";
            $status = "İptal Edildi";
        break;
    }
    if($return_type == "badge"){
        return '<div class="badge badge-' . $badge_class . '">' . $status . '</div>';
    }else{
        return $status;
    }
}

function get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function orj_site_url($thing){
    return "https://epinom.net/" . $thing;
}