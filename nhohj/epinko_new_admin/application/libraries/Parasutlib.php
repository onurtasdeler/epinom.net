<?php



class Parasutlib
{
    public $client;
    public $account;
    public $product;

    private $parasut_username = '';
    private $parasut_password = '';
    private $parasut_client_id = '';
    private $parasut_client_secret = '';
    private $parasut_company_id = '';
    private $parasut_case_no = '';
    public $CI=null;
    private $parasutAuthorization = null;
    private $config;

    public function __construct()
    {
        $this->CI=&get_instance();
        //check the configuration data
        $this->CI->load->helper("parasut_helper");
        $this->config = getTableSingle("table_parasut_settings", array("id" => 1));
        $this->parasut_username = $this->config->parasut_username;
        $this->parasut_password = $this->config->parasut_password;
        $this->parasut_client_id = $this->config->parasut_client_id;
        $this->parasut_client_secret = $this->config->parasut_client_secret;
        $this->parasut_company_id = $this->config->parasut_company_id;
        $this->parasut_case_no = $this->config->parasut_case_no;

        $this->CI->load->model("m_tr_model");
        $this->parasutAuthorization = new Authorization([
            "client_id" => $this->parasut_client_id,
            "client_secret" => $this->parasut_client_secret,
            "username" => $this->parasut_username,
            "password" => $this->parasut_password,
            "grant_type" => "password",
            "redirect_uri" => "urn:ietf:wg:oauth:2.0:oob",
            'company_id' => $this->parasut_company_id
        ]);
    }

