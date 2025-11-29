<?php
function getProductPrice($id){
    $t=&get_instance();
    $kontrol=getTableSingle("table_products",array("id" => $id));
    if($kontrol){
        $hesapla=0;
        $hesapla2=0;
        $fiyat=$kontrol->price;
        if($kontrol->is_discount==1){
            if($kontrol->discount!="" && $kontrol->discount!=0){
                return $kontrol->price_sell_discount;
            }else{
                return $kontrol->price_sell;
            }
        }else{
            return $kontrol->price_sell;
        }
    }else{
        return false;
    }
}

function get_product_stock($id){
    $t=&get_instance();
    $urun=getTableSingle("table_products",array("id" => $id));
    if($urun->is_api==1){
        if ( $urun->pinabi_id > 0 ) {
            return $urun->pinabi_stok;
        }elseif ( $urun->turkpin_id > 0 ) {
            return $urun->turkpin_stok;
        }
    }else{
        if($urun->is_stock == 0){
            $ozelalan=getTableSingle("table_products_special",array("p_id" => $urun->id,"status" => 1,"is_required" => 1,"is_main" => 1));
            if($ozelalan){

                return $urun->stok;
            }else{
                $kont=getTable("table_products_stock",array("p_id" => $id,"status" => 1,"prevision" => 0));
                if($kont){
                    return count($kont);
                }else{
                    return false;
                }
            }

        } else{
            return "-1";
        }
    }

}