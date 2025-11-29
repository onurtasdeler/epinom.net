<?php

class News_controller extends CI_Controller
{

    function __construct(){
        parent::__construct();
        $this->load->model("news");
        websiteStatus();
    }

    function index(){
        $this->All();
    }

    function Item($slug = null){
        if($slug){
            $item = $this->news->getOne([
                "slug" => $slug
            ]);

            if(!isset($item->id)){
                redirect("");
                return;
            }

            $viewData = [
                "item" => $item
            ];
            $this->load->view("pages/news/item", (object)$viewData);
            return;
        }
        redirect();
    }

    function All(){

        $this->load->library('pagination');

        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $config = array();
        $config['full_tag_open'] = '<ul class="pagination mb-0">';
        $config['full_tag_close'] = '</ul>';
        $config['attributes'] = ['class' => 'page-link'];
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['base_url'] = base_url('haberler');
        $config['per_page'] = 8;
        $news = $this->news->getAll(null, [
            'limit' => $config['per_page'],
            'start' => $page
        ]);
        $config['total_rows'] = count($this->db->where([
            'is_active' => 1
        ])->get('news')->result());

        $this->pagination->initialize($config);

        $viewData = [
            'news' => $news,
            'pagination_links' => $this->pagination->create_links()
        ];

        $this->load->view("pages/news/list", (object)$viewData);
    }

}
