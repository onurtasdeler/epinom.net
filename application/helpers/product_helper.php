<?php

function findCdkeyGamesForRefDiscount($cart) {
    $status = FALSE;
    foreach($cart as $_c):
        $status = recursiveFindCdkey($_c['product']->category_id);
    endforeach;
    return $status;
}

function recursiveFindCdkey($category_id){
    $cdkeyCategoryId = 86;
    $ci = &get_instance();
    $category = $ci->db->where([
        'id' => $category_id
    ])->get('categories')->row();
    if ($category->up_category_id>0){
        if ($category->up_category_id == $cdkeyCategoryId) {
            return TRUE;
        } else {
            $upCategory = $ci->db->where(['id' => $category->up_category_id])->get('categories')->row();
            return recursiveFindCdkey($upCategory->id);
        }
    }
    return FALSE;
}

function getProductPrice($product = array()){
    $productPrice = $product->price;

    /* user dealer discount */
    if ($user = getActiveUser()) {
        if ($user->is_dealer == 1) {
            $dealer_product = get_instance()->db->where([
                'product_id' => $product->id,
                'user_id' => getActiveUser()->id
            ])->get('dealer_products')->row();
            if (isset($dealer_product->id)) {
                if ($dealer_product->percent > 0) {
                    return ($productPrice)*(100-$dealer_product->percent)/100;
                }
            }
        }
    }

    /* product discount */
    if(!empty($product->discount) && $product->discount > 0){
        if (!empty($product->discount_end_date)) {
            if (time()-strtotime($product->discount_end_date) <= 0) {
                $productPrice = ((100 - $product->discount) * $productPrice) / 100;
            }
        } else {
            $productPrice = ((100 - $product->discount) * $productPrice) / 100;
        }
    }

    return $productPrice;
}