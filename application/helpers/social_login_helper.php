<?php

function getFacebookLoginUrl(){
    $CI = &get_instance();
    $wConfig = $CI->db->where('id=1')->get('config')->row();
    if($wConfig->facebook_app_id && $wConfig->facebook_app_secret && $wConfig->facebook_graph_version){
        $fb = new \Facebook\Facebook([
            'app_id' => $wConfig->facebook_app_id,
            'app_secret' => $wConfig->facebook_app_secret,
            'default_graph_version' => $wConfig->facebook_graph_version
        ]);
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'user_gender'];
        $loginUrl = $helper->getLoginUrl(base_url('api/login/fb-callback'), $permissions);
        return htmlspecialchars($loginUrl);
    }
    return 'javascript:void(0);';
}