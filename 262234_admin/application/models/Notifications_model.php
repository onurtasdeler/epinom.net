<?php

class Notifications_model extends CI_Model
{
    
    public $tableName = "notifications";

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
    
    function addItem($arr = array()){
        return $this->db->insert($this->tableName, $arr);
    }
    function updateItem($arr = array(), $whereArray = array()){
        return $this->db->where($whereArray)->update($this->tableName, $arr);
    }
    function deleteItem($whereArray = array()){
        return $this->db->delete($this->tableName, $whereArray);
    }

}
