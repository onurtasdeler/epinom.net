<?php

class Categories extends CI_Model
{
    
    public $tableName = "categories";

    function __construct(){
        parent::__construct();
    }

    function getOne($whereArray){
        $whereArray["is_active"] = 1;
        return $this->db->where($whereArray)->get($this->tableName)->row();
    }

    function getAll($whereArray = null, $limit = null, $order_by = 'id DESC'){
        if($limit != null){
            $this->db->limit($limit);
        }
        if($whereArray != null){
            $this->db->where($whereArray);
        }
        $this->db->order_by($order_by);
        $whereArray["is_active"] = 1;
        return $this->db->get($this->tableName)->result();
    }

}
