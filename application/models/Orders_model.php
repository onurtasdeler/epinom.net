<?php

class Orders_model extends CI_Model
{

    public $tableName = "orders";

    function __construct(){
        parent::__construct();
    }

    function getOne($whereArray){
        return $this->db->where($whereArray)->get($this->tableName)->row();
    }

    function getAll($whereArray = null, $limit = null, $orderby = null){
        if($orderby != null){
            $this->db->order_by($orderby);
        }
        if($limit != null){
            $this->db->limit($limit);
        }
        if($whereArray != null){
            $this->db->where($whereArray);
        }
        return $this->db->get($this->tableName)->result();
    }

    function insertOrder($setArray = array()){
        $this->db->insert($this->tableName, $setArray);
        return $this->db->insert_id();
    }

}
