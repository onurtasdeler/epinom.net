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
$route['my-account'] = "Account";
$route['order/(:num)'] = "order/index/$1";
$route['news/edit/(:num)'] = "news/edit/$1";
$route['categories/edit/(:num)'] = "categories/edit/$1";
$route['users/view/(:num)'] = "users/view/$1";
$route['user/(:num)'] = $route['users/view/(:num)'];

$route['settings/social/(:num)'] = "social/view/$1";
$route['settings/payment/(:num)'] = "settings/payment/$1";

$route['stocks/edit/(:num)'] = "stocks/edit/$1";

$route['paynotifications/list'] = "PayNotifications";
$route['paynotifications'] = "PayNotifications/list";
$route['paynotifications/process/(:num)'] = "PayNotifications/process/$1";

$route['balancewithdrawrequest/process/(:num)'] = "balancewithdrawrequests/process/$1";

$route['gamemoneys'] = 'Gamemoneys';
$route['gamemoneys/editcategory/(:num)'] = 'Gamemoneys/Editcategory/$1';
$route['gamemoneys/products/(:num)'] = 'Gamemoneys/Products/$1';

$route['dealers/(:num)/list'] = 'Dealers/List/$1';
$route['dealers/category/insert/(:num)'] = 'Dealers/insert/$1';
$route['dealers/item/view/(:num)'] = 'Dealers/view/$1';

$route['bankaccounts'] = 'BankAccounts';
$route['bankaccounts/list'] = 'BankAccounts';
$route['bankaccounts/add'] = 'BankAccounts/Add';
$route['bankaccounts/edit/(:num)'] = 'BankAccounts/Edit/$1';
$route['bankaccounts/delete/(:num)'] = 'BankAccounts/Delete/$1';

$route['salestats/bycategory'] = 'SaleStatsByCategory';