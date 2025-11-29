<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PageController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("functions_helper");
        $this->load->helper("user_helper");
    }
    public function index($slug)
    {
        if ($this->uri->segment(1)) {
            if ($this->uri->segment(1) == "en") {
                $page = $this->db->get_where('table_pages', array('seflink_en' => $slug, 'status' => 1))->row();
            } else {
                $page = $this->db->get_where('table_pages', array('seflink_tr' => $slug, 'status' => 1))->row();
            }
        } else {
            $page = $this->db->get_where('table_pages', array('seflink_tr' => $slug, 'status' => 1))->row();
        }
        

        if (!$page) {
            show_404();
        }

        $data['page'] = $page;
        $this->load->view('page/page_view', $data);
    }
}
