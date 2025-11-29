<?php
class Pre_system_hook {

    public function initialize() {
        $CI =& get_instance();
        $uri = $_SERVER['REQUEST_URI'];
        if (strpos($uri, 'callback/payguru') !== false) {
            $CI->config->set_item('enable_query_strings', TRUE);
        } else {
            $CI->config->set_item('enable_query_strings', FALSE);
        }
    }
}