    public function create_invoice($order,$isAdvert = false) {
        ini_set('display_errors',1);
        error_reporting(E_ALL);
        if($order->invoice_id)
            return false;
        $customer = getTableSingle("table_users",array("id"=>$isAdvert?$order->sell_user_id:$order->user_id));
        if(empty($customer->parasut_id)) {
            $parasutContacts = new Contacts($this->parasutAuthorization);
            $parasutData = [
                'data' => [
                    'type'=>'contacts',
                    'attributes'=> [
                        'name'=> $customer->full_name,
                        'short_name' => $customer->full_name,
                        'contact_type' => 'person',
                        'district'=> "Üsküdar",
                        'city' => "İstanbul",
                        'address'=> "Altunizade Mahallesi",
                        'email' => $customer->email,
                        'phone'=> !empty($customer->phone) ? $customer->phone:'5555555555',
                        'account_type'=>'customer',
                        'tax_number'=> !empty($customer->tc) ? $customer->tc:"11111111111",
                        'tax_office'=>"İstanbul"
                    ]
                ]
            ];
            $createContact = $parasutContacts->create($parasutData);
            if(isset($createContact->result->data)){
                $customer->parasut_id = $createContact->result->data->id;
                $this->CI->m_tr_model->updateTable("table_users",array("parasut_id"=>$createContact->result->data->id),array("id"=>$customer->id));
            }
        } else {
            $parasutContacts = new Contacts($this->parasutAuthorization);
            $parasutData = [
                'data' => [
                    'type'=>'contacts',
                    'attributes'=> [
                        'name'=> $customer->full_name,
                        'contact_type' => 'person',
                        'district'=> "Üsküdar",
                        'city' => "İstanbul",
                        'address'=> "Altunizade Mahallesi",
                        'tax_number'=> !empty($customer->tc) ? $customer->tc:"11111111111",
                        'tax_office'=>"İstanbul"
                    ]
                ]
            ];
            $createContact = $parasutContacts->edit($customer->parasut_id,$parasutData);
        }
        $orderProductDetails = [];
        $vat_exemption = false;
        $product = getTableSingle(($isAdvert?"table_adverts":"table_products"),array("id"=>$isAdvert?$order->advert_id:$order->product_id));
        if(!$isAdvert && $product->vat_rate == 0)
            $vat_exemption = true;
        if(empty($product->parasut_id)) {
            $parasutProducts = new Products($this->parasutAuthorization);
            $parasutData = [
                "data" => [
                    "type" => "products",
                    "attributes" => [
                        "name" => $isAdvert?($product->ad_name . " Komisyon Bedeli"):$product->p_name, //ürün adı
                        "vat_rate" => $isAdvert?20:$product->vat_rate, //KDV oranı
                        "unit" => "Adet", //birim
                        "currency" => "TRL", //döviz tipi
                        "inventory_tracking" => false, //stok durumu
                    ]
                ]
            ];
            $createProduct = $parasutProducts->create($parasutData);
            $this->CI->m_tr_model->updateTable(($isAdvert?"table_adverts":"table_products"),array("parasut_id"=>$createProduct->result->data->id),array("id"=>$product->id));
        }
        $hizmetBedeliBirimFiyat = 0;
        $urunBirimFiyat = (($isAdvert?$order->kom_tutar:$order->total_price)/$order->quantity) * 100/(100 + ($isAdvert?20:$product->vat_rate));
        if(!$isAdvert && $this->config->parasut_hizmet_bedeli_orani > 0 && empty($this->config->parasut_hizmet_bedeli_urun_id)) {
            $parasutProducts = new Products($this->parasutAuthorization);
            $parasutData = [
                "data" => [
                    "type" => "products",
                    "attributes" => [
                        "name" => "Hizmet Bedeli", //ürün adı
                        "vat_rate" => 20, //KDV oranı
                        "unit" => "Adet", //birim
                        "currency" => "TRL", //döviz tipi
                        "inventory_tracking" => false, //stok durumu
                    ]
                ]
            ];
            $createProduct = $parasutProducts->create($parasutData);
            $this->config->parasut_hizmet_bedeli_urun_id = $createProduct->result->data->id;
            $this->CI->m_tr_model->updateTable("table_parasut_settings",array("parasut_hizmet_bedeli_urun_id"=>$createProduct->result->data->id),array("id"=>1));
        }
        if(!$isAdvert && $this->config->parasut_hizmet_bedeli_orani > 0 && !empty($this->config->parasut_hizmet_bedeli_urun_id)) {
            $hizmetBedeliTutari = ($order->total_price/100)*$this->config->parasut_hizmet_bedeli_orani;
            $hizmetBedeliBirimFiyat = $hizmetBedeliTutari * 100 / 120;
        }
        $orderProductDetails[] = [
            'type' => 'sales_invoice_details',
            'attributes' => [
                'quantity' => $order->quantity,
                'unit_price' => (($isAdvert?$order->kom_tutar:$order->total_price)/$order->quantity) * 100/(100 + ($isAdvert?20:$product->vat_rate)),
                'vat_rate' => $isAdvert?20:$product->vat_rate,
                'description' => $isAdvert?($product->ad_name . " Komisyon Bedeli"):$product->p_name
            ],
            'relationships' => [
                'product' => [
                    'data' => [
                        'id'=>$product->parasut_id,
                        'type'=> "products"
                    ]
                ]
            ]
        ];
        if($hizmetBedeliBirimFiyat>0) {
            $orderProductDetails[] = [
                'type' => 'sales_invoice_details',
                'attributes' => [
                    'quantity' => 1,
                    'unit_price' => $hizmetBedeliBirimFiyat,
                    'vat_rate' => 20,
                    'description' => "Hizmet Bedeli"
                ],
                'relationships' => [
                    'product' => [
                        'data' => [
                            'id'=>$this->config->parasut_hizmet_bedeli_urun_id,
                            'type'=> "products"
                        ]
                    ]
                ]
            ];
        }

        $description = $this->config->parasut_invoice_name;
        $createInvoiceData = [
            "data" => [
                "type" => "sales_invoices",
                "attributes" => [
                    "item_type" => "invoice",
                    'description' => $description,
                    'issue_date' => date("Y-m-d", strtotime($order->created_at)), // Required
                    'due_date' => date("Y-m-d", strtotime($order->created_at)),
                    'invoice_series' => '',
                    'invoice_id' => time(),
                    'currency' => 'TRL',
                    'shipment_included' => false
                ],
                "relationships" => [
                    "details" => [
                        "data" => $orderProductDetails
                    ],
                    "contact" => [
                        "data" => [
                            "type" => "contacts",
                            "id" => $customer->parasut_id //müşteri id
                        ]
                    ]
                ]
            ]
        ];
        //print_r($createInvoiceData);
        $invoices=new Invoice($this->parasutAuthorization);
        $createInvoice = $invoices->create($createInvoiceData);
        if(isset($createInvoice->result->data->id)){
            $id = $createInvoice->result->data->id;
            $payInvoiceData = [
                "data" => [
                    "type" => "payments",
                    "attributes" => [
                        "description" => "Kasa Hesabı",
                        "account_id" => $this->parasut_case_no, // Kasa veya Banka id
                        "date" =>  date("Y-m-d", strtotime($order->created_at)),
                        "amount" => floatval($createInvoice->result->data->attributes->net_total_in_trl)
                    ]
                ]
            ];
            $payResult = $invoices->pay($id,$payInvoiceData);
            $this->create_e_archive($id, $order->created_at, $vat_exemption);
            $this->CI->m_tr_model->updateTable(($isAdvert?"table_orders_adverts":"table_orders"),array("invoice_id"=>$id,"invoice_date"=>date('Y-m-d H:i:s')),array("id"=>$order->id));
        }
    }
    function create_e_archive($invoice_id, $order_created_at, $vat_exemption=false){
        $invArr =[
            "data" => [
                "type" => "e_archives",
                "attributes" => [
                    "internet_sale" => [
                        "url" => sprintf("%s://%s",isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',$_SERVER['SERVER_NAME']),
                        "payment_type" => "ODEMEARACISI",
                        "payment_platform" => $this->config->parasut_invoice_name,
                        "payment_date" => date('Y-m-d', strtotime($order_created_at))
                    ]
                ],
                "relationships" => [
                    "sales_invoice" => [
                        "data" => [
                            "id" => $invoice_id, // Invoice Id
                            "type" => "sales_invoices"
                        ]
                    ]
                ]
            ]
        ];
        if($vat_exemption) {
            $invArr["data"]["attributes"]["vat_exemption_reason_code"] = 351;
            $invArr["data"]["attributes"]["vat_exemption_reason"] = "Diğer Hediye Kartı Satışları";
        }
        $invoices = new Invoice($this->parasutAuthorization);
        $result = $invoices->create_e_archive($invArr);
    }
    function show_invoice($order) {
        $invoice = new Invoice($this->parasutAuthorization);
        $result = $invoice->show($order->invoice_id)->result;
        if(!isset($result->data->relationships->active_e_document->data->id)) {
            echo 'Bu belge resmileştirme sürecindedir.Kısa süre sonra tekrar deneyiniz.';
            die();
        }
        $archiveId = $result->data->relationships->active_e_document->data->id;
        $result = $invoice->pdf_e_archive($archiveId)->result;
        header('Location:'.$result->data->attributes->url);
    }
    function checkJob($id) {
        $invoice = new Invoice($this->parasutAuthorization);
    }
}