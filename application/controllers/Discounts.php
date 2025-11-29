<?php


class Discounts extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function Index() {
        $viewData = [
            'categories' => $this->db->query("SELECT * FROM categories WHERE id IN(SELECT category_id FROM products WHERE discount>0 AND is_active = 1)")->result()
        ];
        $this->load->view('pages/discounts/index', (object)$viewData);
    }

}