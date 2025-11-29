<?php

class Pages_model extends CI_Model
{
    
    public $tableName = "pages";

    function __construct(){
        parent::__construct();
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
