<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	
	public function __construct(){
		parent::__construct();
		if(!getActiveUser()){
			redirect("login");
			exit;
		}
	}
	public function index()
	{
		$viewData = [
			"waitingOrders" => $this->db->query("SELECT * FROM orders WHERE status = '0'")->result(),
			"users" => $this->db->query("SELECT * FROM users")->result(),
			"helpRequests" => $this->db->query("SELECT * FROM help_desk")->result(),
			"waitingHelpRequests" => $this->db->query("SELECT * FROM help_desk WHERE is_active = 1 AND is_cancel = 0")->result(),
            "attributionJobs" => $this->db->get('attribution_jobs')->num_rows(),
            "waitingGMMenuCount" => $this->db->where('status=0')->get('game_moneys_orders')->num_rows() + $this->db->where('status=0')->get('game_moneys_selltous')->num_rows(),
            "waitingBWRMenuCount" => $this->db->query("SELECT * FROM balance_withdraw_requests WHERE status = 0")->num_rows(),
            "waitingOrdersMenuCount" => $this->db->query("SELECT * FROM orders WHERE status = '0'")->num_rows()
		];

        if ($viewData['waitingGMMenuCount']>0 || $viewData['waitingBWRMenuCount']>0 || $viewData['waitingOrdersMenuCount']>0) {
            $viewData['playSound'] = TRUE;
        }

		$this->load->view("main", (object)$viewData);
	}
}
