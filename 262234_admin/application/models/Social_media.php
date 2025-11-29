<?php

class Social_media extends CI_Model
{
    
    public $tableName = "social_media";

    function __construct(){
        parent::__construct();
    }

    function getOne($whereArray){
        return $this->db->where($whereArray)->get($this->tableName)->row();
    }

    function deleteItem($whereArray){
        return $this->db->delete($this->tableName, $whereArray);
    }

    function insertItem($array){
        return $this->db->insert($this->tableName, $array);
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
