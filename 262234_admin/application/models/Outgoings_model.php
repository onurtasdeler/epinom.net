<?php

class Outgoings_model extends CI_Model
{

    public $tableName = "outgoings";

    function __construct(){
        parent::__construct();
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
        return $this->db->get($this->tableName)->result();
    }

    function updateOutgoings($arr = array(), $whereArray = array()){
        return $this->db->where($whereArray)->update($this->tableName, $arr);
    }

    function insertOutgoings($arr = array()){
        return $this->db->insert($this->tableName, $arr);
    }

    function deleteOutgoings($arr = array()){
        return $this->db->delete($this->tableName, $arr);
    }

    function searchOutgoings($value){
        return $this->db->like('name', $value)->select('id')->get('outgoings')->result_array();
    }
    function totalOutgoings($searchResults){
        if($searchResults = "-1"){
            return $this->db->from("outgoings")->count_all_results();
        }
        else{
            return $this->db->where_in('id',$searchResults)->from("outgoings")->count_all_results();
        }
    }
}
