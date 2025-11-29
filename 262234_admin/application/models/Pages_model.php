<?php

class Pages_model extends CI_Model
{
    
    public $tableName = "pages";

    function __construct(){
        parent::__construct();
    }

    function deletePage($whereArray = array()){
        return $this->db->delete($this->tableName, $whereArray);
    }
    
    function updatePage($updateArray, $whereArray = array()){
        return $this->db->where($whereArray)->update($this->tableName, $updateArray);
    }

    function insertPage($array){
        return $this->db->insert($this->tableName, $array);
    }

    function getPage($whereArray){
        return $this->db->where($whereArray)->get($this->tableName)->row();
    }

    function getPages($whereArray = null, $limit = null){
        if($limit != null){
            $this->db->limit($limit);
        }
        if($whereArray != null){
            $this->db->where($whereArray);
        }
        return $this->db->get($this->tableName)->result();
    }

}
