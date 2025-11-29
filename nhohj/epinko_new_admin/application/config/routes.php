<?php
defined('BASEPATH') or exit('No direct script access allowed');
$route['default_controller'] = 'Login/user_login';
$route['404_override'] = '404';
$route['translate_uri_dashes'] = FALSE;
/* ----------------- Kullanıcı Girişi ve Çıkışı -----------------*/
$route["login"] = "Login/user_login";
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
$route["uye-phone-verify"] = "users/users/uyePhoneVerify";
$route["uye-phone-unverify"] = "users/users/uyePhoneUnverify";
$route["uye-tc-verify"] = "users/users/uyeTCVerify";
$route["uye-tc-unverify"] = "users/users/uyeTCUnverify";


//Üst Menü Modülü
$route["ust-menu-ayarlari"]                      = "menu/menutop/index";
$route["ust-menu-ekle"]                          = "menu/menutop/actions_add";
$route["ust-menu-list-table"]                    = "menu/menutop/list_table";
$route["ust-menu-guncelle/(:num)"]               = "menu/menutop/actions_update/$1";
$route["ust-menu-cek"]                           = "menu/menutop/get_record";
$route["ust-menu-cek-toplu"]                     = "menu/menutop/get_record_all_delete";
$route["ust-menu-sil"]                           = "menu/menutop/action_delete";
$route["ust-menu-img-sil"]                       = "menu/menutop/action_img_delete";
$route['ust-menu-durum-guncelle/(.*)']           = "menu/menutop/isActiveSetter/$1";
$route['ust-menu-veri-guncelle/(.*)/(:num)']     = "menu/menutop/isSetter/$1/$2";


//Alt Menü Modülü
$route["alt-menu-ayarlari"]                      = "menu/menubottom/index";
$route["alt-menu-ekle"]                          = "menu/menubottom/actions_add";
$route["alt-menu-list-table"]                    = "menu/menubottom/list_table";
$route["alt-menu-guncelle/(:num)"]               = "menu/menubottom/actions_update/$1";
$route["alt-menu-cek"]                           = "menu/menubottom/get_record";
$route["alt-menu-cek-toplu"]                     = "menu/menubottom/get_record_all_delete";
$route["alt-menu-sil"]                           = "menu/menubottom/action_delete";
$route["alt-menu-img-sil"]                       = "menu/menubottom/action_img_delete";
$route['alt-menu-durum-guncelle/(.*)']           = "menu/menubottom/isActiveSetter/$1";
$route['alt-menu-veri-guncelle/(.*)/(:num)']     = "menu/menubottom/isSetter/$1/$2";

//Otomasyon Ayarları
$route['otomasyon-ayarlari']                     = "module/otomasyon/index";
$route["module-update/(.*)"]                     = "module/otomasyon/update/$1";



//Anasayfa Slider Üstü Kategoriler
$route["anasayfa-slider-ustu-kategoriler"]       = "SliderTopCategories/index";
$route["anasayfa-slider-ustu-kategoriler-sil/(:num)"] = "SliderTopCategories/action_delete/$1";
$route["anasayfa-slider-ustu-kategoriler-ekle"]  = "SliderTopCategories/actions_add";


//Diller Modülü
//$route["diller"]                    = "lang/index";
//$route["dil-ekle"]                  = "lang/actions_add";
//$route["dil-guncelle/(:num)"]       = "lang/actions_update/$1";
//$route["dil-cek"]                   = "lang/get_record";
//$route["dil-sil"]                   = "lang/action_delete";
//$route['lang-durum-guncelle/(.*)']  ="lang/isActiveSetter/$1";

//Yorum Modülü
$route["yorumlar"]                    = "users/yorum/index";
$route["yorum-list-table"]            = "users/yorum/list_table";
$route["yorum-ekle"]                  = "users/yorum/actions_add";
$route["yorum-guncelle/(:num)"]       = "users/yorum/actions_update/$1";
$route["yorum-cek"]                   = "users/yorum/get_record";
$route["yorum-sil"]                   = "users/yorum/action_delete";
$route["yorum-img-sil"]               = "users/yorum/action_img_delete";
$route['yorum-durum-guncelle/(.*)']   = "users/yorum/isActiveSetter/$1";
$route["fake-yorum"]                    = "users/yorum/fakeYorum";
$route["fake-yorum/categories"]                    = "users/yorum/search_categories";
$route["fake-yorum/save"]                    = "users/yorum/fakeYorumSave";

