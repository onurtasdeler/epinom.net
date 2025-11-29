<?php

function getCategoryUpCategories($category, $data = []){
    $CI = &get_instance();
    $data[] = $category;
    if ($category->up_category_id > 0) {
        $upCategory = $CI->db->where('id', $category->up_category_id)->get('categories')->row();
        return getCategoryUpCategories($upCategory, $data);
    } else {
        return $data;
    }
}

function calculateRefSystemLimit($current_count, $limit = 250) {
    return $limit;
}

function headAnnouncements(){
    $CI = &get_instance();
    $announcements = $CI->db->where([
        'is_active' => 1
    ])->get('announcements')->result();

    return $announcements;
}

function refSystemCodeRequestIsAvaiable($current_count, $user){
    $CI = &get_instance();
    $ref_user = $CI->db->where([
        'user_id' => $user->id
    ])->get('reference_system_users')->row();
    $limit = calculateRefSystemLimit($current_count);
    if ($current_count >= $limit) {
        if ( (getLoggedInUser()->ref_points/250) >= 1 ) {
            return TRUE;
        }
    }
    return FALSE;
}

function image_url($request) {
    return base_url('public/' . $request);
}

function assets_url($request) {
    return base_url('assets/' . $request);
}

function productImage($product, $category) {
    if (file_exists('public/categories/' . $product->image_url) && !empty($product->image_url)) {
        return $product->image_url;
    } else {
        return $category->image_url;
    }
}

function getSiteLogo() {
    $CI = &get_instance();
    $configLogo = $CI->db->where([
        'id' => 1
    ])->get('config')->row()->logo_image_url;
    if (!empty($configLogo))
        return image_url('theme/' . $configLogo);
    else
        return base_url('assets/dist/images/logo.png');
}

function getConfig($request = NULL){
    $CI = &get_instance();
    if ($request) {
        return $CI->db->where([
            'id' => 1
        ])->get('config')->row()->$request;
    } else {
        return $CI->db->where([
            'id' => 1
        ])->get('config')->row();
    }
}

function getOtherSlider($slide_area = 1){
    $CI = &get_instance();
    return $CI->db->where([
        "is_active" => 1,
        "slide_area" => $slide_area
    ])->order_by('rank ASC, id DESC')->get('slider')->result();
}

function getFooterPopularCategories($limit = 6) {
    $CI = &get_instance();
    return $CI->db->limit($limit)->where([
        'is_popular' => 1,
        'is_active' => 1
    ])->get('categories')->result();
}

function menuCategories(){
    $CI = &get_instance();
    $CI->load->model("categories");
    return $CI->categories->getAll([
        "is_menu" => 1
    ], 5);
}

function getFooterScripts(){
    $CI = &get_instance();
    $CI->load->model("settings");
    return $CI->settings->getOne("footer_script");
}

function getSiteTitle(){
    $CI = &get_instance();
    $CI->load->model("settings");
    return $CI->settings->getOne("site_title");
}

function getSocialMediaData($name = null){
    $CI = &get_instance();
    if($name == null)
        return $CI->db->where([
            'is_active' => 1
        ])->get("social_media")->result();
    else
        return $CI->db->where([
            'is_active' => 1,
            'name' => ucwords($name)
        ])->get("social_media")->row();
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