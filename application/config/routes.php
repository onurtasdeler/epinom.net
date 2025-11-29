<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'main';
$route['404_override'] = 'Error404';
$route['translate_uri_dashes'] = FALSE;

/*
    CUSTOM ROUTES
*/
$route['api/pay/iyzico'] = 'Callback/iyzico';
$route['api/pay/paytr'] = 'Callback/paytr';
$route['api/pay/shopier'] = 'Callback/shopier';
$route['api/pay/gpay'] = 'Callback/gpay';
$route['api/pay/payreks'] = 'Callback/payreks';
$route['api/pay/payreksKrediKarti'] = 'Callback/payreksKrediKarti';
$route['api/pay/paybros'] = 'Callback/paybrothers';
$route['api/pay/paybyme'] = 'Callback/paybyme';
$route['api/pay/paymes'] = 'Callback/paymes';
$route['api/pay/paymax'] = 'Callback/paymax';
$route['api/pay/pinabi'] = 'Callback/pinabi';

$route['api/donate/streamlabs'] = 'Callback/streamlabs';

$route['api/login/fb-callback'] = 'Api/FacebookCallback';

$route['api/cart/(:any)'] = 'Api/Cart/$1';

$route['tum-oyunlar'] = 'Games/All';
$route['oyunlar/(:any)'] = 'Games/Game/$1';
$route['oyunlar/(:any)/(:any)/(:num)'] = 'Games/Product/$3';

$route['indirimli-urunler'] = 'Discounts/Index';

$route['oyun-parasi'] = 'GameMoney/All';
$route['oyun-parasi/(:any)/(:num)'] = 'GameMoney/Category/$1/$2';
$route['oyun-parasi-urunu/(:any)/(:num)'] = 'GameMoney/Product/$1/$2';
$route['oyun-parasi-urunu/(:any)/(:num)/bize-sat'] = 'GameMoney/Selltous/$1/$2';

$route['odeme-yontemleri'] = 'PaymentMethods';

$route['bakiye-yukle'] = $route['odeme-yontemleri'];
$route['bakiye-yukle/gpay/(:any)'] = 'PaymentMethods/gpay/$1';
$route['bakiye-yukle/paytr/(:any)'] = 'PaymentMethods/paytr/$1';
$route['bakiye-yukle/payreks/(:any)'] = 'PaymentMethods/payreks/$1';
$route['bakiye-yukle/paybrothers/(:any)'] = 'PaymentMethods/paybrothers/$1';
$route['bakiye-yukle/paybyme/(:any)'] = 'PaymentMethods/paybyme/$1';
$route['bakiye-yukle/paymes'] = 'PaymentMethods/paymes';
$route['bakiye-yukle/paymax'] = 'PaymentMethods/paymax';
$route['bakiye-yukle/banka-hesaplari'] = 'PaymentMethods/bank_accounts';

$route['destek'] = 'HelpDesk';
$route['destek/(:num)'] = 'HelpDesk/Index';
$route['destek/yeni-destek-talebi'] = 'HelpDesk/Add';
$route['destek/talep/(:num)'] = 'HelpDesk/View/$1';

$route['sifremi-unuttum'] = 'User_controller/ForgotPassword';
$route['sifremi-unuttum/(:any)'] = 'User_controller/ForgotPasswordStep2/$1';
$route['uye/cikis-yap'] = 'User_controller/Logout';
$route['uye'] = 'User_controller/Index';
$route['uye/aktivasyon/(:any)'] = 'User_controller/ActivationPage/$1';
$route['uye/giris-yap'] = 'User_controller/LoginPage';
$route['uye/kayit-ol'] = 'User_controller/RegisterPage';

$route['uye/hesabim'] = 'User_controller/MyAccount';
$route['uye/hesabim/sifre'] = 'User_controller/RenewPassword';
$route['uye/siparislerim'] = 'User_controller/Orders';
$route['uye/guvenlik-ayarlari'] = 'User_controller/SecuritySettings';
$route['uye/oyun-parasi-siparislerim'] = 'User_controller/GameMoneyOrders';
$route['uye/satislarim'] = 'User_controller/GameMoneySelltous';
$route['uye/odeme-bildirimlerim'] = 'User_controller/PaymentNotifications';
$route['uye/bildirimlerim'] = 'User_controller/Notifications';
$route['uye/odeme-gecmisim'] = 'User_controller/MyPaymentLogs';
$route['uye/cekim-bildirimlerim'] = 'User_controller/BalanceWithdraws';
$route['uye/cekim-bildirimlerim/olustur'] = 'User_controller/AddBalanceWithdrawRequest';
$route['uye/banka-hesaplarim'] = 'User_controller/MyBankAccounts';
$route['uye/banka-hesaplarim/olustur'] = 'User_controller/MyBankAccountsAdd';
$route['uye/tc-dogrulama'] = 'User_controller/TCVerification';

$route['uye/referans-sistemi'] = 'User_controller/ReferenceSystem';
$route['uye/bagis-sistemi'] = 'User_controller/DonateSystem';

$route['ref/(:any)'] = 'User_controller/Reference/$1';

$route['sepetim'] = 'Cart';
$route['siparis-onayi'] = 'Cart/CartFinished';

$route['sayfa/(:any)'] = 'Pages/Index/$1';
$route['bize-ulasin'] = 'Pages/Index/bize-ulasin';

$route['haberler'] = 'News_controller';
$route['haberler/(:num)'] = 'News_controller/All';
$route['haber/(:any)'] = 'News_controller/Item/$1';

$route['pvp-serverlar'] = 'Pvpservers/All';
$route['pvp-serverlar/sunucularim'] = 'Pvpservers/Userservers';
$route['pvp-serverlar/sunucularim/sil/(:num)'] = 'Pvpservers/Userserversdelete/$1';
$route['pvp-serverlar/api'] = 'Pvpservers/Api';

$route['sitemap.xml'] = 'SEO/Sitemap';
// ═══════════════════════════════════════════════════════════════
// YENİ KULLANICI MODULU ROUTE'LARI (Auth ve Profile Controller)
// ═══════════════════════════════════════════════════════════════

// Auth Controller - Yeni guvenli kimlik dogrulama
$route['auth/giris'] = 'Auth_controller/login';
$route['auth/kayit'] = 'Auth_controller/register';
$route['auth/aktivasyon/(:any)'] = 'Auth_controller/activation/$1';
$route['auth/cikis'] = 'Auth_controller/logout';
$route['auth/sifremi-unuttum'] = 'Auth_controller/forgotPassword';
$route['auth/sifre-sifirla/(:any)'] = 'Auth_controller/resetPassword/$1';

// Profile Controller - Kullanici profil islemleri
$route['profil/anasayfa'] = 'Profile_controller/dashboard';
$route['profil/ayarlar'] = 'Profile_controller/settings';
$route['profil/sifre-degistir'] = 'Profile_controller/changePassword';
$route['profil/tc-dogrula'] = 'Profile_controller/tcVerification';
$route['profil/bakiye'] = 'Profile_controller/balance';
$route['profil/siparisler'] = 'Profile_controller/orders';
$route['profil/oyun-parasi'] = 'Profile_controller/gameMoneyOrders';
$route['profil/bildirimler'] = 'Profile_controller/notifications';
$route['profil/banka-hesaplari'] = 'Profile_controller/bankAccounts';
$route['profil/banka-hesabi-ekle'] = 'Profile_controller/addBankAccount';
$route['profil/referanslar'] = 'Profile_controller/referrals';
