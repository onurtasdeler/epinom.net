<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paymentlog extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        if(!getActiveUser()){
            redirect("login");
            exit;
        }
    }

    function Index(){
        $viewData = [
            'logs' => $this->db->get('payment_log')->result()
        ];
        $this->load->view('pages/paymentlog/index', (object)$viewData);
        return;
    }

}
