<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stocks extends CI_Controller
{

    function __construct(){
        parent::__construct();
        $this->load->model("stock_pool_model");
        if(!getActiveUser()){
            redirect("login");
            exit;
        }
    }

    function index(){
        $this->list();
    }

    function list(){
        $pool = $this->stock_pool_model->getAll([
            'is_sold' => 0
        ]);
        if(isset($_GET['get_sold_items'])){
            $pool = $this->stock_pool_model->getAll([
                'is_sold' => 1
            ]);
        }
        $viewData = [
            "pool" => $pool
        ];
        $this->load->view('pages/stock_pool/list', (object)$viewData);
    }

    function insert(){
        $viewData = [];
        if(isset($_POST["submitForm"])):
            $form_rules = [
                [
                    'field' => 'product',
                    'label' => 'Ürün',
                    'rules' => 'required|trim|integer'
                ],
                [
                    'field' => 'codeArea',
                    'label' => 'Ürün',
                    'rules' => 'required|trim|is_unique[stock_pool.code]'
                ]
            ];
            $this->form_validation->set_rules($form_rules);

            if ($this->form_validation->run() == TRUE){
                $this->stock_pool_model->insertStock([
                   'code' => $_POST['codeArea'],
                   'product_id' => $this->input->post('product', TRUE)
                ]);
                if($this->db->insert_id()){
                    $viewData['alert'] = [
                        'class' => 'success',
                        'message' => 'Başarıyla eklendi. Yönlendiriliyorsunuz...'
                    ];
                    header("Refresh:2;url=" . base_url('stocks'));
                }else{
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => 'Stok havuza eklenemedi.'
                    ];
                }
            }else{
                $viewData['form_error'] = TRUE;
            }
        endif;
        $this->load->view('pages/stock_pool/insert', (object)$viewData);
    }

    function edit($sid = null){
        if($sid == null){
            redirect('stocks');
            return;
        }

        $stockItem = $this->stock_pool_model->getOne([
            'id' => $sid
        ]);
        if(!isset($stockItem->id)){
            redirect('stocks');
            return;
        }

        if(isset($_GET['delete'])){
            if($stockItem->is_sold == 0){
                $this->stock_pool_model->deleteStock([
                   'id' => $sid
                ]);
                redirect('stocks');
                return;
            }
        }

        $viewData = [
            "stockItem" => $stockItem
        ];

        if(isset($_POST["submitForm"])):
            $form_rules = [
                [
                    'field' => 'product',
                    'label' => 'Ürün',
                    'rules' => 'required|trim|integer'
                ],
                [
                    'field' => 'codeArea',
                    'label' => 'Ürün',
                    'rules' => 'required|trim'
                ],
                [
                    'field' => 'soldStatus',
                    'label' => 'Satılma Durumu',
                    'rules' => 'required|trim|integer'
                ]
            ];
            $this->form_validation->set_rules($form_rules);

            if ($this->form_validation->run() == TRUE){
                $userID = $stockItem->user_id;
                if($this->input->post('soldStatus', TRUE) == 0){
                    $userID = null;
                }
                $this->stock_pool_model->updateStock([
                    'code' => $_POST['codeArea'],
                    'product_id' => $this->input->post('product', TRUE),
                    'is_sold' => $this->input->post('soldStatus', TRUE) == 1 ? 1 : 0,
                    'user_id' => $userID
                ],[
                    'id' => $stockItem->id
                ]);
                if($this->db->affected_rows()>0){
                    $viewData['alert'] = [
                        'class' => 'success',
                        'message' => 'Başarıyla güncellendi. Sayfa yenileniyor...'
                    ];
                    header("Refresh:2;url=" . current_url());
                }else{
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => 'Stok havuza eklenemedi.'
                    ];
                }
            }else{
                $viewData['form_error'] = TRUE;
            }
        endif;

        $this->load->view('pages/stock_pool/edit', (object)$viewData);
    }

    function insertmulti(){
        $viewData = [];
        if(isset($_POST["submitForm"])):
            $form_rules = [
                [
                    'field' => 'product',
                    'label' => 'Ürün',
                    'rules' => 'required|trim|integer'
                ],
                [
                    'field' => 'codeArea',
                    'label' => 'Ürün',
                    'rules' => 'required|trim'
                ]
            ];
            $this->form_validation->set_rules($form_rules);

            if ($this->form_validation->run() == TRUE){

                $added = [];
                foreach(explode("\n", $_POST['codeArea']) as $s_item):
                    $this->stock_pool_model->insertStock([
                        'code' => $s_item,
                        'product_id' => $this->input->post('product', TRUE)
                    ]);
                    if($this->db->insert_id()){
                        $added[] = $this->db->insert_id();
                    }
                endforeach;

                if (count($added) > 0) {
                    $viewData['alert'] = [
                        'class' => 'success',
                        'message' =>  count($added) . ' adet başarıyla eklendi. Yönlendiriliyorsunuz...'
                    ];
                    header("Refresh:2;url=" . base_url('stocks'));
                } else {
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => 'Hiç stok eklenemedi.'
                    ];
                }

            }else{
                $viewData['form_error'] = TRUE;
            }
        endif;
        $this->load->view('pages/stock_pool/insert_multi', (object)$viewData);
    }
}