//Talep Modülü
$route["talepler"]                    = "users/talep/index";
$route["talep-sohbet"]                = "users/talep/mesajYukle";
$route["talep-list-table"]            = "users/talep/list_table";
$route["talep-ekle"]                  = "users/talep/actions_add";
$route["talep-guncelle/(:num)"]       = "users/talep/actions_update/$1";
$route["talep-cek"]                   = "users/talep/get_record";
$route["talep-sil"]                   = "users/talep/action_delete";
$route["talep-img-sil"]               = "users/talep/action_img_delete";
$route['talep-durum-guncelle/(.*)']   = "users/talep/isActiveSetter/$1";

//referans modülü
$route["referans-kazanclari"]               = "users/reference/index";
$route["referans-kazanclari-list-table"]    = "users/reference/list_table";;
$route['referans-kazanclari-durum-guncelle/(.*)/(.*)']   = "users/reference/actions_update/$1/$2";


//çekim talep modlülü
$route["cekim-talepleri"]                   = "users/balance/index";
$route["cekim-talep-list-table"]            = "users/balance/list_table";
$route["cekim-talep-ekle"]                  = "users/balance/actions_add";
$route["cekim-talep-guncelle/(:num)"]       = "users/balance/actions_update/$1";
$route["cekim-talep-cek"]                   = "users/balance/get_record";
$route["cekim-talep-sil"]                   = "users/balance/action_delete";
$route['cekim-talep-durum-guncelle/(.*)']   = "users/balance/isActiveSetter/$1";

//çekim talep modlülü
$route["magaza-basvurulari"]                        = "store/store/index";
$route["magazalar"]                                 = "store/store/index_magaza";
$route["magaza-basvurulari-list-table"]             = "store/store/list_table";
$route["magaza-basvurulari-ekle"]                   = "store/store/actions_add";
$route["magaza-basvurulari-guncelle/(:num)"]        = "store/store/actions_update/$1";
$route["magaza-basvurulari-cek"]                    = "store/store/get_record";
$route["magaza-basvurulari-sil"]                    = "store/store/action_delete";
$route["magaza-basvurulari-img-sil"]                    = "store/store/action_img_delete";
$route["magaza-sil"]                                 = "store/store/action_delete_magaza";
$route['magaza-basvurulari-durum-guncelle/(.*)']    = "store/store/isActiveSetter/$1";

// Yayıncı Modülü
$route["yayinci-basvurulari"]                       = "streamer/index";
$route["yayincilar"]                                 = "streamer/index_yayinci";
$route["yayinci-basvurulari-guncelle/(:num)"]        = "streamer/actions_update/$1";
$route["yayinci-basvurulari-cek"]                    = "streamer/get_record";
$route["yayinci-basvurulari-img-sil"]                    = "streamer/action_img_delete";
$route["yayinci-sil"]                                 = "streamer/action_delete_yayinci";
$route["bagis-gecmisi"]                              = "streamer/donation_history";
$route["bagis-gecmisi-list-table"]                  = "streamer/donation_list_table";
$route['yayinci-veri-guncelle/(.*)/(:num)']    = "streamer/isSetter/$1/$2";

//Kampanya Modülü
$route["kampanyalar"]                    = "products/kampanya/index";
$route["kampanya-ekle"]                  = "products/kampanya/actions_add";
$route["kampanya-guncelle/(:num)"]       = "products/kampanya/actions_update/$1";
$route["kampanya-get-urun"]              = "products/kampanya/get_urun";
$route["kampanya-cek"]                   = "products/kampanya/get_record";
$route["kampanya-sil"]                   = "products/kampanya/action_delete";
$route["kampanya-img-sil"]               = "products/kampanya/action_img_delete";
$route['kampanya-durum-guncelle/(.*)']   = "products/kampanya/isActiveSetter/$1";

//Ödeme Yöntemleri
$route["odeme-yontemleri"]                    = "payment/methods/index";
$route["odeme-yontemi-ekle"]                  = "payment/methods/actions_add";
$route["odeme-yontemi-guncelle/(:num)"]       = "payment/methods/actions_update/$1";
$route["odeme-yontemi-get-urun"]              = "payment/methods/get_urun";
$route["odeme-yontemi-cek"]                   = "payment/methods/get_record";
$route["odeme-yontemi-sil"]                   = "payment/methods/action_delete";
$route["odeme-yontemi-img-sil"]               = "payment/methods/action_img_delete";
$route['odeme-yontemi-durum-guncelle/(.*)']   = "payment/methods/isActiveSetter/$1";

//Kurumsal Modülü
$route["kurumsal-guncelle"]             = "kurumsal/actions_update";
$route["kurumsal-cek"]                  = "kurumsal/get_record";
$route["kurumsal-img-sil"]              = "kurumsal/action_img_delete";
$route["iletisim-guncelle"]             = "kurumsal/actions_update_contact";
$route["genel-ayarlar"]                 = "kurumsal/actions_update_general";
$route["modul-ayarlari"]                = "kurumsal/actions_update_modul";
$route["entegrasyon-bilgileri"]         = "kurumsal/actions_update_entegra";
$route["statik-veriler"]                = "lang/lang_statik_veriler";
$route["lang-statik-update"]            = "lang/lang_statik_update";

