<?php

class Helpdesk_model extends CI_Model
{
    
    public $tableName = "help_desk";

    function __construct(){
        parent::__construct();
    }

    function getUserItems($user_id, $limit = null){
        if($limit != null){
            $this->db->limit($limit['limit'], $limit['start']);
        }
        return $this->db->order_by("id DESC")->where([
            "user_id" => $user_id
        ])->get($this->tableName)->result();
    }

    function updateItem($arr, $whereArray){
        return $this->db->where($whereArray)->update($this->tableName, $arr);
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
        $whereArray["is_active"] = 1;
        return $this->db->get($this->tableName)->result();
    }

    function getMessages($desk_id){
        return $this->db->where([
            "desk_id" => $desk_id
        ])->get("help_desk_messages")->result();
    }

    function addMessage($arr = array()){
        return $this->db->insert('help_desk_messages', $arr);
    }

    function add($arr){
        return $this->db->insert($this->tableName, $arr);
    }

}
