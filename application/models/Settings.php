<?php

class Settings extends CI_Model
{
    
    public $tableName = "config";

    function __construct(){
        parent::__construct();
    }

    function getOne($which){
        return $this->db->where([
            "id" => 1
        ])->get($this->tableName)->row()->$which;
    }
    
    function getRow(){
        return $this->db->where([
            "id" => 1
        ])->get($this->tableName)->row();
    }

}
