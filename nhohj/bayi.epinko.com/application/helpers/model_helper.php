<?php

//save
function save($table,$data,$kontrolField,$uniqField="",$uniqValue="",$imageField="",$imageValue=""){
    $t=&get_instance();
    $getModule=getTableSingle($table,array($kontrolField => $data[$kontrolField]));
    if($getModule) {
        return 2;
    }else {
        if($uniqField){
            $guncelle=$t->m_tr_model->updateTable($table,array($uniqField => $uniqValue),array());
        }
        if($imageField){
            array_push($data,$imageField,$imageValue);
        }
        $save=$t->m_tr_model->add_new($data,$table);
        if($save){
            return 1;
        }else{
            return 3;
        }
    }
}

//update
function update($table,$data,$dataDefault,$kontrolField,$uniqField,$uniqValue){
    $t=&get_instance();
    $control="";
    if($kontrolField!=""){
        if($dataDefault->$kontrolField!=$data[$kontrolField]){
            $control=getTableSingle($table,array($kontrolField => $data[$kontrolField]));
        }
    }

    if($control){
        return 2;
    }else{
        if($uniqField){
            $guncelle=$t->m_tr_model->updateTable($table,array($uniqField => $uniqValue),array());
        }
        $update=$t->m_tr_model->updateTable($table,$data,array($kontrolField => $dataDefault->$kontrolField));
        if($update){
            return 1;
        }else{
            return 3;
        }
    }
}

//get record ajax
function getRecord($table,$returnField,$postData){
    if ($postData) {
        $kontrol = getTableSingle($table,array("id" => $postData));
        if ($kontrol) {
            return $kontrol->$returnField;
        }else {
            return false;
        }
    }
}

//table get result
function getTable($table,$where=array()){
    $t =&get_instance();
    $t->load->model("m_tr_model");
    $cek=$t->m_tr_model->getTable($table,$where);
    if($cek){
        return $cek;
    }else{
        return false;
    }
}

//table get result order
function getTableOrder($table,$where=array(),$order,$order_type){
    $t =&get_instance();
    $t->load->model("m_tr_model");
    $cek=$t->m_tr_model->getTableOrder($table,$where,$order,$order_type);
    if($cek){
        return $cek;
    }else{
        return false;
    }
}

//table get row single
function getTableSingle($table,$where=array()){
    $t =&get_instance();
    $t->load->model("m_tr_model");
    $cek=$t->m_tr_model->getTableSingle($table,$where);
    if($cek){
        return $cek;
    }else{
        return false;
    }
}

//database connect
function databaseConnect($host,$user,$pass,$database){
    $db['site'] = array(
        'dsn'	=> '',
        'hostname' => $host,
        'username' => $user,
        'password' => $pass,
        'database' => $database,
        'dbdriver' => 'mysqli',
        'dbprefix' => '',
        'pconnect' => FALSE,
        'db_debug' => FALSE,
        'autoinit' => FALSE,
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_turkish_ci',
        'swap_pre' => '',
        'encrypt' => FALSE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => array(),
        'save_queries' => TRUE
    );
    return $db['site'];
}

function getOnEk(){
    $t=&get_instance();
    $t->load->model("m_tr_model");
    $tables = $t->m_tr_model->list_tables();
    $control=1;
    $exp="";
    foreach ($tables as $table) {
        if($control=1){
            $exp=explode("_",$table);
        }
        break;
    }
    return $exp[0];
}

function updateRecord($table,$data,$where,$type){
    $t =&get_instance();
    $t->load->model("m_tr_model");
    $cek=$t->m_tr_model->updateTable($table,$where,$type);
    if($cek){
        return $cek;
    }else{
        return false;
    }
}

function getLastOrder($tables,$where=""){
    $t =&get_instance();
    $t->load->model("m_tr_model");
    $cek=$t->m_tr_model->queryRow("select * from ".$tables." ".$where." order by order_id desc limit 1");
    if($cek){
        $islem=$cek->order_id+1;
        return $islem;
    }else{
        return 1;
    }
}