//Blog Modülü
$route["bloglar"]                               = "blog/index";
$route["blog-ekle"]                             = "blog/actions_add";
$route["blog-guncelle/(:num)"]                  = "blog/actions_update/$1";
$route["blog-cek"]                              = "blog/get_record";
$route["blog-sil"]                              = "blog/action_delete";
$route["blog-img-sil"]                          = "blog/action_img_delete";
$route['blog-durum-guncelle/(.*)']              = "blog/isActiveSetter/$1";

//Avatarlar Modülü
$route["avatarlar"]                             = "avatars/index";
$route["avatarlar-ekle"]                             = "avatars/actions_add";
$route["avatarlar-guncelle/(:num)"]                  = "avatars/actions_update/$1";
$route["avatarlar-cek"]                              = "avatars/get_record";
$route["avatarlar-sil"]                              = "avatars/action_delete";
$route["avatarlar-img-sil"]                          = "avatars/action_img_delete";
$route['avatarlar-durum-guncelle/(.*)']              = "avatars/isActiveSetter/$1";

//Menü Ayarları
$route["menuler"]                    = "menu/index";
$route["menu-ekle"]                  = "menu/actions_add";
$route["menu-guncelle/(:num)"]       = "menu/actions_update/$1";
$route["menu-cek"]                   = "menu/get_record";
$route["menu-sil"]                   = "menu/action_delete";
$route['menu-durum-guncelle/(.*)']   = "menu/isActiveSetter/$1";

//SLider Modülü
$route["sliderlar"]                    = "slider/index";
$route["slider-ekle"]                  = "slider/actions_add";
$route["slider-guncelle/(:num)"]       = "slider/actions_update/$1";
$route["slider-cek"]                   = "slider/get_record";
$route["slider-sil"]                   = "slider/action_delete";
$route["slider-img-sil"]               = "slider/action_img_delete";
$route['slider-durum-guncelle/(.*)']   = "slider/isActiveSetter/$1";

//SLider Modülü
$route["admin-kullanicilar"]                        = "Panelusers/index";
$route["admin-kullanicilar-ekle"]                  = "Panelusers/actions_add";
$route["admin-kullanicilar-guncelle/(:num)"]       = "Panelusers/actions_update/$1";
$route["admin-kullanicilar-cek"]                   = "Panelusers/get_record";
$route["admin-kullanicilar-sil"]                   = "Panelusers/action_delete";
$route["admin-kullanicilar-img-sil"]               = "Panelusers/action_img_delete";
$route['admin-kullanicilar-durum-guncelle/(.*)']   = "Panelusers/isActiveSetter/$1";



//Sayfalar Modülü
$route["sayfa"]                       = "pages/index";
$route["sayfa-ekle"]                  = "pages/actions_add";
$route["sayfa-guncelle/(:num)"]       = "pages/actions_update/$1";
$route["sayfa-cek"]                   = "pages/get_record";
$route["sayfa-sil"]                   = "pages/action_delete";
$route["sayfa-img-sil"]               = "pages/action_img_delete";
$route['sayfa-durum-guncelle/(.*)']   = "pages/isActiveSetter/$1";

//Turkpin Modülü
$route["turkpin-urun-sistemi"]        = "turkpin_import/index";
$route["turkpin-urun-sistemi-ekle"]   = "turkpin_import/actions_add";
$route["turkpin-cek"]                   = "turkpin_import/get_record";
$route["turkpin-sil"]                   = "turkpin_import/action_delete";
$route["turkpin-img-sil"]               = "turkpin_import/action_img_delete";
$route['turkpin-durum-guncelle/(.*)']   = "turkpin_import/isActiveSetter/$1";

//Pinabi Module Routes Config
$route["pinabi-urun-sistemi"]        = "pinabi_import/index";
$route["pinabi-urun-sistemi-ekle"]   = "pinabi_import/actions_add";
$route["pinabi-cek"]                   = "pinabi_import/get_record";
$route["pinabi-sil"]                   = "pinabi_import/action_delete";
$route["pinabi-img-sil"]               = "pinabi_import/action_img_delete";
$route['pinabi-durum-guncelle/(.*)']   = "pinabi_import/isActiveSetter/$1";

//PinAbi API
$route['pinabi-get-product']       = "ajax/pinabi_api/get_category_product";
$route['pinabi-get-product-2']      = "ajax/pinabi_api/get_category_product_2";
$route['pinabi-get-price']         = "ajax/pinabi_api/get_product_price";


