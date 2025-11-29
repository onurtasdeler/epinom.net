<?php

use Parasut\Client;
use Parasut\Product;
use Parasut\Account;
use Parasut\Invoice;

class Parasutlib
{
    public $client;
    public $account;
    public $product;

    private $parasut_username = 'denizmincan@hotmail.com';
    private $parasut_password = '124512';
    private $parasut_client_id = 'ff5e6881fdb635ecd7c8cfb905b81941649ff33644c755320fd383b635ae35d3';
    private $parasut_company_id = '413108';

    function check_customer($user){
        $client = new Client([
            "client_id" => $this->parasut_client_id,
            "username" => $this->parasut_username,
            "password" => $this->parasut_password,
            "grant_type" => "password",
            "redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
            'company_id' => $this->parasut_company_id
        ]);
        $account = new Parasut\Account($client);
        $customer = array(
            'data' =>
                array(
                    'type' => 'contacts',
                    'attributes' => array(
                        'email' => $user->email,
                        'name' => $user->full_name, // REQUIRED
                        'short_name' => $user->full_name,
                        'contact_type' => 'person', // or company
                        'district' => $user->city,
                        'city' => $user->city,
                        'address' => '',
                        'phone' => $user->phone_number,
                        'account_type' => 'customer', // REQUIRED
                        'tax_number' => $user->tc_no ? $user->tc_no : 11111111111, // TC no for person
                        'tax_office' => $user->city
                    ),
                ),
        );

        try{
            $parasut_id = $account->create($customer);
        }catch(Exception $e) {
            exit($e->getMessage());
        }

        return $parasut_id['data']['id'];
    }
    function check_product($product){
        $client = new Client([
            "client_id" => $this->parasut_client_id,
            "username" => $this->parasut_username,
            "password" => $this->parasut_password,
            "grant_type" => "password",
            "redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
            'company_id' => $this->parasut_company_id
        ]);
        $products = new Parasut\Product($client);
        $productArr = array(
            'data' => array (
                'type' => 'products',
                'attributes' => array (
                    'name' => $product
                )
            )
        );
        $parasut_id = $products->create($productArr);
        return $parasut_id['data']['id'];


    }
    function create_invoice($order, $customer_id,  $product_parasut_id, $t = NULL){
        $client = new Client([
            "client_id" => $this->parasut_client_id,
            "username" => $this->parasut_username,
            "password" => $this->parasut_password,
            "grant_type" => "password",
            "redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
            'company_id' => $this->parasut_company_id
        ]);
        $products = json_decode($order->cart_json, true);
        $product_data = array();
        foreach($products as $key => $_p){
            if (!array_key_exists($key, $product_parasut_id)) {
                continue;
            }
            /* kdv yüzdesi */
            $kdvPercent = isset($_p['product']['kdv_percent']) ? floatval($_p['product']['kdv_percent']) : 0;
            if ($_p['product']['is_api'] == 1 && json_decode($_p['product']['api_json'])->attribution == 'turkpin') {
                $kdvPercent = 0;
            }

            $p = array (
                'type' => 'sales_invoice_details',
                'attributes' => array (
                    'quantity' => intval($_p['quantity']),
                    'unit_price' => floatval($_p['price']),
                    'vat_rate' => $kdvPercent,
                    'description' => $_p['product']['product_name'],
                ),
                "relationships" => array (
                    "product" => array (
                        "data" => array (
                            "id" => $product_parasut_id[$key],
                            "type" => "products"
                        )
                    )
                )
            );
            array_push($product_data, $p);
        }

        $invoice = array (
            'data' => array (
                'type' => 'sales_invoices', // Required
                'attributes' => array (
                    'item_type' => 'invoice', // Required
                    'description' => 'EPİNDENİZİ.COM Entegrasyon - Fatura' . ($t == NULL ? '' : ' ' . $t),
                    'issue_date' => date("Y-m-d", strtotime($order->created_at)), // Required
                    'due_date' => date("Y-m-d", strtotime($order->created_at)),
                    'invoice_series' => 'EK-OFK',
                    'invoice_id' => $order->id,
                    'currency' => 'TRL',
                    'shipment_included' => false
                ),
                'relationships' => array (
                    'details' => array (
                        'data' => $product_data,
                    ),'contact' => array (
                        'data' => array (
                            'id' => $customer_id,
                            'type' => 'contacts'
                        )
                    )
                )
            ),
        );


        $invoices = new Parasut\Invoice($client);
        $p_invoice_id = $invoices->create($invoice);

        /*$payArr = array(
            "data" => array(
                "type" => "payments",
                "attributes" => array(
                    "description" => "Kasa Hesabı",
                    "account_id" => "705052", // bank account id on Parasut
                    "date" => date("Y-m-d", strtotime($order->created_at)),
                    "amount" => floatval($order->total_price),
                    "exchange_rate" => 1.0
                )
            )
        );
        $parasut_id = $invoices->pay($p_invoice_id['data']['id'], $payArr);*/

        $id = $p_invoice_id['data']['id'];
        $this->create_e_archive($id, $order->created_at);
        return $p_invoice_id['data']['id'];
    }
    function create_invoice_h($order, $customer_id,  $product_parasuts, $t = NULL){
        $client = new Client([
            "client_id" => $this->parasut_client_id,
            "username" => $this->parasut_username,
            "password" => $this->parasut_password,
            "grant_type" => "password",
            "redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
            'company_id' => $this->parasut_company_id
        ]);
        $product_data = array();
        foreach($product_parasuts as $_pp){

            $_p = $_pp['item'];

            /* kdv yüzdesi */
            $kdvPercent = isset($_p['product']['kdv_percent']) ? floatval($_p['product']['kdv_percent']) : 0;
            if ($_p['product']['is_api'] == 1 && json_decode($_p['product']['api_json'])->attribution == 'turkpin') {
                $kdvPercent = 0;
            }

            $p = array (
                'type' => 'sales_invoice_details',
                'attributes' => array (
                    'quantity' => intval($_p['quantity']),
                    'unit_price' => floatval($_p['price']),
                    'vat_rate' => $kdvPercent,
                    'description' => $_p['product']['product_name'],
                ),
                "relationships" => array (
                    "product" => array (
                        "data" => array (
                            "id" => $_pp['par_id'],
                            "type" => "products"
                        )
                    )
                )
            );
            array_push($product_data, $p);
        }

        $invoice = array (
            'data' => array (
                'type' => 'sales_invoices', // Required
                'attributes' => array (
                    'item_type' => 'invoice', // Required
                    'description' => 'EPİNDENİZİ.COM Entegrasyon - Fatura' . ($t == NULL ? '' : ' ' . $t),
                    'issue_date' => date("Y-m-d", strtotime($order->created_at)), // Required
                    'due_date' => date("Y-m-d", strtotime($order->created_at)),
                    'invoice_series' => 'EK-OFK',
                    'invoice_id' => $order->id,
                    'currency' => 'TRL',
                    'shipment_included' => false
                ),
                'relationships' => array (
                    'details' => array (
                        'data' => $product_data,
                    ),'contact' => array (
                        'data' => array (
                            'id' => $customer_id,
                            'type' => 'contacts'
                        )
                    )
                )
            ),
        );


        $invoices = new Parasut\Invoice($client);
        $p_invoice_id = $invoices->create($invoice);

        /*$payArr = array(
            "data" => array(
                "type" => "payments",
                "attributes" => array(
                    "description" => "Kasa Hesabı",
                    "account_id" => "705052", // bank account id on Parasut
                    "date" => date("Y-m-d", strtotime($order->created_at)),
                    "amount" => floatval($order->total_price),
                    "exchange_rate" => 1.0
                )
            )
        );
        $parasut_id = $invoices->pay($p_invoice_id['data']['id'], $payArr);*/

        $id = $p_invoice_id['data']['id'];
        $this->create_e_archive($id, $order->created_at);
        return $p_invoice_id['data']['id'];
    }
    function create_e_archive($invoice_id, $order_created_at){
        $client = new Client([
            "client_id" => $this->parasut_client_id,
            "username" => $this->parasut_username,
            "password" => $this->parasut_password,
            "grant_type" => "password",
            "redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
            'company_id' => $this->parasut_company_id
        ]);
        $invArr = array (
            "data" => array(
                "type" => "e_archives",
                "attributes" => [
                    "vat_exemption_reason_code" => 810,
                    "internet_sale" => [
                        "url" => orj_site_url(''),
                        "payment_type" => "ODEME_ARACI",
                        "payment_platform" => "EPİNDENİZİ.COM Bakiye",
                        "payment_date" => date('Y-m-d', strtotime($order_created_at))
                    ]
                ],
                "relationships" => array (
                    "sales_invoice" => array (
                        "data" => array (
                            "id" => $invoice_id, // Invoice Id
                            "type" => "sales_invoices"
                        )
                    )
                )
            )
        );
        $invoices = new Parasut\Invoice($client);
        return $invoices->create_e_archive($invArr);
    }
    function checkJob($id){
        $client = new Client([
            "client_id" => $this->parasut_client_id,
            "username" => $this->parasut_username,
            "password" => $this->parasut_password,
            "grant_type" => "password",
            "redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
            'company_id' => $this->parasut_company_id
        ]);
        $invoice = new Parasut\Invoice($client);
        return $invoice->checkJobStatus($id);
    }

}