function orderChange($tables,$types,$id,$parent="",$galeri=""){
    $t =&get_instance();
    if($types=="up"){
        if($parent==""){
            if($galeri){
                $cek = getTableSingle($tables, array("id" =>$id));
                if ($cek->order_id != 1) {
                    $islem = $cek->order_id - 1;
                    $cekOnceki = getTableSingle($tables, array("order_id" => $islem,"hizmet_id" => $galeri));
                    if ($cekOnceki) {
                        $guncelle = $t->m_tr_model->updateTable($tables, array("order_id" => $cek->order_id), array("id" => $cekOnceki->id));
                        if ($guncelle) {
                            $guncelle = $t->m_tr_model->updateTable($tables, array("order_id" => $islem), array("id" => $cek->id));
                        }
                    }
                }
            }else{
                $cek = getTableSingle($tables, array("id" =>$id));
                if ($cek->order_id != 1) {
                    $islem = $cek->order_id - 1;
                    $cekOnceki = getTableSingle($tables, array("order_id" => $islem));
                    if ($cekOnceki) {
                        $guncelle = $t->m_tr_model->updateTable($tables, array("order_id" => $cek->order_id), array("id" => $cekOnceki->id));
                        if ($guncelle) {
                            $guncelle = $t->m_tr_model->updateTable($tables, array("order_id" => $islem), array("id" => $cek->id));
                        }
                    }
                }
            }
        }else{
            $cek = getTableSingle($tables, array("id" =>$id));
            if ($cek->order_id != 1) {
                $islem = $cek->order_id - 1;
                $cekOnceki = getTableSingle($tables, array("order_id" => $islem,"parent" => $parent));
                if ($cekOnceki) {
                    $guncelle = $t->m_tr_model->updateTable($tables, array("order_id" => $cek->order_id), array("id" => $cekOnceki->id));
                    if ($guncelle) {
                        $guncelle = $t->m_tr_model->updateTable($tables, array("order_id" => $islem), array("id" => $cek->id));
                    }
                }
            }
        }
    }else{
        if($parent==""){
            if($galeri){
                $cek = getTableSingle($tables, array("id" => $id));
                if ($cek) {
                    $son = $t->m_tr_model->query("select * from ".$tables." where hizmet_id=".$galeri." order by order_id asc");
                    $sin = 0;
                    foreach ($son as $item) {
                        $sin = $item->order_id;
                    }
                    if ($cek->order_id != $sin) {
                        $islem = $cek->order_id + 1;
                        $cekOnceki = getTableSingle($tables, array("order_id" => $islem,"hizmet_id" => $galeri));
                        if ($cekOnceki) {
                            $guncelle = $t->m_tr_model->updateTable($tables, array("order_id" => $cek->order_id), array("id" => $cekOnceki->id));
                            if ($guncelle) {
                                $guncelle = $t->m_tr_model->updateTable($tables, array("order_id" => $islem), array("id" => $cek->id));
                            }
                        }
                    }
                }
            }else{
                $cek = getTableSingle($tables, array("id" => $id));
                if ($cek) {
                    $son = $t->m_tr_model->query("select * from ".$tables." order by order_id asc");
                    $sin = 0;
                    foreach ($son as $item) {
                        $sin = $item->order_id;
                    }
                    if ($cek->order_id != $sin) {
                        $islem = $cek->order_id + 1;
                        $cekOnceki = getTableSingle($tables, array("order_id" => $islem));
                        if ($cekOnceki) {
                            $guncelle = $t->m_tr_model->updateTable($tables, array("order_id" => $cek->order_id), array("id" => $cekOnceki->id));
                            if ($guncelle) {
                                $guncelle = $t->m_tr_model->updateTable($tables, array("order_id" => $islem), array("id" => $cek->id));

                            }
                        }
                    }
                }
            }

        }else{

            $cek = getTableSingle($tables, array("id" => $id));
            if ($cek) {
                $son = $t->m_tr_model->query("select * from ".$tables." where parent=".$parent." order by order_id asc");
                $sin = 0;
                foreach ($son as $item) {
                    $sin = $item->order_id;
                }
                if ($cek->order_id != $sin) {
                    $islem = $cek->order_id + 1;
                    $cekOnceki = getTableSingle($tables, array("order_id" => $islem,"parent" => $parent));
                    if ($cekOnceki) {
                        $guncelle = $t->m_tr_model->updateTable($tables, array("order_id" => $cek->order_id), array("id" => $cekOnceki->id));
                        if ($guncelle) {
                            $guncelle = $t->m_tr_model->updateTable($tables, array("order_id" => $islem), array("id" => $cek->id));
                        }
                    }
                }
            }
        }
    }
}