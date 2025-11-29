<?php

function sendEmail($to, $subject, $message){
    $CI = &get_instance();
    $websiteConfig = $CI->db->where(['id'=>1])->get('config')->row();

    if($websiteConfig->is_email_active == 1){

        $config['protocol']  = 'smtp';
        $config['smtp_host'] = $websiteConfig->email_smtp_host;
        $config['smtp_user'] = $websiteConfig->email_smtp_user;
        $config['smtp_pass'] = $websiteConfig->email_smtp_password;
        $config['smtp_port'] = $websiteConfig->email_smtp_port;
        $config['mailtype']  = 'html';

        $CI->load->library('email', $config);

        $CI->email->from($websiteConfig->email_address, $websiteConfig->email_from);
        $CI->email->to($to);
        $CI->email->subject($subject);
        $CI->email->message($message);

        if( !$CI->email->send()) {
            echo $CI->email->print_debugger();
            exit;
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

function getEmailTemplate($section, $stateArray = array()){
    $templatesFolder = orj_site_url('email_templates');
    switch($section){
        case "order":
            switch($stateArray['status']){
                case 1:
                    $file = file_get_contents($templatesFolder . '/order/waiting.html');
                    $file = str_replace('{{@order_process_no}}', $stateArray['process_no'], $file);
                    $file = str_replace('{{@user_orders_page}}', $stateArray['user_orders_page'], $file);
                    return $file;
                break;
                case 2:
                    $file = file_get_contents($templatesFolder . '/order/success.html');
                    $file = str_replace('{{@order_process_no}}', $stateArray['process_no'], $file);
                    $file = str_replace('{{@user_orders_page}}', $stateArray['user_orders_page'], $file);
                    return $file;
                break;
                case 3:
                    $file = file_get_contents($templatesFolder . '/order/canceled.html');
                    $file = str_replace('{{@order_process_no}}', $stateArray['process_no'], $file);
                    $file = str_replace('{{@user_orders_page}}', $stateArray['user_orders_page'], $file);
                    return $file;
                break;
            }
        break;
        case "orderGift":
            $file = file_get_contents($templatesFolder . '/order/gift.html');
            $codes_string = NULL;
            $CI = &get_instance();
            $codes = $CI->db->where([
                'order_id' => $stateArray['order_id']
            ])->get('stock_pool')->result();
            foreach($codes as $_code) {
                $_code->product = $CI->db->where(['id' => $_code->product_id])->get('products')->row();
                $codes_string .= '<div style="margin-bottom:7px;"><strong>' . $_code->product->product_name . '</strong>: <span>' . $_code->code . '</span></div>';
            }
            $file = str_replace('{{@codes}}', $codes_string, $file);
            $file = str_replace('{{@sender}}', $CI->db->where('id', $codes[0]->user_id)->get('users')->row()->email, $file);
            return $file;
        break;
        case "helpdesk":
            $file = file_get_contents($templatesFolder . '/helpdesk/received_message.html');
            $file = str_replace('{{@help_code}}', $stateArray['help_code'], $file);
            $file = str_replace('{{@message}}', $stateArray['message'], $file);
            $file = str_replace('{{@user_helpdesk_page}}', $stateArray['user_helpdesk_page'], $file);
            return $file;
        break;
        case "user_activation":
            $file = file_get_contents($templatesFolder . '/user_activation/activation_mail.html');
            $file = str_replace('{{@activation_code}}', $stateArray['activation_code'], $file);
            $file = str_replace('{{@activation_url}}', $stateArray['activation_url'], $file);
            return $file;
        break;
    }
}
