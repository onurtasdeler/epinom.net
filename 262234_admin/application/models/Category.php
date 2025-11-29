<?php

class Category extends CI_Model
{
    
    public $tableName = "categories";

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

    function insertCategory($array = array()){
        return $this->db->insert($this->tableName, $array);
    }

    function updateCategory($array = array(), $whereArray = array()){
        return $this->db->where($whereArray)->update($this->tableName, $array);
    }

    function deleteCategory($whereArray = array()){
        return $this->db->delete($this->tableName, $whereArray);
    }

}
