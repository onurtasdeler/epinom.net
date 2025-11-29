<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error404 extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        if(!getActiveUser()){
			redirect("login");
			exit;
		}
    }

    function index(){
        $this->load->view("error404");
    }

}