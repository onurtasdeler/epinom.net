<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron_turkpin extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->helper("functions_helper");
        $this->load->helper("user_helper");
    }

    public function auto_product_price_update($token=""){

        $cek=getTableSingle("options_general",array("id" => 1));
        if($cek->is_tedarik_job_stat==0){
            $urunler=$this->m_tr_model->query(" select id,turkpin_id,turkpin_urun_id from table_products where  is_api=1 and (turkpin_auto_stock=1 or turkpin_auto_price=1) and is_delete=0 order by id asc ");
            if($urunler) {

                foreach ($urunler as $urun) {
                    $ekle=$this->m_tr_model->add_new(array(
                        "product_id" => $urun->id,
                        "t_cat_id" => $urun->turkpin_id,
                        "t_pro_id"=> $urun->turkpin_urun_id,
                        "created_at" =>date("Y-m-d H:i:s"),
                    ),"t_tedarik_job");
                }
                $guncelle=$this->m_tr_model->updateTable("options_general" ,array("is_tedarik_job_stat" => 1),array("id" =>  1));
            }
        }else{
            try {
                $turkpin=new TurkPin();
                $api=1;
            }catch (Exception $Ex){
                $api=2;
            }
            if($api==1){
                $urunler=$this->m_tr_model->query("select * from t_tedarik_job  order by id asc limit 18");
                if($urunler){
                    foreach ($urunler as $item) {
                        $urun=getTableSingle("table_products",array("id" => $item->product_id));
                        if($urun){
                            $stok="";
                            $s="";
                            $price="";
                            $oyunlar = $turkpin->urunListesi($urun->turkpin_id);
                            if($oyunlar){
                                foreach ($oyunlar as $item2) {
                                    if($item2->id==$urun->turkpin_urun_id){
                                        $stok=$item2->stock;
                                        $s=str_replace(",",".",$item2->price);
                                        $price=floor($s*100)/100;
                                    }
                                }

                            }
                            if($urun->turkpin_auto_stock==1){
                                $guncelle=$this->m_tr_model->updateTable("table_products",array("turkpin_stok" => $stok),array("id" => $urun->id));
                            }

                            if($urun->turkpin_auto_price==1){
                                if($urun->turkpin_id==0){

                                }else{
                                    if($price){
                                        $fiyat=$price;
                                        $hesapla=0;
                                        $hesapla2=0;
                                        if($urun->is_discount==1 && $urun->discount!=0){
                                            if($urun->price_marj!="" && $urun->price_marj!=0){
                                                $hesapla=(($fiyat/100)*$urun->price_marj) + $fiyat;
                                                $hesapla=$hesapla*(100-$urun->discount)/100;
                                                $hesapla2=(($fiyat/100)*$urun->price_marj) + $fiyat;
                                            }else{
                                                $hesapla=$fiyat*(100-$urun->discount)/100;
                                                $hesapla2=$urun->price;
                                            }
                                        }else{
                                            if($urun->price_marj!="" && $urun->price_marj!=0){
                                                $hesapla2=(($fiyat/100)*$urun->price_marj) + $fiyat;
                                            }else{
                                                $hesapla2=$price;
                                            }
                                        }
                                    }

                                    $guncelle=$this->m_tr_model->updateTable("table_products",
                                        array("price" => $price,
                                            "price_sell_discount" => floor($hesapla*100)/100,
                                            "price_sell" => floor($hesapla2*100)/100),
                                        array("id" => $urun->id));
                                }
                            }
                            sleep(3);
                            $sil=$this->m_tr_model->delete("t_tedarik_job" ,array("id" => $item->id));
                        }else{
                            $sil=$this->m_tr_model->delete("t_tedarik_job" ,array("id" => $item->id));
                        }
                    }
                }else{
                    $guncelle=$this->m_tr_model->updateTable("options_general" ,array("is_tedarik_job_stat" => 0),array("id" =>  1));
                }
            }

        }
    }



}

