<?php

class Steps_model extends CI_Model{

    public $tableName = 'user_steps';

    public function __construct(){
        parent::__construct();
    }

    function insertUserStep($arr = array()){
        $this->db->insert($this->tableName, $arr);
        return $this->db->insert_id();
    }

    function deleteUserStep($whereArray = array()){
        return $this->db->delete($this->tableName,  $whereArray);
    }

    function getUserSteps($whereArray = array()){
        return $this->db->where($whereArray)->get($this->tableName)->result();
    }

}