<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Specialfields extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if(!getActiveUser()){
            redirect("login");
            exit;
        }
    }

    function index()
    {
        redirect('products');
    }

    function product($product_id = NULL){
        if ($product_id) {
            $product = $this->db->where([
                'id' => $product_id
            ])->get('products')->row();

            if(!isset($product->id)):
                redirect();
                return;
            endif;

            if (isset($_GET['sf_id']) && isset($_GET['delete'])):
                $this->db->delete('product_special_fields', [
                    'id' => $this->input->get('sf_id', TRUE)
                ]);
                redirect('specialfields/product/' . $product->id);
                return;
            endif;

            $product_special_fields = $this->db->where([
                'product_id' => $product->id
            ])->get('product_special_fields')->result();

            $viewData = [
                'product' => $product,
                'product_special_fields' => $product_special_fields
            ];
            $this->load->view('pages/product_special_fields/list', (object)$viewData);
            return;
        }
        redirect();
        return;
    }

    function insert($product_id = NULL){
        if ($product_id) {
            $product = $this->db->where([
                'id' => $product_id
            ])->get('products')->row();

            if(!isset($product->id)):
                redirect();
                return;
            endif;

            $viewData = [
                'product' => $product
            ];

            if (isset($_POST['submitForm'])):
                $insertArray = [
                    'label' => $this->input->post('label', TRUE),
                    'name' => permalink($this->input->post('label', TRUE), ['delimiter' => '_']),
                    'input_type' => $this->input->post('input_type', TRUE),
                    'required' => $this->input->post('required', TRUE),
                    'product_id' => $product->id
                ];
                if ($this->input->post('input_type', TRUE) == 'select') {
                    $selectOptions = array();
                    foreach(explode(',', $this->input->post('select_options', TRUE)) as $_so):
                        if (!empty($_so)) {
                            $selectOptions[] = [
                                'name' => $_so,
                                'value' => $_so
                            ];
                        }
                    endforeach;
                    $insertArray['select_options'] = json_encode($selectOptions);
                }

                $this->db->insert('product_special_fields', $insertArray);

                if ($this->db->insert_id()) {
                    $viewData['alert'] = [
                        'class' => 'success',
                        'message' => 'Özel alan başarıyla eklendi.'
                    ];
                    header('Refresh:2;url=' . base_url('specialfields/product/' . $product->id));
                } else {
                    $viewData['alert'] = [
                        'class' => 'danger',
                        'message' => 'Eklenemedi.'
                    ];
                }
            endif;

            $this->load->view('pages/product_special_fields/insert', (object)$viewData);
            return;
        }
        redirect();
        return;
    }

}