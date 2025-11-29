<?php

class Helpdesk_model extends CI_Model
{

    public $tableName = "help_desk";
    public $messagesTableName = "help_desk_messages";

    function __construct(){
        parent::__construct();
    }

    function updateDesk($updateArray, $whereArray = array()){
        return $this->db->where($whereArray)->update($this->tableName, $updateArray);
    }

    function deleteDesk($whereArray){
        return $this->db->where($whereArray)->delete($this->tableName);
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
        $this->db->order_by("is_active DESC");
        return $this->db->get($this->tableName)->result();
    }

    function insertMessage($arr){
        return $this->db->insert($this->messagesTableName, $arr);
    }

    function getMessages($whereArr = array()){
        return $this->db->where($whereArr)->get($this->messagesTableName)->result();
    }

}
