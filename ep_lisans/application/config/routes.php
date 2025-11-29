<?php
defined('BASEPATH') or exit('No direct script access allowed');
$route['default_controller'] = 'Login/user_login';
$route['404_override'] = '404';
$route['translate_uri_dashes'] = FALSE;
/* ----------------- Kullanıcı Girişi ve Çıkışı -----------------*/
$route["login"]             = "Login/user_login";
$route["login-control"]     = "Login/user_login_control";
$route["login-control2"]    = "Login/user_login_control2";
$route["exit"]              = "Login/exitt";
$route["imageUploadCK"]     = "Options/img_upload_ck";

/* ----------------- GENERAL AJAX FUNCTION -----------------------*/
$route["get-info"]                  = "Func/get_info";
$route["get-info-musteri"]          = "Func/get_info_musteri";
$route["delete-image"]      = "Func/img_deleted";
$route["record-delete"]     = "Func/record_delete";
$route["getcontrol"]     = "Licences/licenseControlGet";
$route["rapor"]          = "musteri/odeme/rapor";



/* ----------------- Dashboard -------------------------*/

/* ------------------------- Markalar / Modeller -----------------------*/
$route["proje-gruplari"]                          = "hizmet/hizmet/index";
$route["proje-grup/(:num)"]                       = "hizmet/hizmet/index_parent/$1";
$route["proje-grup-ekle"]                         = "hizmet/hizmet/actions_add";
$route["hizmet-list-table"]                       = "hizmet/hizmet/list_table";
$route["proje-grup-list-table/(:num)"]            = "hizmet/hizmet/list_table/$1";
$route['proje-grup-veri-guncelle/(.*)/(:num)']    = "hizmet/hizmet/isSetter/$1/$2";
$route["proje-grup-sil-toplu"]                    = "hizmet/hizmet/get_record_all_delete";

$route["paketler"]                                  = "paket/paket/index";
$route["paket/(:num)"]                              = "paket/paket/index_parent/$1";
$route["paket-ekle"]                             = "paket/paket/actions_add";
$route["paket-list-table"]                          = "paket/paket/list_table";
$route["paket-list-table/(:num)"]                   = "paket/paket/list_table/$1";
$route['paket-veri-guncelle/(.*)/(:num)']           = "paket/paket/isSetter/$1/$2";
$route["paket-sil-toplu"]                           = "paket/paket/get_record_all_delete";

$route["saldirilar"]                          = "saldiri/saldiri/index";
$route["saldiri-list-table"]                       = "saldiri/saldiri/list_table";


$route["lisanslar"]                            = "musteri/musteri/index";
$route["lisans/(:num)"]                        = "musteri/musteri/index_parent/$1";
$route["lisans-ekle"]                          = "musteri/musteri/actions_add";
$route["lisans-list-table"]                    = "musteri/musteri/list_table";
$route["lisans-list-table2"]                    = "musteri/musteri/list_table2";
$route["lisans-list-table/(:num)"]             = "musteri/musteri/list_table/$1";
$route['lisans-veri-guncelle/(.*)/(:num)']     = "musteri/musteri/isSetter/$1/$2";
$route["lisans-sil-toplu"]                     = "musteri/musteri/get_record_all_delete";

$route["odemeler/(:num)"]                     = "musteri/odeme/index/$1";
$route["odeme/(:num)"]                        = "musteri/odeme/index_parent/$1";
$route["odeme-ekle/(:num)"]                   = "musteri/odeme/actions_add/$1";
$route["odeme-list-table/(:num)"]             = "musteri/odeme/list_table/$1";
$route['odeme-veri-guncelle/(.*)/(:num)']     = "musteri/odeme/isSetter/$1/$2";
$route["odeme-sil-toplu"]                     = "musteri/odeme/get_record_all_delete";


$route["modeller/(:num)"]                    = "marka/model/index/$1";
$route["model-ekle/(:num)"]                  = "marka/model/actions_add/$1";
$route["model-list-table/(:num)"]            = "marka/model/list_table/$1";
$route['model-veri-guncelle/(.*)/(:num)']    = "marka/model/isSetter/$1/$2";
$route["model-sil-toplu"]                    = "marka/model/get_record_all_delete";
$route["logsil"]="Func/deletelog";

/* ----------------------------- Hizmetler -------------------------------*/





/* ----------------------------- sms yönetimi -------------------------------*/

$route["sms-yonetimi"]                     = "sms/sms/index";
$route["sabit-sms-ekle"]                   = "sms/sms/actions_add";
$route["sms-list-table"]                   = "sms/sms/list_table";
$route['sms-veri-guncelle/(.*)/(:num)']    = "sms/sms/isSetter/$1/$2";
$route["sabit-sms-sil-toplu"]              = "sms/sms/get_record_all_delete";
$route["sms-gonder"]                       = "sms/sms/sms_send";

/* ----------------------------- Fiş yönetimi -------------------------------*/
$route["fis-detay/(:num)"]                 = "tasks/fis/index/$1";
$route["fis-yazdir/(:num)"]                = "func/prints/$1";

/* ----------------------------- Fiş yönetimi -------------------------------*/
$route["fis-detay/(:num)"]                 = "tasks/fis/index/$1";
$route["fis-yazdir/(:num)"]                = "func/prints/$1";

/* ----------------------------- Yönetim -------------------------------*/

$route["sms-ayarlari"]                          = "options/optionssms/index";
$route["site-ayarlari"]                         = "options/optionssms/index_site";
$route["firma-bilgileri"]                       = "options/optionsfirma/index";
$route["firma-bilgileri-guncelle"]              = "options/optionsfirma/index_update";
$route["yetki-yok"]                             = "Func/yetki_yok";
$route["hesabim"]                               = "options/Optionshesap/index";
$route["sifre-degistir"]                        = "options/Optionshesap/index_update";
$route["raporlar"]                              = "rapor/rapor/index";


//Haberler
$route["mesajlar"] = "Mesaj/index";
$route["mesaj-cek"] = "Mesaj/get_record";
$route["mesaj-sil"] = "Mesaj/action_delete";


