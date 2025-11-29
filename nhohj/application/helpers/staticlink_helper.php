<?php
function getst($key){
    $verilertr=array(
        "giris"        => "giris",
        "kayit"        => "kayit",
        "haberler"        => "haberler",
        "haber"        => "haber",
        "ilanlar"        => "ilan-pazaryeri"
    );
    foreach ($verilertr as $k => $item) {
        if($k==$key){
            return $item;
        }
    }
}
function getsten($key){
    $verilertr=array(
        "giris"        => "login",
        "kayit"        => "register",
        "haberler"        => "news",
        "haber"        => "new",
        "kurumsal"        => "about",
        "ilanlar"        => "marketplace"

    );
    foreach ($verilertr as $k => $item) {
        if($k==$key){
            return $item;
        }
    }
}


?>