//Sosyal Medya Modülü
$route["sosyal-hesaplar"]                    = "social/index";
$route["sosyal-hesap-ekle"]                  = "social/actions_add";
$route["sosyal-hesap-guncelle/(:num)"]       = "social/actions_update/$1";
$route["sosyal-hesap-cek"]                   = "social/get_record";
$route["sosyal-hesap-sil"]                   = "social/action_delete";
$route['sosyal-hesap-durum-guncelle/(.*)']   = "social/isActiveSetter/$1";


$route["banka-hesaplari"]                   = "banks/banks/index";
$route["banka-hesap-ekle"]                  = "banks/banks/actions_add";
$route["banka-hesap-guncelle/(:num)"]       = "banks/banks/actions_update/$1";
$route["banka-hesap-cek"]                   = "banks/banks/get_record";
$route["banka-hesap-sil"]                   = "banks/banks/action_delete";
$route["banka-hesap-img-sil"]               = "banks/banks/action_img_delete";
$route['banka-hesap-durum-guncelle/(.*)']   = "banks/banks/isActiveSetter/$1";

$route["parola-degistir"] = "password/actions_update";
$route["password-update"] = "Options/pass_update";

//Ürün Kategoriler
$route["kategoriler"]                    = "products/products_category/index";
$route["kategoriler-kar/(:num)"]                = "products/products_category/muhasebe_index/$1";
$route["kategori-ekle"]                  = "products/products_category/actions_add";
$route["category-list-table"]            = "products/products_category/list_table";
$route["kategori-guncelle/(:num)"]       = "products/products_category/actions_update/$1";
$route["kategori-cek"]                   = "products/products_category/get_record";
$route["kategori-sil"]                   = "products/products_category/action_delete";
$route["kategori-img-sil"]               = "products/products_category/action_img_delete";
$route['kategori-durum-guncelle/(.*)']   = "products/products_category/isActiveSetter/$1";
$route['kategori-veri-guncelle/(.*)/(:num)']    = "products/products_category/isSetter/$1/$2";


//Ürünler
$route["urunler"]                           = "products/products/index";
$route["bize-sat-urunler"]                  = "products/products/index_al_sat";
$route["bayi-urunler"]                      = "products/products/index_bayi";
$route["bayi-urunler/(.*)"]                 = "products/products/index_bayi/$1";
$route["urunler-kar/(:num)"]                = "products/products/muhasebe_index/$1";
$route["product-list-table"]                = "products/products/list_table";
$route["product-sell-to-us-list-table"]     = "products/products/selltous_list_table";
$route["prbayi-list-table"]                = "products/products/list_table_bayi";
$route["prbayi-list-table/(.*)"]                = "products/products/list_table_bayi/$1";
$route["urun-ekle"]                         = "products/products/actions_add";
$route["bize-sat-urun-ekle"]                         = "products/products/selltous_actions_add";
$route["bayi-urun-ekle"]                         = "products/products/actions_add_bayi";
$route["urun-guncelle/(:num)"]              = "products/products/actions_update/$1";
$route["bize-sat-urun-guncelle/(:num)"]              = "products/products/selltous_actions_update/$1";
$route["urun-bayi-guncelle/(:num)"]              = "products/products/actions_update_bayi/$1";
$route["urun-cek"]                          = "products/products/get_record";
$route["urun-sil"]                          = "products/products/action_delete";
$route["urun-img-sil"]                      = "products/products/action_img_delete";
$route['urun-durum-guncelle/(.*)']          = "products/products/isActiveSetter/$1";
$route['urun-veri-guncelle/(.*)/(:num)']    = "products/products/isSetter/$1/$2";

//Kasa Yönetimi
$route["kasa-urunleri"]                     = "case-products/products/index";
$route["kasa-ekle"]                         = "case-products/products/actions_add";
$route["kasa-cek"]                          = "case-products/products/get_record";
$route["kasa-sil"]                          = "case-products/products/action_delete";
$route["kasa-guncelle/(:num)"]              = "case-products/products/actions_update/$1";
$route["kasa-img-sil"]                      = "case-products/products/action_img_delete";
$route["case-list-table"]                   = "case-products/products/list_table";
$route['kasa-veri-guncelle/(.*)/(:num)']    = "case-products/products/isSetter/$1/$2";

//Kasa İçerik
$route["kasa-icerikleri/(:num)"]            = "case-products/products_stock/index/$1";
$route["kasa-icerik-ekle/(:num)"]             = "case-products/products_stock/actions_add_stock/$1";
$route["kasa-icerik-sil"]                     = "case-products/products_stock/action_delete_stock";
$route["kasa-icerik-cek"]                     = "case-products/products_stock/get_record_stock";

