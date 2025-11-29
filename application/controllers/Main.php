<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	
	public function __construct(){
		parent::__construct();
		$this->load->model("categories");
		$this->load->model("news");
		websiteStatus();
	}

	public function index()
	{
		$viewData = [
			"allCategories" => $this->categories->getAll([
			    'up_category_id' => 0,
                'is_active' => 1
            ], NULL),
            "popularCategories" => $this->categories->getAll([
				"is_popular" => 1,
                "is_active" => 1
			], $this->db->where('id', 1)->get('config')->row()->home_page_popular_count, 'popular_rank ASC, id DESC'),
            "menuCategories" => $this->categories->getAll([
				"is_menu" => 1
			], 7),
            "mainCategories" => $this->categories->getAll(['up_category_id' => 0, 'is_active' => 1], NULL, 'category_name ASC, id DESC'),
            "newCategories" => $this->categories->getAll(['is_new' => 1, 'is_active' => 1], 12, 'category_name ASC'),
            "homePageCategories" => $this->db->query("SELECT * FROM categories WHERE is_active=1 AND is_homepage=1 ORDER BY homepage_rank ASC, id DESC")->result(),
            "discountProducts" => $this->db->query("SELECT * FROM categories WHERE id IN(SELECT category_id FROM products WHERE discount > 0)")->result(),
			"latestNews" => $this->news->getAll([
			    'is_active' => 1
            ], ['limit' => 3, 'start' => 0]),
			"showSlider" => $this->db->where('id=1')->get('config')->row()->show_slider_on_home_page,
            "slides" => $this->db->where([
                'is_active' => 1,
                'slide_area' => 0
            ])->order_by('rank ASC, id DESC')->get('slider')->result(),
            "slides2" => $this->db->where([
                'is_active' => 1,
                'slide_area' => 1
            ])->order_by('rank ASC, id DESC')->get('slider')->result(),
            "slides3" => $this->db->where([
                'is_active' => 1,
                'slide_area' => 2
            ])->order_by('rank ASC, id DESC')->get('slider')->result(),
            "mainComments" => $this->db->where([
                'status' => 1
            ])->order_by('id DESC')->limit(5)->get('comments')->result(),
            "whatsappNo" => getConfig()->whatsapp_no
		];
		$this->load->view("main", (object)$viewData);
	}
}
