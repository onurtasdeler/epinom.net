<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SaleStatsByCategory extends CI_Controller {

	
	public function __construct(){
		parent::__construct();
		if(!getActiveUser()){
			redirect("login");
			exit;
		}
	}

	public function index()
	{
        $viewData = [];
        $query = $this->db->query("SELECT id,category_name,image_url FROM categories WHERE is_active=1 ORDER BY id");
        $categories = $query->result();
        for($i=0;$i<count($categories);$i++)
            $categories[$i]->totalSale=0;
        $query = $this->db->query("SELECT cart_json FROM orders WHERE status=2");
        $orders = $query->result();
        foreach($orders as $order) {
            foreach(json_decode($order->cart_json) as $item) {
                $index=0;
                foreach($categories as $category) {
                    if($category->id == $item->product->category_id) {
                        $categories[$index]->totalSale += $item->price*$item->quantity;
                        break;
                    }
                    $index++;
                }
            }
        }
        for($i=0;$i<count($categories);$i++)
            $categories[$i]->totalSale=number_format($categories[$i]->totalSale,2);
        usort($categories,function($a,$b) {  
            if ($a->totalSale == $b->totalSale) {
                return 0;
            }
            return ($a->totalSale > $b->totalSale) ? -1 : 1;
        });
        $viewData["viewData"] = $categories;
        $this->load->view("pages/salestats/byCategory", (object)$viewData);
	}
}
