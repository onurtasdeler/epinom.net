<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if(!getActiveUser()){
            redirect("login");
            exit;
        }
    }

    public function Index()
    {
        $this->List();
    }

    public function List()
    {
        $viewData = [
            'comments' => $this->db->get('comments')->result()
        ];
        $this->load->view('pages/comments/list', (object)$viewData);
    }

    public function Edit($id = null)
    {
        $comment = $this->db->where([
            'id' => $id
        ])->get('comments')->row();

        if (!isset($comment->id)) {
            redirect('comments');
            return;
        }

        if(isset($_GET['delete'])):
            $this->db->delete('comments', [
                'id' => $comment->id
            ]);
            redirect('comments');
            return;
        endif;

        if(isset($_GET['accept'])):
            $this->db->update('comments', [
                'status' => 1
            ], [
                'id' => $comment->id
            ]);
            redirect('comments');
            return;
        endif;

        if(isset($_GET['decline'])):
            $this->db->update('comments', [
                'status' => 2
            ], [
                'id' => $comment->id
            ]);
            redirect('comments');
            return;
        endif;
    }

}