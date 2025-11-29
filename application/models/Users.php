<?php
/**
 * @property Users $users
 */
class Users extends CI_Model
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

    function addUser($array){
        return $this->db->insert($this->tableName, $array);
    }

    function updateUser($array = array(), $whereArray = array()){
        return $this->db->update($this->tableName, $array, $whereArray);
    }

    function updateHash($whereArray){
        $hash = generateUserHash();
        $this->db->where($whereArray)->update($this->tableName, [
            "user_hash" => $hash
        ]);
        return $hash;
    }

    function userActivated($whereArray){
        return $this->db->where($whereArray)->update($this->tableName, [
            "activation_status" => 1
        ]);
    }

}