//Kasa Geçmişi
$route["kasa-gecmisi"]                      = "case-history/main/index";
$route["case-history-list-table"]            = "case-history/main/list_table";

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

//üyeler
$route["uyeler"]                           = "users/users/index";
$route["bayiler"]                           = "users/users/index_bayi";
$route["bayi-list-table"]                   = "users/users/list_table_bayi";
$route["uyeler-ayarlar"]                    = "users/users/index_settings";
$route["uye-list-table"]                   = "users/users/list_table";
$route["uye-guncelle/(:num)"]              = "users/users/actions_update/$1";
$route["uye-cek"]                          = "users/users/get_record";
$route["uye-sil"]                          = "users/users/action_delete";
$route["uye-img-sil"]                      = "users/users/action_img_delete";
$route['uye-durum-guncelle/(.*)']          = "users/users/isActiveSetter/$1";
$route['uye-veri-guncelle/(.*)/(:num)']    = "users/users/isSetter/$1/$2";
$route['api/getDistricts/(:num)']          = "users/users/getDistricts/$1";

//ilan kategoriler
$route["ilan-kategoriler/(.*)"]                      = "adverts/adverts_category/index/$1";
$route["ilan-kategori-kar/(.*)/(.*)"]             = "adverts/adverts_category/muhasebe_index/$1/$2";
$route["ilan-kategori-ekle/(.*)"]                    = "adverts/adverts_category/actions_add/$1";
$route["adverts-category-list-table/(.*)"]           = "adverts/adverts_category/list_table/$1";
$route['ilan-kategori-veri-guncelle/(.*)/(:num)']    = "adverts/adverts_category/isSetter/$1/$2";
$route['ilan-kategori-guncelle/(:num)']              = "adverts/adverts_category/actions_update/$1";
$route["ilan-kategori-cek"]                          = "adverts/adverts_category/get_record";
$route["ilan-kategori-gorsel-cek"]                   = "adverts/adverts_category/get_images_record";
$route["ilan-kategori-gorsel-yukle"]                 = "adverts/adverts_category/add_images_record";
$route["ilan-kategori-gorsel-sil"]                   = "adverts/adverts_category/delete_images_record";
$route["ilan-kategori-img-sil"]                      = "adverts/adverts_category/action_img_delete";
$route["ilan-kategori-sil"]                          = "adverts/adverts_category/action_delete";

//ilan özel alanlar
$route["ilan-ozel-alanlar"]                         = "adverts/adverts_category_special/index";
$route["ilan-ozel-alan-ekle"]                       = "adverts/adverts_category_special/actions_add/$1";
$route["ilan-ozel-alan-guncelle/(:num)"]            = "adverts/adverts_category_special/actions_update/$1";
$route["ilan-ozel-alan-cek"]                        = "adverts/adverts_category_special/get_record";
$route["ilan-ozel-alan-sil"]                        = "adverts/adverts_category_special/action_delete";
$route['ilan-ozel-alan-veri-guncelle/(.*)/(:num)']  = "adverts/adverts_category_special/isSetter/$1/$2";

//ilan özel alanlar
$route["ilan-gorseller"]                         = "adverts/adverts_image/index";
$route["ilan-gorsel-ekle"]                       = "adverts/adverts_image/actions_add/$1";
$route["ilan-gorsel-guncelle/(:num)"]            = "adverts/adverts_image/actions_update/$1";
$route["ilan-gorsel-cek"]                        = "adverts/adverts_image/get_record";
$route["ilan-gorsel-sil"]                        = "adverts/adverts_image/action_delete";
$route['ilan-gorsel-veri-guncelle/(.*)/(:num)']  = "adverts/adverts_image/isSetter/$1/$2";
$route["ilan-gorsel-img-sil"]                  = "adverts/adverts_image/action_img_delete";

//ilan doping fiyatları
$route["ilan-doping-fiyatlar"]                            = "adverts/adverts_doping_price/index";
$route["ilan-doping-fiyatlar-ekle"]                       = "adverts/adverts_doping_price/actions_add/$1";
$route["ilan-doping-fiyatlar-guncelle/(:num)"]            = "adverts/adverts_doping_price/actions_update/$1";
$route["ilan-doping-fiyatlar-cek"]                        = "adverts/adverts_doping_price/get_record";
$route["ilan-doping-fiyatlar-sil"]                        = "adverts/adverts_doping_price/action_delete";
$route['ilan-doping-fiyatlar-veri-guncelle/(.*)/(:num)']  = "adverts/adverts_doping_price/isSetter/$1/$2";

