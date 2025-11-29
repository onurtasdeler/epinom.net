<?php

class Products_model extends CI_Model
{
    
    public $tableName = "products";

    function __construct(){
        parent::__construct();
    }

    function getOne($whereArray){
        return $this->db->where($whereArray)->get($this->tableName)->row();
    }

    function getAll($whereArray = null, $limit = null){
        if($limit != null){
            $this->db->limit($limit);
        }
        if($whereArray != null){
            $this->db->where($whereArray);
        }
        return $this->db->get($this->tableName)->result();
    }

}
