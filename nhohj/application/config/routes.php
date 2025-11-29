<?php

defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Home';

$route['404_override'] = '404';

$route['translate_uri_dashes'] = FALSE;



//API User Routes

$route["user-register"]     ="user/api/register";

$route["user-login"]        ="user/api/login";

$route["onay/req/(.*)"]     ="user/api/email_trusted/$1";

$route["exitt"]            ="user/api/logout";

$route["logout"]            ="user/api/logout";

$route["chloadnews"]            ="news/cekHaberLoad";

$route["control-cron_123123123"]      ="ajax/cron/cron/index";

$route["control-cron_mail"]      ="ajax/cron/mail_sms/index";

$route["control-cron_turkpin"]      ="ajax/cron/cron_turkpin/auto_product_price_update";

$route["control-cron_sms"]      ="ajax/cron/cron_sms_system/sms_crons";

$route["control-cron_raffle"]   ="ajax/cron/cron_raffle_system/finish_raffles";

$route["kur-update"] = "ajax/cron/cron/kurupdate";

//API User Balance

$route["pay-form-submit"]                   ="user/balance/payFormSubmit";

$route["google-login"]                      ="ajax/auth/googleOAuthLogin";

$route["google-auth-control"]               ="ajax/auth/googleOAuth";

$route["twitch-auth-control"]               ="ajax/auth/registerTwitch";

$route["login/google"]                      ="user/login/google";



$route["google/merchant"]                   ="Google/index";

$route["page/(.*)"]                         ="PageController/index/$1";



//$route["iiii"]="auth/tr";





//---------------- Login Register ----------------------//

//TR

$route["giris"]                 =   "Auth/login";

$route["sifremi-unuttum"]       =   "Auth/passs";

$route["kayit"]                 =   "Auth/register";

//EN

$route["en/login"]              =   "Auth/login";

$route["en/forgot-password"]    =   "Auth/passs";

$route["en/register"]           =   "Auth/register";

//---------------- Login Register ----------------------//



//---------------- Haberler ----------------------//

//TR

$route["haberler"]               =   "News/index";

$route["haberler/(.*)"]          =   "News/index/$1";

$route["haber/(.*)"]             =   "News/detail/$1";

//EN

$route["en/news"]                =   "News/index";

$route["en/news/(.*)"]           =   "News/detail/$1";

//---------------- Haberler ----------------------//

$route['api/yorumlar'] = 'Comments/get_yorumlar';



//Func

$route["get-records-any"]               ="ajax/Functions/getRecord";



//Auth

$route["registerAjax"]                  ="ajax/Auth/registerControl";

$route["loginAjax"]                     ="ajax/Auth/loginControl";

$route["usernameControlAjax"]           ="ajax/Auth/usernameControl";

$route["forgot-pass-set"]               ="ajax/Auth/passChange";



//balance

$route["get-balance-com"]               ="ajax/Balance/balanceCommission";

$route["get-balance-com"]               ="ajax/Balance/balanceCommission";

$route["get-balance-com-eft"]           ="ajax/Balance/balanceCommissionHavale";

$route["get-paytr-iframe-kredit"]       ="ajax/Balance/balanceAddPaymentCredit";

$route["get-gpay-credit"]               ="ajax/Balance/balanceAddGpayCredit";

$route["get-gpay-havale"]               ="ajax/Balance/balanceAddGpayHavale";

$route["get-papara-credit"]             ="ajax/Balance/balanceAddPaparaCredit";

$route["get-shopier-credit"]             ="ajax/Balance/balanceAddShopierCredit";

$route["get-paytr-iframe-havale"]       ="ajax/Balance/balanceAddPaymentEft";

$route["get-vallet-payment"]            ="ajax/Balance/createValletOrder";

$route["get-payguru-payment"]           ="ajax/Balance/createPayguruOrder";

$route["set-name-verify"]               ="ajax/Balance/setNameVerify";

$route["get-payment-list/(.*)"]         ="ajax/Balance/getListPayment/$1";

$route["callback/vallet/(.*)"]          ="ajax/Callback/vallet/$1";

$route["callback/paytr/(.*)"]           ="ajax/Callback/paymentReturn/$1";

$route["callback/payguru/(.*)"]         ="ajax/Callback/payguru/$1";

$route["callback/gpay/(.*)"]            ="ajax/Callback/gpay/$1";

$route["callback/papara/(.*)"]          ="ajax/Callback/papara/$1";

$route["callback/shopier/(.*)"]          ="ajax/Callback/shopier/$1";

$route["set-payment-manuel"]            ="ajax/Balance/setBalanceManuel";

$route["set-payment-pin"]               ="ajax/Balance/setBalancePin";

$route["refund-request"]                ="ajax/Balance/refundReq";

$route["get-tab-content"]                ="ajax/Tabs/getTabContent";

//Ürün ve Sepet Ajax

$route["product-change-qty"]            ="ajax/order/Products/getQtyPrice";

$route["product-change-qty-basket"]     ="ajax/order/Products/getQtyPriceBasket";

$route["add-basket-card"]               ="ajax/order/Products/addBasketCardControl";
$route["get-basket-qty"]               ="ajax/order/Products/getBasketQty";

