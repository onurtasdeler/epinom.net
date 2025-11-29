<?php

class Balancewithdrawrequests extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if(!getActiveUser()){
            redirect("login");
            exit;
        }
    }

    function index()
    {
        $this->list();
    }

    function list(){
        $rows = $this->db->get('balance_withdraw_requests')->result();
        if(isset($_GET["get_pending"])){
            $rows = $this->db->where([
                "status" => 0
            ])->get('balance_withdraw_requests')->result();
        }
        if(isset($_GET["user_id"])){
            $rows = $this->db->where([
                "user_id" => $this->input->get("user_id", TRUE)
            ])->get('balance_withdraw_requests')->result();
        }
        $viewData = [
            "rows" => $rows
        ];
        $this->load->view("pages/balancewithdrawrequests/list", (object)$viewData);
    }

    function process($pn_id = NULL){
        if($pn_id){
            $notification = $this->db->where([
                'id' => $pn_id
            ])->get('balance_withdraw_requests')->row();
            if(isset($notification->id)):
                if(isset($_GET['processing'])){
                    $this->db->update('balance_withdraw_requests', [
                        'status' => 3
                    ], [
                        'id' => $pn_id
                    ]);
                }
                if(isset($_GET['accept'])){
                    $this->db->update('balance_withdraw_requests', [
                        'status' => 1
                    ], [
                        'id' => $pn_id
                    ]);
                    /*$this->db->query("UPDATE users SET balance = balance - ? WHERE id = ?", [
                        $notification->amount,
                        $notification->user_id
                    ]);*/
                }
                if(isset($_GET['decline'])){
                    $this->db->update('balance_withdraw_requests', [
                        'status' => 2
                    ], [
                        'id' => $pn_id
                    ]);
                    if($notification->status != 2){
                        $this->db->query("UPDATE users SET balance = balance + ? WHERE id = ?", [
                            $notification->amount,
                            $notification->user_id
                        ]);
                    }
                }
            endif;
        }
        redirect('balancewithdrawrequests');
    }

}