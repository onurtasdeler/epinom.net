<?php

class Pages extends CI_Controller
{
    
    function __construct(){
        parent::__construct();
        $this->load->model("pages_model");
        websiteStatus();
    }

    function Index($slug = null){
        $page = $this->pages_model->getPage([
            "slug" => $slug
        ]);
        
        if(!isset($page->id)):
            redirect();
            return;
        endif;

        $viewData = [
            "page" => $page
        ];
        $this->load->view("pages/pages/page", (object)$viewData);
    }

}