$route["update-basket-card"]            ="ajax/order/Products/updateBasketCardControl";

$route["delete-basket-card"]            ="ajax/order/Products/deleteBasketProduct";

$route["set-basket-complete"]           ="ajax/order/Order/setBasketComplate";

$route["purchase-case"]                 ="ajax/order/Cases/purchaseCase";

$route["purchase-from-us"]              ="ajax/order/Products/purchaseFromUs";

$route["sell-to-us"]                    ="ajax/order/Products/sellToUs";



//Mağaza Başvurusu

$route["set-store-app"]                 ="ajax/store/setStoreApplication";



//Profil ayarları

$route["profile-pass-update"]           ="ajax/profile/updatePassSetting";



//İlan oluşturma/güncelleme

$route["get-category-top-list"]                 ="ajax/adverts/getCategoryTopList";

$route["get-category-default-images"]           ="ajax/adverts/getCategoryDefaultImages";

$route["create-ads-no-stock"]                   ="ajax/adverts/setCreateAdNStock";

$route["create-ads-stock"]                      ="ajax/adverts/setCreateAdStock";

$route["get-price-no-stock-com"]                ="ajax/adverts/getPriceNStockCom";

$route["img-delete-pro/(.*)"]                   ="ajax/adverts/proImageDelete/$1";

$route["get-price-no-stock-update/(.*)"]        ="ajax/adverts/advertUpdateNoStock/$1";

$route["get-price-stock-update/(.*)"]           ="ajax/adverts_update/advertUpdateStock/$1";

$route["add-stock-product"]                     ="ajax/adverts_update/addStocks";

$route["delete-stock"]                          ="ajax/adverts_update/deleteStock";



//ilanlarım

$route["get-my-post-list"]             ="ajax/adverts/myAdvertsList";

$route["set-product-delete"]           ="ajax/adverts/myAdvertsDelete";

$route["up-your-advert"]                 ="ajax/adverts/upMyAdvert";

//Siparişlerim

$route["get-list-my-orders"]           ="userpanel/orderlist/myOrdersList";

$route["get-list-my-selltous-orders"]  ="userpanel/orderlist/mySellToUsOrdersList";

$route["get-info-prod-order"]          ="userpanel/orderlist/getInfoOrder";

$route["set-orders-review"]            ="userpanel/orderlist/orderReview";





//destek

$route["add-create-request"]           ="ajax/support/addCreateRequest";

$route["get-support-list"]             ="ajax/support/getSupportLists";

$route["set-answer-message"]           ="ajax/support/setAnswerMessage";



//Profil Doğrulama

$route["set-profil-verificate"]        ="ajax/trustuser/getUpdateProfileVerify";

$route["set-profil-callback"]          ="ajax/trustuser/geriSayim";



//İlanlar Modülü

$route["get-list-category"]            ="ajax/Adverts_list/getListCategoryAjax";

$route["get-list-category-filter"]     ="ajax/Adverts_list/getListCategoryAjaxFilter";



//Sipariş Oluşturma

$route["create-ad-order"]              ="orders/adorders/addOrderAds";


//Üye Paneli Hesap Ayarları

$route["account-setting-update"]        ="userpanel/accounts/setAccountUpdate";



//Banka Hesapları

$route["get-user-bank-list"]            ="ajax/user/banks/listBanks";

$route["add-user-bank"]                 ="ajax/user/banks/addBanks";

$route["update-user-bank"]              ="ajax/user/banks/updateBanks";

$route["get-record-bank"]               ="ajax/user/banks/getRecord";

$route["set-delete-bank"]               ="ajax/user/banks/deleteBanks";





//Çekim Talepleri

$route["get-user-with-list"]            ="ajax/user/withdraw/listTable";

$route["add-user-with"]                 ="ajax/user/withdraw/addWith";



//İlan Siparişlerim

$route["get-list-my-ad-orders"]         ="userpanel/orderAdverts/getListMyOrders";

$route["get-info-order-ad"]             ="userpanel/orderAdverts/getInfoOrder";

$route["set-order-review"]              ="userpanel/orderAdverts/orderReview";



//Bildirimlerim

$route["get-list-my-notificate"]       ="userpanel/notifications/getListMyNotificate";

$route["api/getDistricts/(:num)"]   ="userpanel/accounts/getDistricts/$1";



//Mağaza Profili

$route["follow-store"]                  ="ajax/store/setFollowStore";

$route["unfollow-store"]                ="ajax/store/setUnfollowStore";

$route["send-new-message"]              ="ajax/store/addNewMessage";



//Üye Paneli Mesajlarım

$route["send-message-post"]             ="userpanel/messages/sendMessages";

$route["message-load"]                  ="userpanel/messages/messageLoad";



//İlan Satışlarım

$route["get-list-my-sell-orders"]       ="userpanel/orderAdverts/getListMySellOrders";

$route["set-seller-delivery-confirm"]    ="userpanel/orderAdverts/setSellerConfirm";

$route["message-load-adverts"]          ="userpanel/orderAdverts/messageGet";

$route["message-load-adverts-buyer"]    ="userpanel/orderAdverts/messageGetBuyer";

