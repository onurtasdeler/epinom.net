<?php

class Order extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        $this->load->model("orders_model");
        $this->load->model("users_model");
        if(!getActiveUser()){
			redirect("login");
			exit;
		}
    }

    function index($order_id){
        $order = $this->orders_model->getOne([
            "id" => $order_id
        ]);
        if(isset($order->id)){
            $order->gain_price = $order->total_price - $order->total_arrival_price - $order->minus_gain;
            
            $query = $this->db->query("SELECT IFNULL(SUM(return_price),0) as total_return FROM sms_return WHERE process_no=?",[
                $order->process_no
            ]);
            $result = $query->row();
            $order->total_refund = $result->total_return;
            $viewData = [
                "order" => $order,
                "order_cart" => json_decode($order->cart_json),
                "order_user" => $this->users_model->getUser([
                    "id" => $order->user_id
                ])
            ];

            if (isset($_GET['refund']) && isset($_POST['refund'])) {
                if ($this->input->post('amount', TRUE) > 0) {
                    $this->db->query("UPDATE users SET balance = balance + ? WHERE id = ?", [
                        $this->input->post('amount', TRUE),
                        $order->user_id
                    ]);
                    $this->db->query("INSERT INTO sms_return (process_no,return_price,return_date) VALUES (?,?,?)", [ $order->process_no,$this->input->post("gainAmount",true),date("Y-m-d H:i:s")]);
                    $this->db->query("UPDATE orders SET minus_gain=? WHERE process_no=?",[$this->input->post("gainAmount",true),$order->process_no]);
					$currentDate = date('Y-m-d');
					$orderDate = date('Y-m-d',strtotime($order->created_at));
					if($currentDate != $orderDate) {
						$income = $this->db->where([
										'date'=>$orderDate
									])->get('outgoings')->row();
						$this->db->query("UPDATE outgoings SET price = price - '" . ($this->input->post("gainAmount",true)) . "' WHERE id = '".$income->id."'");
					}
                    if (isset($_POST['sms'])) {
                        sendSMS($viewData['order_user']->phone_number,  $order->process_no . ' numaralı siparişiniz için ' . number_format($this->input->post('amount', TRUE), 2) . 'TL tutarı bakiyenize PUBG ID sınırlamasına girdiği için iade edildi.');
                    }
                    if (isset($_POST['notification'])) {
                        addUserNotification('refund', $viewData['order_user']->id, [
                            'time' => time(),
                            'amount' => $this->input->post('amount', TRUE),
                            'order_id' => $order->id
                        ]);
                    }
                }
                redirect(current_url());
                return;
            }

            if(isset($_GET["process"])):
                if(isset($_POST['manuelOrder'])){
                    foreach($this->input->post('product')['codes'] as $postCode):
                        if(!empty($postCode)){
                            $this->db->insert('stock_pool', [
                                'user_id' => $order->user_id,
                                'order_id' => $order->id,
                                'is_sold' => 1,
                                'code' => $postCode,
                                'product_json' => $this->input->post('product')['json'],
                                'product_id' => json_decode($this->input->post('product')['json'])->id
                            ]);
                        }
                    endforeach;
                    redirect(current_url());
                    return;
                }

                if(isset($_GET["update_status"])):
                    if($this->input->get("update_status", TRUE) == 0 || $this->input->get("update_status", TRUE) == 1 || $this->input->get("update_status", TRUE) == 2 || $this->input->get("update_status", TRUE) == 3):
                        $this->orders_model->updateOrder([
                            "status" => $this->input->get("update_status", TRUE),
                            "updated_at" => date("Y-m-d H:i:s")
                        ],[
                            "id" => $order->id
                        ]);
                        if($this->input->get('update_status', TRUE) == 3 && $order->status != 3){
                            $this->db->query("UPDATE users SET balance = balance + '" . $order->total_price . "' WHERE id = '" . $order->user_id . "'");
							$currentDate = date('Y-m-d');
							$orderDate = date('Y-m-d',strtotime($order->created_at));
							if($currentDate != $orderDate) {
								$income = $this->db->where([
										'date'=>$orderDate
									])->get('outgoings')->row();
								$this->db->query("UPDATE outgoings SET price = price - '" . ($order->total_price - $order->total_arrival_price) . "' WHERE id = '".$income->id."'");
							}
                        }

                        if ($this->input->get('update_status', TRUE) == 2 && isset($_GET['give_stock'])) {
                            // siparişi teslim et (stokta varsa)
                            foreach(json_decode($order->cart_json) as $cj_item):
                                $currentGiven = $this->db->where([
                                    'order_id' => $order->id,
                                    'is_sold' => 1,
                                    'product_id' => $cj_item->product->id
                                ])->get('stock_pool')->num_rows();
                                $needQty = $cj_item->quantity - $currentGiven;
                                if ($needQty > 0) {
                                    if ( $this->db->where([
                                            'product_id' => $cj_item->product->id,
                                            'is_sold' => 0
                                        ])->get('stock_pool')->num_rows() >= $needQty ) {
                                        $this->db->limit($needQty)->update('stock_pool', [
                                            'product_json' => json_encode($cj_item->product),
                                            'is_sold' => 1,
                                            'user_id' => $order->user_id,
                                            'order_id' => $order->id
                                        ], [
                                            'product_id' => $cj_item->product->id,
                                            'is_sold' => 0
                                        ]);
                                    }
                                }
                            endforeach;
                            if (!empty($order->gift_email)) {
                                sendEmail($order->gift_email, 'Bizde bir hediyeniz var!', getEmailTemplate('orderGift', [
                                    'order_id' => $order->id
                                ]));
                            }
                        }

                        sendEmail($this->users_model->getUser([
                            'id' => $order->user_id
                        ])->email, 'EPİNDENİZİ - Sipariş(#' . $order->process_no . ') Durumu: ' . orderStatus($this->input->get('update_status',TRUE)), getEmailTemplate('order', [
                            'status' => $this->input->get('update_status', TRUE),
                            'process_no' => $order->process_no,
                            'user_orders_page' => orj_site_url('uye/siparislerim')
                        ]));
                        sendSMS($this->users_model->getUser([
                            'id' => $order->user_id
                        ])->phone_number,  $order->process_no . ' numaralı siparişiniz ' . strtoupper(orderStatus($this->input->get('update_status', TRUE))) . '. Detaylar için ' . orj_site_url('uye/siparislerim'));
                        redirect("order/" . $order->id);
                    endif;
                endif;
            endif;

            $this->load->view("pages/orders/order", (object)$viewData);
        }else{
            redirect();
            exit;
        }
    }

}