$route["ilan-teslimat-sureleri"]                            = "adverts/adverts_delivery_time/index";
$route["ilan-teslimat-sureleri-ekle"]                       = "adverts/adverts_delivery_time/actions_add/$1";
$route["ilan-teslimat-sureleri-guncelle/(:num)"]            = "adverts/adverts_delivery_time/actions_update/$1";
$route["ilan-teslimat-sureleri-cek"]                        = "adverts/adverts_delivery_time/get_record";
$route["ilan-teslimat-sureleri-sil"]                        = "adverts/adverts_delivery_time/action_delete";
$route['ilan-teslimat-sureleri-veri-guncelle/(.*)/(:num)']  = "adverts/adverts_delivery_time/isSetter/$1/$2";

//İlanlar
$route["ilanlar"]                           = "adverts/adverts/index";
$route["ilan-sohbetler/(:num)"]                     = "adverts/adverts/index_sohbetler/$1";
$route["ads-list-table"]                    = "adverts/adverts/list_table";
$route["ads-list-table-message"]                    = "adverts/adverts/list_table_message";
$route["ilan-guncelle/(:num)"]              = "adverts/adverts/actions_update/$1";
$route["ilan-sohbet-guncelle/(:num)"]        = "adverts/adverts/actions_update_message/$1";
$route["ilan-cek"]                          = "adverts/adverts/get_record";
$route["ilan-img-sil"]                      = "adverts/adverts/action_img_delete";
$route['ilan-durum-guncelle/(.*)']          = "adverts/adverts/isActiveSetter/$1";
$route['ilan-veri-guncelle/(.*)/(:num)']    = "adverts/adverts/isSetter/$1/$2";
$route["ilan-kategori-doldur"]              = "adverts/adverts/get_category";
$route["get-ad-price-commission"]           = "adverts/adverts/getAdsCommission";
$route["uye-mesajlar"]                     = "users/messages/index_sohbetler";
$route["uye-list-table-message"]                    = "users/messages/list_table_message";
$route["mesajlari-cek"]                    = "users/messages/get_record";
$route["mesajlari-sil"]                    = "users/messages/action_delete";


//API
$route['turkpin-get-product']       = "ajax/turkpin_api/get_category_product";
$route['turkpin-get-product-2']      = "ajax/turkpin_api/get_category_product_2";
$route['turkpin-get-price']         = "ajax/turkpin_api/get_product_price";

//Blog Kategori Modülü
$route["bildirimler"]                    = "notifications/notifications/index";
$route["bildirim-ekle"]                  = "notifications/notifications/actions_add";
$route["bildirim-guncelle/(:num)"]       = "notifications/notifications/actions_update/$1";
$route["bildirim-cek"]                   = "notifications/notifications/get_record";
$route["bildirim-sil"]                   = "notifications/notifications/action_delete";
$route["bildirim-img-sil"]               = "notifications/notifications/action_img_delete";
$route['bildirim-durum-guncelle/(.*)']   = "notifications/notifications/isActiveSetter/$1";



//Siparişler
$route["siparisler"]                        = "orders/orders/index";
$route["cekilis-siparisler"]                        = "orders/orders/index_raffle";
$route["kasa-siparisler"]                        = "orders/orders/index_case";
$route["bayi-siparis"]                        = "orders/orders/index_bayi_new";
$route["bayi-siparis/(.*)"]                        = "orders/orders/index_bayi/$1";
$route["order-list-table"]                  = "orders/orders/list_table";
$route["siparis-guncelle/(:num)"]           = "orders/orders/actions_update/$1";
$route["ilan-cek"]                          = "adverts/adverts/get_record";
$route["siparis-cek"]                       = "orders/orders/get_record";
$route["kod-cek-turkpin/(.*)"]                   = "orders/orders/get_turkpin/$1";
$route["order-bayi-list-table"]                  = "orders/orders/list_table_bayii";
$route["order-bayi-list-table/(.*)"]                  = "orders/orders/list_table_bayi/$1";
$route["siparis-sil"]                       = "orders/orders/action_delete";
$route["ilan-img-sil"]                      = "adverts/adverts/action_img_delete";
$route['ilan-durum-guncelle/(.*)']          = "adverts/adverts/isActiveSetter/$1";
$route['ilan-veri-guncelle/(.*)/(:num)']    = "adverts/adverts/isSetter/$1/$2";
$route["ilan-img-sil"]                      = "adverts/adverts/action_img_delete";
$route["ilan-kategori-doldur"]              = "adverts/adverts/get_category";
$route["get-ad-price-commission"]           = "adverts/adverts/getAdsCommission";

$route["ilan-siparisler"]                   = "orders/adsorders/index";
$route["ilan-siparis-sil"]                   = "orders/adsorders/action_delete";
$route["ads-order-list-table"]              = "orders/adsorders/list_table";
$route["ilan-siparis-guncelle/(:num)"]      = "orders/adsorders/actions_update/$1";


