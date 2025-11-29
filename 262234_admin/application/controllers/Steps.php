<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Steps extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        if(!getActiveUser()){
			redirect("login");
			exit;
		}
    }

    function index(){
        $steps = $this->db->get('user_steps')->result();
        if(isset($_GET['user_id'])):
            $steps = $this->db->where([
                'user_id' => $this->input->get('user_id', TRUE)
            ])->get('user_steps')->result();
        endif;

        $viewData = [
            "steps" => $steps
        ];
        $this->load->view('pages/steps/list', (object)$viewData);
    }

}
