<?php

class Cronjob extends CI_Controller
{

    private $ips = [
        '185.23.73.42'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function attributionPriceCheck() {
        if (in_array(getIPAddress(), $this->ips)) {
            $this->load->view('error404');
            return;
        }

        if (isset($_GET['q'])) {

            if (md5('vg_990x1-') == $this->input->get('q', TRUE)) {

                $applied = [];

                // get waiting
                $data = $this->db->where([
                    'is_api' => 1
                ])->order_by('id DESC')->get('products')->result();

                if(count($data)>0){

                    foreach($data as $_item):

                        $_item->api_json = json_decode($_item->api_json);

                        if ($_item->api_json->auto_stock == 1) {
                            switch($_item->api_json->attribution) {
                                case 'pinabi':
                                case 'turkpin':
                                    $this->db->insert('attribution_jobs', [
                                        'attribution_name' => $_item->api_json->attribution,
                                        'product_id' => $_item->id,
                                        'json' => json_encode([
                                            'attribution' => $_item->api_json->attribution,
                                            'opposite_category' => $_item->api_json->opposite_category,
                                            'opposite_product' => $_item->api_json->opposite_product,
                                            'opposite_product_name' => $_item->api_json->opposite_product_name,
                                            'opposite_product_price' => ($_item->api_json->opposite_product_price == NULL ? 0 : $_item->api_json->opposite_product_price),
                                            'marj_percent_float' => $_item->api_json->marj_percent_float == 0 ? ($_item->api_json->marj_percent>0 ? $_item->api_json->marj_percent : 0) : $_item->api_json->marj_percent_float,
                                            'marj_percent' => $_item->api_json->marj_percent,
                                            'auto_stock' => $_item->api_json->auto_stock == 1 ? 1 : 0
                                        ])
                                    ]);
                                    $applied[] = $_item;
                                break;
                            }
                        }

                    endforeach;

                }

                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'error' => FALSE,
                    'message' => 'OK. (' . count($data) . '/' . count($applied) . ')',
                    'server_unix_time' => time()
                ]));
                return;

            }

        }
        redirect();
    }

    public function doAttributionJobs($limit = 20) {
        if (!in_array(getIPAddress(), $this->ips)) {
            $this->load->view('error404');
            return;
        }

        if (isset($_GET['q'])) {

            if (md5('vg_990x1-') == $this->input->get('q', TRUE)) {

                $applied = [];

                // get waiting
                $data = $this->db->where('attribution_name','turkpin')->limit($limit)->get('attribution_jobs')->result();

                $jsonVariable = [];

                if(count($data)>0){

                    foreach($data as $_item):
                        $_item->json = json_decode($_item->json);

                        switch($_item->attribution_name) {
                            case 'turkpin':
                                $this->load->library('turkpin');
                                $epinProductList = $this->turkpin->getEpinProductList($_item->json->opposite_category);
                                if (count($epinProductList) > 0) {
                                    foreach ($epinProductList as $_p):
                                        if ($_item->json->opposite_product == $_p->id) {
                                            $currentProduct = $this->db->where('id', $_item->product_id)->get('products')->row();
                                            $price = $currentProduct->price;
                                            if ($_p->price >= $_item->json->opposite_product_price) {
                                                $price = ($_p->price + ($_p->price * ($_item->json->marj_percent_float / 100)));
                                            }
                                            $this->db->update('products', [
                                                'is_stock' => ($_item->json->auto_stock == 1 ? ($_p->stock > 0 ? 1 : 0) : $_item->is_stock),
                                                'price' => $price,
                                                'arrival_price' => $_p->price,
                                                'api_json' => json_encode([
                                                    'attribution' => 'turkpin',
                                                    'opposite_category' => $_item->json->opposite_category,
                                                    'opposite_product' => $_item->json->opposite_product,
                                                    'opposite_product_name' => $_p->name,
                                                    'opposite_product_price' => $_p->price,
                                                    'opposite_current_stock' => $_p->stock,
                                                    'price' => $price,
                                                    'marj_percent_float' => $_item->json->marj_percent_float,
                                                    'marj_percent' => $_item->json->marj_percent,
                                                    'auto_stock' => $_item->json->auto_stock
                                                ]),
                                                'api_last_updated_at' => date('Y-m-d H:i:s')
                                            ], [
                                                'id' => $_item->product_id,
                                                'is_api' => 1
                                            ]);
                                            $jsonVariable[] = $this->db->where([
                                                'id' => $_item->product_id
                                            ])->get('products')->row();
                                            $applied[] = $_item->id;
                                        }
                                    endforeach;
                                }
                            break;
                        }

                    endforeach;

                }

                if (count($applied) > 0) {
                    $this->db->where_in('id', $applied)->delete('attribution_jobs');
                }

                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'error' => FALSE,
                    'message' => 'OK. (' . count($data) . '/' . count($applied) . ')',
                    'applied_products' => $jsonVariable,
                    'server_unix_time' => time()
                ]));
                return;

            }

        }
        redirect();
    }
    public function updatePinabiProducts() {
        $this->load->library('pinabi');
        $epinProductList = $this->pinabi->productList();
        $data = $this->db->where('attribution_name','pinabi')->get('attribution_jobs')->result();
        foreach($data as $item):
            $item->json = json_decode($item->json);
            $targetCategory = array_search($item->json->opposite_category,array_column($epinProductList,'id'));
            $targetProduct = array_search($item->json->opposite_product,array_column($epinProductList[$targetCategory]->productList,'id'));
            $product = $epinProductList[$targetCategory]->productList[$targetProduct];
            $currentProduct = $this->db->where('id', $item->product_id)->get('products')->row();
            $price = $currentProduct->price;
            if ($product->price >= $item->json->opposite_product_price) {
                $price = ($product->price + ($product->price * ($item->json->marj_percent_float / 100)));
            }
            $this->db->update('products', [
                'is_stock' => ($item->json->auto_stock == 1 ? ($product->stock > 0 ? 1 : 0) : $item->is_stock),
                'price' => $price,
                'arrival_price' => $product->price,
                'api_json' => json_encode([
                    'attribution' => 'turkpin',
                    'opposite_category' => $item->json->opposite_category,
                    'opposite_product' => $item->json->opposite_product,
                    'opposite_product_name' => $product->name,
                    'opposite_product_price' => $product->price,
                    'opposite_current_stock' => $product->stock,
                    'price' => $price,
                    'marj_percent_float' => $item->json->marj_percent_float,
                    'marj_percent' => $item->json->marj_percent,
                    'auto_stock' => $item->json->auto_stock,
                    'is_topup' => $product->type == 'topup' ? 1:0
                ]),
                'api_last_updated_at' => date('Y-m-d H:i:s')
            ], [
                'id' => $item->product_id,
                'is_api' => 1
            ]);
            $jsonVariable[] = $this->db->where([
                'id' => $item->product_id
            ])->get('products')->row();
            $applied[] = $item->id;
        endforeach;
        if (count($applied) > 0) {
            $this->db->where_in('id', $applied)->delete('attribution_jobs');
        }

        $this->output->set_content_type('application/json')->set_output(json_encode([
            'error' => FALSE,
            'message' => 'OK. (' . count($data) . '/' . count($applied) . ')',
            'applied_products' => $jsonVariable,
            'server_unix_time' => time()
        ]));
        return;
    }
    public function finishedDeactivePaymentLog() {
        if (!in_array(getIPAddress(), $this->ips)) {
            $this->load->view('error404');
            return;
        }

        if (isset($_GET['q'])) {

            if (md5('vg_990x1-') == $this->input->get('q', TRUE)) {

                $applied = [];

                // get waiting
                $data = $this->db->where([
                    'is_active' => 0,
                    'is_okay' => 0
                ])->get('payment_log')->result();

                if(count($data)>0){

                    foreach($data as $_item):
                        if (time()-strtotime($_item->created_at) > (60*30)) {
                            $applied[] = $_item->id;
                        }
                    endforeach;

                }

                $this->db->where_in('id', $applied)->delete('payment_log');

                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'error' => FALSE,
                    'message' => 'OK. (' . count($data) . '/' . count($applied) . ')',
                    'server_unix_time' => time()
                ]));
                return;

            }

        }
        redirect();
    }

    public function delete_sessions_files() {
        $deletedCount = 0;
        $this->load->helper('directory');
        $cacheFolder = APPPATH . '/cache/sessions';
        $map = directory_map($cacheFolder, 1, FALSE);
        foreach($map as $m):
            if($m != 'index.html' && $m != 'sessions\\') {
                unlink($cacheFolder . '/' . $m);
                $deletedCount++;
            }
        endforeach;
        exit(json_encode([
            'error' => FALSE,
            'message' => $deletedCount . ' adet önbellek(cache) başarıyla temizlendi.'
        ]));
    }
}