$route["ilan-cek"]                          = "adverts/adverts/get_record";
$route["ilan-sil"]                          = "adverts/adverts/action_delete";
$route["ilan-img-sil"]                      = "adverts/adverts/action_img_delete";
$route['ilan-durum-guncelle/(.*)']          = "adverts/adverts/isActiveSetter/$1";
$route['ilan-veri-guncelle/(.*)/(:num)']    = "adverts/adverts/isSetter/$1/$2";
$route["ilan-img-sil"]                      = "adverts/adverts/action_img_delete";
$route["ilan-kategori-doldur"]              = "adverts/adverts/get_category";
$route["get-ad-price-commission"]           = "adverts/adverts/getAdsCommission";

//Siparişler
$route["al-sat-siparisler"]                 = "orders/selltousorders/index";
$route["sell-to-us-order-list-table"]         = "orders/selltousorders/list_table";
$route["al-sat-siparis-guncelle/(:num)"]      = "orders/selltousorders/actions_update/$1";

//Paraşüt
$route["siparis-faturalandir/(:num)"]       = "orders/orders/create_invoice/$1";
$route["fatura-goruntule/(:num)"]       = "orders/orders/show_invoice/$1";
$route["siparis-komisyon-faturalandir/(:num)"]       = "orders/adsorders/create_invoice/$1";
$route["fatura-komisyon-goruntule/(:num)"]       = "orders/adsorders/show_invoice/$1";

//Çekilişler
$route["cekilisler"]                    = "raffle/index";
$route["cekilisler-list-table"]                    = "raffle/list_table";
$route["odul-gecmisi"]                    = "raffle/history";
$route["odul-gecmisi-list-table"]                    = "raffle/history_list_table";

//Ödeme Kayıtları
$route["odeme-kayitlari"]                            = "payment/payment/index";
$route["odeme-list-table"]                           = "payment/payment/list_table";

$route["odeme-bildirimleri"]                         = "payment/payment/index_bildirim";
$route["odeme-bildirim-guncelle/(.*)"]               = "payment/payment/bildirim_update/$1";
$route["odeme-bildirim-list-table"]                  = "payment/payment/bildirim_list_table";

//Loglar
$route["kullanici-loglar"]                          = "logs/logs/index_kullanici";
$route["turkpin-loglar"]                            = "logs/logs/index_turkpin";
$route["klog-list-table"]                           = "logs/logs/list_table_kullanici";
$route["klog-cek"]                                  = "logs/logs/get_record";
$route["klog-sil"]                                  = "logs/logs/action_delete";
$route["admin-loglar"]                              = "logs/logs/index_admin";
$route["alog-list-table"]                           = "logs/logs/list_table_admin";
$route["turkpin-list-table"]                        = "logs/logs/list_table_turkpin";
$route["alog-cek"]                                  = "logs/logs/get_record_admin";
$route["alog-sil"]                                  = "logs/logs/action_delete_admin";


/*
$route["cekilis-ayarlar"]                           = "cekilis/cekilis/actions_update_options";
$route["cekilisler"]                                = "cekilis/cekilis/index_cekilisler";
$route["cekilis-cek"]                                = "cekilis/cekilis/get_record_cekilis";
$route["cekilis-sil"]                                = "cekilis/cekilis/action_delete_cekilis";
$route["cekilis-guncelle/(:num)"]                                = "cekilis/cekilis/actions_update/$1";
$route["cekilis-yetki-talepleri"]                   = "cekilis/cekilis/index_talepler";
$route["cekilis-yetki-table"]                       = "cekilis/cekilis/talep_list_table";
$route["cekilis-list-table"]                         = "cekilis/cekilis/cekilis_list_table";
$route["cekilis-talep-cek"]                         = "cekilis/cekilis/get_record";
$route["cekilis-talep-sil"]                         = "cekilis/cekilis/action_delete";
$route["cekilis-yetki-ver"]                         = "cekilis/cekilis/action_yetki";*/


$route["server-kategoriler"]                            = "server/server_category/index";
$route["server-kategori-ekle"]                          = "server/server_category/actions_add";
$route["server-category-list-table"]                    = "server/server_category/list_table";
$route["server-kategori-guncelle/(:num)"]               = "server/server_category/actions_update/$1";
$route["server-kategori-cek"]                           = "server/server_category/get_record";
$route["server-kategori-sil"]                           = "server/server_category/action_delete";
$route["server-kategori-img-sil"]                       = "server/server_category/action_img_delete";
$route['server-kategori-durum-guncelle/(.*)']           = "server/server_category/isActiveSetter/$1";
$route['server-kategori-veri-guncelle/(.*)/(:num)']     = "server/server_category/isSetter/$1/$2";

