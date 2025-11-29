<?php

function insertUserStep($user_id, $action, $array = array()){
    $CI = &get_instance();
    $CI->load->model('steps_model');
    $insertId = $CI->steps_model->insertUserStep([
        'user_id' => $user_id,
        'action' => $action,
        'json' => json_encode($array)
    ]);
    if($insertId)
        return TRUE;
    else
        return FALSE;
}