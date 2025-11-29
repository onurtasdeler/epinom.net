<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Comments extends CI_Controller

{



    public function __construct()

    {

        parent::__construct();

        $this->load->helper("functions_helper");

        $this->load->helper("user_helper");

    }

    public function get_yorumlar()

    {

        header('Content-Type: application/json');



        $cat_id = (int)$this->input->get('cat_id');

        $page = (int)$this->input->get('page');

        $per_page = 10;

        $offset = ($page - 1) * $per_page;



        $this->db->where('cat_id', $cat_id);

        $this->db->from('table_comments');

        $total_rows = $this->db->count_all_results();



        $total_pages = ceil($total_rows / $per_page);



        $this->db->select('av.image AS avi, p.id AS urun_id, us.nick_name AS user_name, s.puan, s.comment AS cc, s.created_at AS ft, s.cat_id');

        $this->db->from('table_comments s');

        $this->db->join('table_orders o', 's.order_id = o.id', 'left');

        $this->db->join('table_products p', 'o.product_id = p.id', 'left');

        $this->db->join('table_users us', 's.user_id = us.id', 'left');

        $this->db->join('table_avatars av', 'us.avatar_id = av.id', 'left');

        $this->db->join('table_products_category c', 'p.category_id = c.id', 'left');

        $this->db->where('s.status', 2);

        $this->db->where('s.is_yayin', 1);

        $this->db->group_start();

        $this->db->where('c.id', $cat_id);

        $this->db->or_where('s.cat_id', $cat_id);

        $this->db->group_end();

        $this->db->limit($per_page, $offset);



        $yorumlar = $this->db->get()->result();



        echo json_encode([

            'totalPages' => $total_pages,

            'comments' => $yorumlar

        ]);

    }

}

