<?php

class Notifications extends CI_Controller
{

    function __construct(){
        parent::__construct();
        if(!getActiveUser()) {
            echo "0";
            die();
        }
    }
    function count($user_id)
    {
        $this->db->where("user_id",$user_id);
        $this->db->where("is_viewed",0);
        $count = $this->db->count_all_results('notifications');
        echo $count;
    }
}