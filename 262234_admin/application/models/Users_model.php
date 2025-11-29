<?php

class Users_model extends CI_Model
{
    
    public $tableName = "users";

    function __construct(){
        parent::__construct();
    }

    function getUser($whereArray){
        return $this->db->where($whereArray)->get($this->tableName)->row();
    }

    function getUsers($whereArray = null, $limit = null){
        if($limit != null){
            $this->db->limit($limit);
        }
        if($whereArray != null){
            $this->db->where($whereArray);
        }
        return $this->db->get($this->tableName)->result();
    }

    function updateUser($array = array(), $whereArray = array()){
        return $this->db->where($whereArray)->update($this->tableName, $array);
    }

}
