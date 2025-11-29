<?php

class Orders_model extends CI_Model
{
    
    public $tableName = "orders";

    function __construct(){
        parent::__construct();
    }
    
    function updateOrder($updateArray, $whereArray = array()){
        return $this->db->where($whereArray)->update($this->tableName, $updateArray);
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
