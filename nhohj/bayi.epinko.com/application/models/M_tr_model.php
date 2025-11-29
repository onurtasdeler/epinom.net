<?php

class M_tr_model extends CI_Model
{


    public function __constrsuct()
    {
        parent::__construct();
        $this->db = $this->load->database("data_tr", TRUE);
    }

    //Tablodaki tüm kayıtları çeker
    public function getAll($table)
    {
        return $this->db->get($table)->result();
    }

    //Tablodaki tüm kayıtlı koşula göre getirir
    public function getTable($table, $where = array())
    {
        return $this->db->where($where)->get($table)->result();
    }

    public function getTableSingle($table, $where = array())
    {
        return $this->db->where($where)->get($table)->row();
    }

    //Tablodoki koşul sağlanmış tek kaydı getirir
    public function getRow($table, $where = array())
    {
        return $this->db->where($where)->get($table)->row();
    }

    //Tablodan kayıt siler
    public function delete($table, $where = array())
    {
        return $this->db->where($where)->delete($table);
    }

    public function last_id()
    {
        return $this->db->insert_id();
    }

    public function getTableOrder($table, $where = array(), $field, $value,$limit="")
    {
        if($limit){
            return $this->db->where($where)->order_by($field, $value)->limit($limit)->get($table)->result();
        }else{
            return $this->db->where($where)->order_by($field, $value)->get($table)->result();
        }

    }

    public function updateTable($table = "", $data = array(), $where = array())
    {
        return $this->db->where($where)->update($table, $data);
    }

    public function add_new($data = array(), $table)
    {
        $sonuc = $this->db->insert($table, $data);
        if ($sonuc) {
            $last_id = $this->db->insert_id();
            return $last_id;
        } else {
            return false;
        }
    }

    public function add_new_lang($data = array())
    {
        return $this->db->insert($this->tableSeo, $data);
    }

    public function update($data = array(), $where = array())
    {
        return $this->db->where($where)->update($this->tableMain, $data);
    }

    function make_datatables()
    {
        $this->make_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_data()
    {
        $this->db->select("*");
        $this->db->from("stok_stok_main");
        return $this->db->count_all_results();
    }


    public function get($where)
    {
        return $this->db->where($where)->get($this->tableMain)->result();
    }

    public function get_single($where = array())
    {
        return $this->db->where($where)->get($this->tableMain)->row();
    }

    public function query($query)
    {
        $result = $this->db->query($query)->result();
        return $result;
    }

    public function queryRow($query)
    {
        $result = $this->db->query($query)->row();
        return $result;
    }


    public function sum($table, $alan, $kosul)
    {
        $result = $this->db->query("select sum(" . $alan . ") as sayi from " . $table . " where " . $kosul)->row();
        return $result;
    }

    public function orderByGet($field, $kosul)
    {
        return $this->db->order_by($field, $kosul)->get($this->tableMain)->result();
    }

    public function last_row($table = "")
    {
        $last_row = $this->db->select('id')->order_by('id', "desc")->limit(1)->get($table)->row();
        return $last_row;
    }

    public function say()
    {
        return $this->db->count_all($this->tableMain);
    }

    public function imageDeleteTable($table, $where = array())
    {
        return $this->db->where($where)->delete($this->tableImage);
    }

    public function getLastId($table, $alan)
    {
        $veri = $this->db->query("select max(id) as a from stok_sahis");
        return $veri;
    }

    public function getMax($field, $table, $where = array())
    {
        return get_object_vars($this->db->select_max($field)->get($table)->row());
    }


}

?>
