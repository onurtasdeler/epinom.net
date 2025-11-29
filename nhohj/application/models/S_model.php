<?php

class S_model extends CI_Model{



    public function __constrsuct(){
        parent::__construct();
        $this->db=$this->load->database("epinko",TRUE);
    }

    public function urun_liste($limit, $start)
    {
        return $this->db->limit($limit, $start)->order_by("name","asc")->get("bk_opt_s_product")->result();
    }
    public function blog_liste($limit, $start)
    {
        return $this->db->limit($limit, $start)->get("blog")->result();
    }

    public function lastt(){

    }
    public function urun_liste_kosul($limit, $start,$where)
    {
        return $this->db->order_by("name","asc")->get_where('bk_opt_s_product', $where, $limit, $start)->result();

    }
    public function blog_liste_kosul($limit, $start,$where=array())
    {
        return $this->db->order_by("id","asc")->get_where('blog', $where, $limit, $start)->result();

    } public function blog_liste_kosul_2($limit, $start,$where="")
{
    return $this->db->query("select * from blog where ".$where." order by order_id asc limit ".$start.",".$limit)->result();

}public function haber_liste_kosul($limit, $start,$where=array())
{
    return $this->db->order_by("id","asc")->get_where('bk_opt_s_haber', $where, $limit, $start)->result();

}

    public function pagination_liste_kosul($table,$limit, $start,$where=array(),$where_in="")
    {
        if($where_in){
            return $this->db->query("select * from ".$table." where ".$where_in." limit ".$start.",".$limit)->result();
        }else{
            return $this->db->order_by("order_id","asc")->get_where($table, $where, $limit, $start)->result();

        }
    }

    //Tablodaki tüm kayıtları çeker
    public function getAll($table){
        return $this->db->get($table)->result();
    }
    //Tablodaki tüm kayıtlı koşula göre getirir
    public function getTable($table,$where=array()){
        return $this->db->where($where)->get($table)->result();
    }
    public function getTableSingle($table,$where=array()){
        return $this->db->where($where)->get($table)->row();
    }
    //Tablodoki koşul sağlanmış tek kaydı getirir
    public function getRow($table,$where=array()){
        return $this->db->where($where)->get($table)->row();
    }
    //Tablodan kayıt siler
    public function delete($table,$where=array()){
        return $this->db->where($where)->delete($table);
    }

    public function last_id(){
        return $this->db->insert_id();
    }

    public function getTableOrder($table,$where=array(),$field,$value,$limit=0){
        if($limit == 0) {
            return $this->db->where($where)->order_by($field,$value)->get($table)->result();
        }else{
            return $this->db->where($where)->order_by($field,$value)->limit($limit)->get($table)->result();

        }
    }

    public function updateTable($table="",$data=array(),$where=array()){
        return $this->db->where($where)->update($table,$data);
    }

    public function add_new($data=array(),$table){
        $this->db->insert($table,$data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function add_new_lang($data=array()){
        return $this->db->insert($this->tableSeo,$data);
    }

    public function update($data=array(),$where=array()){
        return $this->db->where($where)->update($this->tableMain,$data);
    }

    public function make_query(){
        $table="stok_stok_main";
        $select_column=array("id","stok_name","stok_cas_no","stok_ozel_kod");
        $order_column=array(null,"stok_name",null,null);
        if(isset($_POST['search']["value"])){
            $this->db->like("stok_name",$_POST['search']["value"]);
        }
        if(isset($_POST['order'])){
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        }else{
            $this->db->order_by("id","DESC");
        }
    }

    function make_datatables(){
        $this->make_query();
        if($_POST["length"] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function get_filtered_data(){
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


    public function get($where){
        return $this->db->where($where)->get($this->tableMain)->result();
    }

    public function get_single($where=array()){
        return $this->db->where($where)->get($this->tableMain)->row();
    }

    public function query($query){
        $result=$this->db->query($query)->result();
        return $result;
    }

    public function queryRow($query){
        $result=$this->db->query($query)->row();
        return $result;
    }


    public function sum($table,$alan,$kosul){
        $result=$this->db->query("select sum(".$alan.") as sayi from ".$table." where ".$kosul)->row();
        return $result;
    }

    public function orderByGet($field,$kosul){
        return $this->db->order_by($field,$kosul)->get($this->tableMain)->result();
    }

    public function last_row($table=""){
        $last_row=$this->db->select('id')->order_by('id',"desc")->limit(1)->get($table)->row();
        return $last_row;
    }



    public function say(){
        return $this->db->count_all($this->tableMain);
    }

    public function imageDeleteTable($table,$where=array()){
        return $this->db->where($where)->delete($this->tableImage);
    }

    public function getLastId($table,$alan){
        $veri=$this->db->query("select max(id) as a from stok_sahis");
        return $veri;
    }
    public function getMax($field,$table,$where=array())
    {
        return get_object_vars( $this->db->select_max($field)->get($table)->row());
    }

    public function findProductByLangIdAndLink($langId, $link) {
        // JSON_CONTAINS ile sorgu oluştur

        // Sorguyu çalıştır
        $query = $this->db->query($sql, array( $link));

        // Sonuçları döndür
        return $query->result_array();
    }

}

?>
