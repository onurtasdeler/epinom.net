<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends CI_Controller{

    function __construct()
    {

        parent::__construct();
        if(!getActiveUser()){
            redirect("login");
            exit;
        }
    }

    function index() {
        $this->list();
    }

    function formalize($orderid = NULL){
        if($orderid == NULL) {
            redirect("invoices/list");
        }
        $this->load->library('parasutlib');

        $order = $this->db->where(['id'=>$orderid])->get('orders')->row();

        if($order->parasut_id != 0) {
            redirect("invoices/list");
        }

        $user = $this->db->where(['id'=>$order->user_id])->get('users')->row();

        if($user->parasut_id == 0){
            $customer_id = $this->parasutlib->check_customer($user);
            $this->db->update('users', [
                'parasut_id' => $customer_id
            ], [
                'id' => $user->id
            ]);
        }else {
            $customer_id = $user->parasut_id;
        }
        $products = json_decode($order->cart_json,true);
        $product_parasut_id = array();

        foreach($products as $_p){
            $passs = $this->db->where(['id'=>$_p['product']['id']])->get('products')->row();
            $autoFormalize = 1;
            if (isset($passs->id)) {
                $autoFormalize = $passs->auto_formalize;
            }
            if ($autoFormalize == 1) {
                if($passs->parasut_id == 0){
                    $par_id = $this->parasutlib->check_product($_p['product']['product_name']);
                    $this->db->update('products', [
                        'parasut_id' => $par_id
                    ], [
                        'id' => $_p['product']['id']
                    ]);
                } else {
                    $par_id = $passs->parasut_id;
                }
                array_push($product_parasut_id, $par_id);
            }
        }

        if (count($product_parasut_id) > 0) {
            $invoice = $this->parasutlib->create_invoice($order, $customer_id, $product_parasut_id);
            if($invoice != NULL){
                $this->db->update('orders', [
                    'parasut_id' => $invoice,
                    'is_formalized' => 1
                ], [
                    'id' => $orderid
                ]);
            }
        } else {
            echo '<script>alert("Faturalanacak bir ürün yok. Fatura oluşturulmadı.");window.location.href="' . base_url('invoices/list') . '"</script>';
            return;
        }

        $viewData['alert'] = [
            'class' => 'success',
            'message' => $invoice,
        ];
        header('Refresh:2;url='. base_url('invoices/list'));
        $this->load->view('pages/invoices/list', (object)$viewData);
    }

    function formalize_last_1_week($user_id = NULL) {
        if ($user_id) {
            $user = $this->db->where(['id' => $user_id])
                ->get('users')
                ->row();

            if (isset($user->id)) {

                $orders = $this->db->query("SELECT * FROM orders WHERE user_id = ? AND status = 2 AND is_formalized = 0 AND created_at >= NOW() - INTERVAL 7 day", [
                    $user->id
                ])->result();

                $process_no = time() + rand(1,999);
                $invoiceOrder = (object)[
                    'id' => $process_no,
                    'process_no' => $process_no,
                    'extra_json' => [],
                    'total_price' => 0,
                    'user_id' => $user->id,
                    'status' => 2,
                    'cart_json' => [],
                    'created_at' => date('Y-m-d H:i:s')
                ];

                if (count($orders) > 0) {

                    $this->load->library('parasutlib');

                    $product_parasut_ids = array();

                    foreach ($orders as $_order):
                        $_order->cart_json = json_decode($_order->cart_json, true);
                        foreach($_order->cart_json as $_o_c_i):
                            $invoiceOrder->cart_json[] = $_o_c_i;
                            $product = $this->db->where(['id'=>$_o_c_i['product']['id']])->get('products')->row();
                            $autoFormalize = 1;
                            if (isset($product->id)) {
                                $autoFormalize = $product->auto_formalize;
                            }
                            if ($autoFormalize == 1) {
                                $par_id = 0;
                                if($product->parasut_id == 0){
                                    $par_id = $this->parasutlib->check_product($_o_c_i['product']['product_name']);
                                    $this->db->update('products', [
                                        'parasut_id' => $par_id
                                    ], [
                                        'id' => $product->id
                                    ]);
                                } else {
                                    $par_id = $product->parasut_id;
                                }
                                $invoiceOrder->total_price += $_o_c_i['product']['price'] * $_o_c_i['quantity'];
                                array_push($product_parasut_ids, [
                                    'par_id' => $par_id,
                                    'item' => $_o_c_i
                                ]);
                            }
                        endforeach;
                    endforeach;

                    if (count($product_parasut_ids) > 0) {
                        $customer_id = 0;
                        if($user->parasut_id == 0){
                            $customer_id = $this->parasutlib->check_customer($user);
                            $this->db->update('users', [
                                'parasut_id' => $customer_id
                            ], [
                                'id' => $user->id
                            ]);
                        }else {
                            $customer_id = $user->parasut_id;
                        }

                        $invoiceOrder->cart_json = json_encode($invoiceOrder->cart_json);

                        $invoice = $this->parasutlib->create_invoice_h($invoiceOrder, $customer_id, $product_parasut_ids, 'HAFTALIK');

                        if($invoice != NULL){
                            $this->db->where_in('id', array_map(function($item){
                                return $item->id;
                            }, $orders))->update('orders', [
                                'parasut_id' => $invoice,
                                'is_formalized' => 1
                            ]);
                            echo '<script>alert("Faturalandı.");window.location.href="' . base_url('invoices/list') . '"</script>';
                            return;
                        }
                    } else {
                        echo '<script>alert("Siparişlerde faturalanabilecek ürün yok.");window.location.href="' . base_url('invoices/list') . '"</script>';
                        return;
                    }
                } else {
                    echo '<script>alert("Bu hafta içerisinde sipariş bulunamadı.");window.location.href="' . base_url('invoices/list') . '"</script>';
                }
            }
        }
        redirect();
    }

    function list($success = NULL)
    {

        $viewData = [];

        if($success == 1){
            $viewData['alert'] = [
                'class' => 'success',
                'message' => 'Eklendi.'
            ];
        }

        $this->load->view('pages/invoices/list', (object)$viewData);
    }

    function pagination(){
        if (!$this->db->table_exists('invoices')) {
            $this->db->query('CREATE VIEW invoices AS SELECT orders.*, users.email FROM orders JOIN users ON orders.user_id = users.id');
        }
        $table = 'invoices';

        // Table's primary key
        $primaryKey = 'id';

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array(
                'db'        => 'process_no',
                'dt'        => 0
            ),
            array( 'db' => 'email', 'dt' => 1, 'formatter' => function($d, $row) {
                $user = $this->db->where(['email' => $d])->get('users')->row();
                return  "<a href='".base_url("users/view/") . $user->id . "'>" . $d . "</a>";
            }),
            array( 'db' => 'cart_json', 'dt' => 2, 'formatter'=> function($d, $row) {
                return  "<strong>".count(json_decode($d))."</strong> Adet Ürün";
            }),

            array( 'db' => 'status', 'dt' => 3, 'formatter' => function($d, $row){
                return orderStatus($d, "badge");
            }),
            array( 'db' => 'is_formalized', 'dt' => 4, 'formatter' => function($d, $row){
                if($d == 1) return '<div class="badge badge-success">Faturalandı</div>'; else return '<div class="badge badge-warning">Faturalanmadı</div>';
            }),

            array( 'db' => 'total_price', 'dt' => 5, 'formatter' => function($d, $row){
                return number_format($d, 2, ",", ".");
            } ),
            array( 'db' => 'created_at', 'dt' => 6, 'formatter' => function($d, $row){
                return date('d/m/Y H:i', strtotime($d));
            } ),

            array( 'db' => 'id', 'dt' => 7, 'formatter' => function($d, $row){
                $order = $this->db->where(['id'=>$d])->get('orders')->row();
                if($order->parasut_id != 0){
                    return '<a href="https://uygulama.parasut.com/355900/satislar/' . $order->parasut_id.'" target="_blank" class="btn btn-outline-primary btn-sm">
                        Görüntüle
                    </a>';
                } else {
                    return '<a href="' . base_url("invoices/formalize/" . $d) . '" class="btn btn-outline-primary btn-sm">
                        Faturala
                    </a>';
                }
            } ),
            array( 'db' => 'id', 'dt' => 8, 'formatter' => function($d, $row){
                $order = $this->db->where(['id'=>$d])->get('orders')->row();
                if($order->parasut_id != 0){
                    return '<a href="https://uygulama.parasut.com/355900/satislar/' . $order->parasut_id.'" target="_blank" class="btn btn-outline-primary btn-sm">
                        Görüntüle
                    </a>';
                } else {
                    return '<a href="' . base_url("invoices/formalize_last_1_week/" . $order->user_id) . '" target="_blank" class="btn btn-outline-primary btn-sm">
                        1 Hafta Faturala
                    </a>';
                }
            } ),
            array( 'db' => 'id', 'dt' => 9, 'formatter' => function($d, $row){
                return '<a href="'.base_url("order/" . $d).'" class="btn btn-primary btn-block">
                    <i class="fas fa-search"></i>
                </a>';
            }),

        );

        // SQL server connection information
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname,
            'charset' => 'utf8'
        );

        $whereAll = NULL;
        if(isset($_GET['user_id'])) {
            $whereAll = "user_id = '" . $this->input->get('user_id', TRUE) . "'";
        }

        require(APPPATH . '/libraries/SSP.php');

        echo json_encode(
            SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll )
        );
    }
}