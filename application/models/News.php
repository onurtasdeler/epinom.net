<?php

class News extends CI_Model
{
    
    public $tableName = "news";

    function __construct(){
        parent::__construct();
    }

    function getOne($whereArray){
        return $this->db->where($whereArray)->get($this->tableName)->row();
    }

    function getAll($whereArray = null, $limit = null, $orderby = "id DESC"){
        if($limit != null){
            @$this->db->limit($limit['limit'], $limit['start']);
        }
        $whereArray['is_active'] = 1;
        $this->db->where($whereArray);
        $this->db->order_by($orderby);
        return $this->db->get($this->tableName)->result();
    }

}