$route["message-send-adverts"]          ="userpanel/orderAdverts/sendMessages";

$route["upload-video-proof"]          ="userpanel/orderAdverts/uploadVideoProof";
$route["order-buyer-confirm"]            ="userpanel/orderAdverts/buyerConfirm";



//İlan Sipariş Destek Talebi

$route["set-support-post"]              ="userpanel/orderAdverts/addCreateRequest";



//İlan Sipariş Alıcı İptali

$route["set-order-cancel"]              ="userpanel/orderAdverts/orderCancel";

$route["order-teslimat"]                ="ajax/orderads/setOrderStatus";

//$route["qcv2_return/(.*)"]              ="ajax/Functions/gets/$1";

$route["sessionsil/(.*)"]                   ="ajax/Functions/gets/$1";



//sms gonderimi

$route["get-sms-task"]                  ="ajax/store/getSmsTask";



//Doping İşlemleri

$route["get-info-doping"]               ="ajax/doping/getInfoDoping/1";

$route["get-info-doping-type"]          ="ajax/doping/getInfoDoping/2";

$route["set-doping"]                    ="ajax/doping/getInfoDoping/3";



//Sitemap

$route["sitemap.xml"]            ="sitemap/index";

//Language



$route["token-control"]                 ="ajax/bingo/tokeControl";



//dil verilerilerini çeker

$route["getlangVal"]   ="ajax/language/getVal";





//Sepet

$route["getNotifications"]           ="user/notifications/get_notifications";

//Üye Profil

$route["invoice-update"]                ="user/InvoiceController/update";



$route["get-list-my-talep"]             ="ajax/profile/getListeMyDemands";

$route["get-list-my-noti"]              ="user/Notifications/getListeMyNoti";

$route["get-list-my-balance"]           ="ajax/profile/getListeMyBalance";

$route["user-verification"]             ="ajax/profile/userVerification";

$route["user-change-password"]          ="user/Api/userChangePass";

$route["get-order-info"]                ="ajax/profile/getOrderInfo";

$route["get-ads-order-info"]            ="ajax/profile/getAdsOrderInfo";

$route["add-order-comment"]             ="ajax/profile/addOrderComments";

$route["add-ads-order-comment"]         ="ajax/profile/addAdsOrderComments";

$route["exporttxt/(.*)"]                ="ajax/profile/exportTXT/$1";

$route["add-order-talep"]               ="ajax/profile/addOrderTalep";

$route["add-talep-message"]             ="ajax/profile/talepMessageAdd";

$route["add-order-talep-ads"]           ="ajax/profile/addOrderTalepAds";

$route["add-ads-order-message"]         ="ajax/orderads/orderMessageAddSeller";

$route["add-ads-order-message-buyer"]   ="ajax/orderads/orderMessageAddBuyer";

$route["ad-onay-send-code"]            ="ajax/orderads/addSendCode";

$route["get-category-select"]           ="ajax/profile/getCategorySelect";

$route["set-ad-delete"]                 ="ajax/profile/setDeleteAdvert";

$route["my-add-doping"]                 ="ajax/profile/addDoping";

$route["set-ad-image"]                  ="ajax/adverts/setImageDelete";

$route["pay-update-set-name"]           ="ajax/profile/payUpdateSetName";

//Ayarlar

$route["profile-setting-update"]        ="ajax/store/updateProfileSetting";



//Mesajlar

$route["ads-new-message"]               ="ajax/message/adsNewmessage";



$route["get-select-message"]            ="ajax/message/getSelectedMessage";

$route["uye-sms-gonder"]                ="ajax/message/sendUserSMS";



$route["ilanlar/ilan-republish/(.*)"]                      = "Home/republishAdvert/$1";



// Twitch Authenticate

$route["twitch-auth"]               = "ajax/twitch/authenticate";

$route["twitch-remove-auth"]        = "ajax/twitch/removeAuthenticate";



// Streamlabs Authenticate

$route["streamlabs-auth"]               = "ajax/streamlabs/authenticate";

$route["streamlabs-remove-auth"]        = "ajax/streamlabs/removeAuthenticate";



// Youtube Authenticate

$route["youtube-auth"]              = "ajax/youtube/authenticate";

$route["youtube-remove-auth"]       = "ajax/youtube/removeAuthenticate";



// Streamer

$route["streamer-application-update"] = "ajax/twitch/streamerUserUpdate";



// Streamer Donate

$route["donate-to-streamer"]        = "ajax/streamer/donate";

// Raffle
$route["create-raffle"]             = "ajax/raffle/create";
$route["join-to-raffle"]             = "ajax/raffle/joinToRaffle";

$route["(.*)"]                      = "Home/index/$1";

$route["(.*)/(.*)"]                 = "Home/index/$1/$2";

$route["(.*)/(.*)/(.*)"]            = "Home/index/$1/$2/$3";

$route["(.*)/(.*)/(.*)/(.*)"]       = "Home/index/$1/$2/$3/$4";

$route["(.*)/(.*)/(.*)/(.*)/(.*)"]  = "Home/index/$1/$2/$3/$4/$5";













