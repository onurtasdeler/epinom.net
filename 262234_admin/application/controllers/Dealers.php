<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dealers extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if(!getActiveUser()){
            redirect("login");
            exit;
        }
    }

    function list($user_id = NULL)
    {
        if ($user_id) {
            $viewData = [
                'user' => $this->db->where([
                    'id' => $user_id
                ])->get('users')->row(),
                'dealer_categories' => $this->db->where([
                    'user_id' => $user_id
                ])->get('dealer_categories')->result()
            ];
            $this->load->view('pages/dealers/list', (object)$viewData);
            return;
        }
        redirect();
    }

    function insert($user_id = NULL)
    {
        if ($user_id) {
            $viewData = [
                'user' => $this->db->where([
                    'id' => $user_id
                ])->get('users')->row()
            ];

            if (isset($_POST['submitForm'])) {
                if ($this->db->where([
                        'category_id' => $this->input->post('category_id', TRUE),
                        'user_id' => $user_id
                    ])->get('dealer_categories')->num_rows() == 0) {
                    $this->db->insert('dealer_categories', [
                        'category_id' => $this->input->post('category_id', TRUE),
                        'user_id' => $user_id
                    ]);
                    if ($this->db->insert_id()) {
                        $viewData['alert'] = [
                            'class' => 'success',
                            'message' => 'Eklendi.'
                        ];
                        header('Refresh:2;url=' . base_url('dealers/' . $user_id . '/list'));
                    } else {
                        $viewData['alert'] = [
                            'class' => 'danger',
                            'message' => 'Eklenirken sorun oluştu.'
                        ];
                    }
                }else {
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => 'Daha önce eklenmiş.'
                    ];
                }
            }

            $this->load->view('pages/dealers/insert', (object)$viewData);
            return;
        }
        redirect();
    }

    function view($id)
    {
        if ($id) {
            $dealer_category = $this->db->where([
                'id' => $id
            ])->get('dealer_categories')->row();

            if(!isset($dealer_category->id)) {
                redirect();
                return;
            }

            if (isset($_GET['delete'])) {
                $this->db->delete('dealer_categories', [
                    'id' => $id
                ]);
                $this->db->delete('dealer_products', [
                    'dealer_category_id' => $id
                ]);
                redirect('dealers/' . $dealer_category->user_id . '/list');
                return;
            }

            $category = $this->db->where('id', $dealer_category->category_id)->get('categories')->row();
            $products = $this->db->where([
                'category_id' => $category->id,
                'is_active' => 1
            ])->get('products')->result();

            foreach($products as $_product) {
                if ($this->db->where([
                        'dealer_category_id' => $dealer_category->id,
                        'category_id' => $category->id,
                        'product_id' => $_product->id,
                        'user_id' => $dealer_category->user_id
                    ])->get('dealer_products')->num_rows() == 0) {
                    $this->db->insert('dealer_products', [
                        'dealer_category_id' => $dealer_category->id,
                        'category_id' => $category->id,
                        'product_id' => $_product->id,
                        'user_id' => $dealer_category->user_id,
                        'price' => $_product->price,
                        'percent' => 0
                    ]);
                }
            }

            $dealer_products = $this->db->where([
                'dealer_category_id' => $dealer_category->id,
                'category_id' => $category->id,
                'user_id' => $dealer_category->user_id
            ])->get('dealer_products')->result();

            $viewData = [
                'dealer_category' => $dealer_category,
                'dealer_products' => $dealer_products,
                'category' => $category,
                'products' => $products,
                'user' => $this->db->where('id', $dealer_category->user_id)->get('users')->row()
            ];

            if (isset($_POST['submitForm'])) {
                $applied_count = 0;
                foreach($this->input->post('products', TRUE) as $_post_product) {
                    $this->db->update('dealer_products', [
                        'price' => $_post_product['price'],
                        'percent' => $_post_product['percent']
                    ], [
                        'id' => $_post_product['id']
                    ]);
                    if ($this->db->affected_rows() > 0) {
                        $applied_count++;
                    }
                }
                $viewData['alert'] = [
                    'class' => 'success',
                    'message' => 'Güncelleme başarılı. (' . count($_POST['products']) . '/' . $applied_count . ') güncellendi.'
                ];
                header('Refresh:2;url=' . current_url());
            }

            $this->load->view('pages/dealers/view', (object)$viewData);
            return;
        }
        redirect();
    }

}