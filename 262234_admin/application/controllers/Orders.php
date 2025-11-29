<?php

class Orders extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        $this->load->model("orders_model");
        if(!getActiveUser()){
			redirect("login");
			exit;
		}
    }

    function index(){
        $this->list();
    }
	
	function _isReportExists($productId, $arr = []) {
		if (count($arr) <= 0) return -1;
		$_index = 0;
		foreach ($arr as $_i) {
			if ($_i['product_id'] == $productId) return $_index;
			$_index++;
		}
		return -1;
	}
	
	function reports() {
		$orders = $this->db->order_by('id DESC')->where([
			'status' => 2
		])->get('orders')->result();
		
		$reports = [];
		foreach ($orders as $_order) {
			if (count(json_decode($_order->cart_json)) > 0) {
				foreach (json_decode($_order->cart_json) as $_item) {
					$issetIndex = $this->_isReportExists($_item->product->id, $reports);
					if ($issetIndex > -1) {
						$reports[$issetIndex]['qty'] += $_item->quantity;
						$reports[$issetIndex]['total'] += floatval($_item->price);
					} else {
						$reports[] = [
							'product_id' => $_item->product->id,
							'name' => $_item->product->product_name,
							'qty' => $_item->quantity,
							'total' => floatval($_item->price)
						];
					}
				}
			}
		}
		
		$viewData = [
			'reports' => $reports
		];
		
		$this->load->view('pages/orders/reports', (object)$viewData);
	}

    function list(){
        $orders = $this->orders_model->getAll();
        if(isset($_GET["get_pending"])){
            $orders = $this->orders_model->getAll([
                "status" => 0 
            ]);
        }
        if(isset($_GET["user_id"])){
            $orders = $this->orders_model->getAll([
                "user_id" => $this->input->get("user_id", TRUE) 
            ]);
        }
        $viewData = [
            "orders" => $orders
        ];
        $this->load->view("pages/orders/orders", (object)$viewData);
    }
	
    function list_api(){

        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * Easy set variables
         */

        // DB table to use
        $extraWhere = '';
        if (isset($_GET['get_pending'])) {
            $extraWhere .= ' WHERE a.status = 0';
        }
		if (isset($_GET['user_id'])) {
			$extraWhere .= ' WHERE a.user_id='.$_GET['user_id'];	
		}
        $table = $table = <<<EOT
 (
    SELECT 
      a.id, 
      a.process_no, 
      a.user_id, 
      CASE
        WHEN a.status = 0 THEN 'Beklemede'
        WHEN a.status = 1 THEN 'Hazırlanıyor'
        WHEN a.status = 2 THEN 'Teslim Edildi'
        WHEN a.status = 3 THEN 'İptal Edildi'
      END AS status,
      a.cart_json,
      a.total_price, 
      a.created_at,
      b.email AS user_email
    FROM orders a
    LEFT JOIN users b ON a.user_id = b.id {$extraWhere} ORDER BY a.id DESC
 ) temp
EOT;

        // Table's primary key
        $primaryKey = 'id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array(
                'db' => 'process_no',
                'dt' => 0
            ),
            array(
                'db' => 'user_email',
                'dt' => 1,
                'formatter' => function($d, $row) {
                    $user = $this->db->where('email', $d)->get('users')->row();
                    if (isset($user->id)) {
                        $html = "";
                        return '<a href="' . base_url("user/" . $user->id) . '"><u>' . $user->email . '</u></a>';
                    } else {
                        return 'Üye bulunamadı.';
                    }
                }
            ),
			array(
				'db' => 'cart_json',
				'dt' => 2,
				'formatter' => function($d, $row) {
					return count(json_decode($d)) . " Adet Ürün";
				}
			),
            array(
                'db' => 'cart_json',
                'dt' => 3,
                'formatter' => function($d, $row) {
                    $specials = [];
                    foreach(json_decode($d) as $_p) {
                        if (isset($_p->extra_information) && count($_p->extra_information) > 0) {
                            foreach($_p->extra_information as $_p_e) {
                                $specials[] =  '<strong>' . $_p_e->label . ':</strong> ' . $_p_e->value;
                            }
                        }
                    }
                    return implode('<br>', $specials);
                }
            ),
            array(
                'db' => 'status',
                'dt' => 4,
                'formatter' => function($d, $row) {
                    return $this->orderStatusByName($d, "badge");
                }
            ),
            array(
                'db' => 'total_price',
                'dt' => 5,
                'formatter' => function($d, $row) {
                    return number_format($d, 2);
                }
            ),
            array(
                'db' => 'created_at',
                'dt' => 6,
                'formatter' => function($d, $row) {
                    return date('d/m/Y H:i', strtotime($d));
                }
            ),
            array(
                'db' => 'id',
                'dt' => 7,
                'formatter' => function($d, $row) {
                    return '<a href="' . base_url("order/" . $d) . '" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-search"></i>
                    </a>';
                }
            ),
        );

        // SQL server connection information
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname,
            'charset' => 'utf8'
        );

        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */

        require(APPPATH . '/libraries/SSP.php');

        exit(json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
        ));
    }
    
function orderStatusByName($order_status, $return_type = null){
    switch($order_status){
        default:
        case 'Beklemede':
            $badge_class = "info";
            break;
        case 'Hazırlanıyor':
            $badge_class = "warning";
            break;
        case 'Teslim Edildi':
            $badge_class = "success";
            break;
        case 'İptal Edildi':
            $badge_class = "danger";
            break;
    }
    if($return_type == "badge"){
        return '<div class="badge badge-' . $badge_class . '">' . $order_status . '</div>';
    }else{
        return $order_status;
    }
}
}
