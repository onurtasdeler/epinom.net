<?php
defined('BASEPATH') or exit('No direct script access allowed');
$route['default_controller'] = 'Login/user_login';
$route['404_override'] = '404';
$route['translate_uri_dashes'] = FALSE;
/* ----------------- Kullanıcı Girişi ve Çıkışı -----------------*/
$route["login/(.*)"] = "Login/user_login/$1";
$route["login-control"] = "Login/user_login_control";
$route["login-control2"] = "Login/user_login_control2";
$route["exit"] = "Login/exitt";
$route["imageUploadCK"] = "Options/img_upload_ck";
$route["yardim"]                                    = "kurumsal/page_yardim";

/* ----------------- Hizmetler -------------------------*/

$route["dashboard"] = "dash/index";
$route["login-control"] = "Login/user_login_control";
//Haberler
$route["mesajlar"] = "Mesaj/index";
$route["mesaj-cek"] = "Mesaj/get_record";
$route["mesaj-sil"] = "Mesaj/action_delete";
$route["uye-manuel-dogrulama"] = "users/users/onayMailManuel";
$route["uye-banla"] = "users/users/yesBan";





//Kurumsal Modülü
$route["kurumsal-guncelle"]             = "kurumsal/actions_update";
$route["kurumsal-cek"]                  = "kurumsal/get_record";
$route["kurumsal-img-sil"]              = "kurumsal/action_img_delete";
$route["iletisim-guncelle"]             = "kurumsal/actions_update_contact";
$route["genel-ayarlar"]                 = "kurumsal/actions_update_general";
$route["modul-ayarlari"]                = "kurumsal/actions_update_modul";
$route["islem-onay-kisitlama"]          = "kurumsal/actions_update_kisit";
$route["entegrasyon-bilgileri"]         = "kurumsal/actions_update_entegra";
$route["statik-veriler"]                = "lang/lang_statik_veriler";
$route["lang-statik-update"]            = "lang/lang_statik_update";










//Ürünler
$route["urunler"]                           = "products/products/index";
$route["urunler-kar/(:num)"]                = "products/products/muhasebe_index/$1";
$route["product-list-table"]                = "products/products/list_table";
$route["prbayi-list-table"]                 = "products/products/list_table";
$route["urun-ekle"]                         = "products/products/actions_add";
$route["urun-guncelle/(:num)"]              = "products/products/actions_update/$1";
$route["urun-cek"]                          = "products/products/get_record";
$route["urun-sil"]                          = "products/products/action_delete";
$route["urun-img-sil"]                      = "products/products/action_img_delete";
$route['urun-durum-guncelle/(.*)']          = "products/products/isActiveSetter/$1";
$route['urun-veri-guncelle/(.*)/(:num)']    = "products/products/isSetter/$1/$2";

//Stoklar
$route["urun-stoklar/(:num)"]               = "products/products_stock/index/$1";
$route["urun-stok-ekle/(:num)"]             = "products/products_stock/actions_add_stock/$1";
$route["urun-stok-guncelle/(:num)"]         = "products/products_stock/actions_update/$1";
$route["urun-stok-sil"]                     = "products/products_stock/action_delete_stock";
$route["urun-stok-cek"]                     = "products/products_stock/get_record_stock";
$route["urun-stok-bulk"]                    = "products/products_stock/stockBulkDelete";


//Ürün Özel Alanlar
$route["urun-ozel-alanlar/(.*)"]            = "products/products_special_field/index/$1";
$route["urun-ozel-alan-ekle/(.*)"]        = "products/products_special_field/actions_add/$1";
$route["urun-ozel-alan-guncelle/(:num)"]    = "products/products_special_field/actions_update/$1";
$route["urun-ozel-alan-cek"]                            = "products/products_special_field/get_record";
$route["urun-ozel-alan-sil"]                            = "products/products_special_field/action_delete";
$route['urun-ozel-alan-veri-guncelle/(.*)/(:num)']    = "products/products_special_field/isSetter/$1/$2";




//Siparişler
$route["siparisler"]                        = "orders/orders/index";
$route["order-list-table"]                  = "orders/orders/list_table";
$route["siparis-guncelle/(:num)"]           = "orders/orders/actions_update/$1";

$route["siparis-cek"]                        = "orders/orders/get_record";
$route["siparis-sil"]                        = "orders/orders/action_delete";

