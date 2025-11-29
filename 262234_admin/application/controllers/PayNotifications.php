<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PayNotifications extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        if(!getActiveUser()){
			redirect("login");
			exit;
		}
    }

    function index(){
        $this->list();
    }

    function list(){
        $rows = $this->db->order_by('id','desc')->get('payment_notifications')->result();
        if(isset($_GET["get_pending"])){
            $rows = $this->db->where([
                "status" => 0 
            ])->order_by('id','desc')->get('payment_notifications')->result();
        }
        if(isset($_GET["user_id"])){
            $rows = $this->db->where([
                "user_id" => $this->input->get("user_id", TRUE)
            ])->get('payment_notifications')->result();
        }
        $viewData = [
            "rows" => $rows
        ];
        $this->load->view("pages/paynotifications/list", (object)$viewData);
    }

    function process($pn_id = null){
        if($pn_id){
            $notification = $this->db->where([
                'id' => $pn_id
            ])->get('payment_notifications')->row();
            $user = $this->db->where([
                'id'=>$notification->user_id
            ])->get('users')->row();
            if(isset($notification->id)):
                if(isset($_GET['accept'])){
                    $this->db->update('payment_notifications', [
                        'status' => 1
                    ], [
                        'id' => $pn_id
                    ]);
                    $this->db->query("UPDATE users SET balance = balance + '" . $notification->price . "' WHERE id = '" . $notification->user_id . "'");
                    sendSMS($user->phone_number,"EpinDenizi üzerinden yapmış olduğunuz ödeme bildirimi onaylanmıştır.Hesabınıza {$notification->price} AZN Bakiye Eklenmiştir.");
                }
                if(isset($_GET['decline'])){
                    $this->db->update('payment_notifications', [
                        'status' => 2
                    ], [
                        'id' => $pn_id
                    ]);
                    if($notification->status == 1){
                        $this->db->query("UPDATE users SET balance = balance - '" . $notification->price . "' WHERE id = '" . $notification->user_id . "'");
                        sendSMS($user->phone_number,"EpinDenizi üzerinden yapmış olduğunuz ödeme bildirimi iptal edilmiştir.Hesabınızdan {$notification->price} AZN Bakiye Silinmiştir.");
                    } else{
						sendSMS($user->phone_number,"EpinDenizi üzerinden yapmış olduğunuz ödeme bildirimi iptal edilmiştir.");
                    }
                }
            endif;
        }
        redirect('paynotifications');
    }

}