//Sosyal Medya Modülü
$route["bolgeler"]                    = "bolge/index";
$route["bolge-ekle"]                  = "bolge/actions_add";
$route["bolge-guncelle/(:num)"]       = "bolge/actions_update/$1";
$route["bolge-cek"]                   = "bolge/get_record";
$route["bolge-sil"]                   = "bolge/action_delete";
$route['bolge-durum-guncelle/(.*)']   = "bolge/isActiveSetter/$1";

//Sosyal Medya Modülü
$route["server-gruplar"]                    = "server/server_grup/index";
$route["server-grup-ekle"]                  = "server/server_grup/actions_add";
$route["server-grup-guncelle/(:num)"]       = "server/server_grup/actions_update/$1";
$route["server-grup-cek"]                   = "server/server_grup/get_record";
$route["server-grup-sil"]                   = "server/server_grup/action_delete";
$route['server-grup-durum-guncelle/(.*)']   = "server/server_grup/isActiveSetter/$1";

//Refund
$route["iade-bildirimleri"]                 = "RefundRequest/index";
$route["refund-requests"]                   = "RefundRequest/dataTableApi";
$route["iade-bildirim-guncelle/(:num)"]     = "RefundRequest/detail/$1";
$route["refund-status"]                     = "RefundRequest/changeStatus";


$route["yetki-yok"]=            "Yetki/yetki";




//Ayarlar
$route["ayarlar"]                   =   "settings/index";
$route["ayarlar/(.*)"]              =   "settings/index/$1";
$route["ayarlar/(.*)/(.*)"]         =   "settings/index/$1/$2";
$route["settings-update/(.*)"]      =   "settings/update/$1";
$route["social-update/(.*)"]        =   "settings/socialUpdate/$1";
$route["logo-img-sil"]              =   "settings/action_img_delete";
$route["settings/comission"]        =   "settings/updateComission";

//AJAX
$route["get-record"]                =   "ajax/functions/getRecord";
$route["delete-record"]             =   "ajax/functions/deleteRecord";
$route["change-status/(.*)"]        =   "ajax/functions/statusChange/$1";
$route["image-deletes"]             =   "ajax/functions/imageDelete";

$route["sms-sorulari-guncelle/(:num)"]       = "sms/smsquest/actions_update/$1";
$route['sms-sorulari-durum-guncelle/(.*)']   = "sms/smsquest/isActiveSetter/$1";

//Üye İşlemleri
$route["uye-banka/(.*)"]                ="users/users/index_banka/$1";






//Mail Şablonları
$route["sablonlar"]                    = "mail_template/index";
$route["sablon-ekle"]                  = "mail_template/actions_add";
$route["sablon-guncelle/(:num)"]       = "mail_template/actions_update/$1";
$route["sablon-cek"]                   = "mail_template/get_record";
$route["sablon-sil"]                   = "mail_template/action_delete";
$route["sablon-img-sil"]               = "mail_template/action_img_delete";
$route['sablon-durum-guncelle/(.*)']   = "mail_template/isActiveSetter/$1";


//PVP Serverlar
$route["pvp-serverlar"]                    = "PVPServers/index";
$route["pvp-server-ekle"]                  = "PVPServers/actions_add";
$route["pvp-server-list-table"]            = "PVPServers/list_table";
$route["pvp-server-guncelle/(:num)"]       = "PVPServers/actions_update/$1";
$route["pvp-server-cek"]                   = "PVPServers/get_record";
$route["pvp-server-sil"]                   = "PVPServers/action_delete";
$route["pvp-server-img-sil"]               = "PVPServers/action_img_delete";
$route['pvp-server-veri-guncelle/(.*)/(:num)']    = "PVPServers/isSetter/$1/$2";


//PVP Serverlar
$route["gelir-gider-yonetimi"]             = "IncomeOutcome/index";
$route["gelir-gider-ekle"]                  = "IncomeOutcome/actions_add";
$route["gelir-gider-list-table"]            = "IncomeOutcome/list_table";
$route["gelir-gider-guncelle/(:num)"]       = "IncomeOutcome/actions_update/$1";
$route["gelir-gider-cek"]                   = "IncomeOutcome/get_record";
$route["gelir-gider-sil"]                   = "IncomeOutcome/action_delete";
$route["gelir-gider-kar-raporu"]            = "IncomeOutcome/report";
$route["gelir-gider-kar"]            = "IncomeOutcome/ajax_detail";
//PVP Serverlar
$route["anasayfa-urun-liste"]                    = "HomeProducts/index";
$route["anasayfa-urun-ekle"]                  = "HomeProducts/actions_add";
$route["anasayfa-urun-cek"]                   = "HomeProducts/get_record";
$route["anasayfa-urun-sil"]                   = "HomeProducts/action_delete";