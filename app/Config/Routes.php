<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function( $message = null )
{
    
    $data = [
        'title' => '404 Page not found',
        'message' => $message,
        'code'  => '404',
    ];
    echo view('errors/404', $data);
});
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->setDefaultNamespace('');


/**
 * --------------------------------------------------------------------
 * My Route
 * --------------------------------------------------------------------
 */

// Authentication API Endpoint Mobile - http://localhost:8080/api/mobile
$routes->post('api/app/auth/login', 'Api\AppAuth::login');         		

// Web Action
$routes->post('dologin', 'Web\Auth::dologin'); 				
$routes->post('doregister', 'Web\Auth::doregister');
$routes->post('logout', 'Web\Auth::logout');

$routes->get('patient/getdata', 'Web\Patient::getdata', ["filter" => "authweb"]); 
$routes->post('patient/create', 'Web\Patient::create', ["filter" => "authweb"]);
$routes->post('patient/update', 'Web\Patient::update', ["filter" => "authweb"]);
$routes->post('patient/delete', 'Web\Patient::delete', ["filter" => "authweb"]);

$routes->get('treatment/getdata', 'Web\Treatment::getdata', ["filter" => "authweb"]); 
$routes->post('treatment/create', 'Web\Treatment::create', ["filter" => "authweb"]);
$routes->post('treatment/update', 'Web\Treatment::update', ["filter" => "authweb"]);
$routes->post('treatment/discount', 'Web\Treatment::discount', ["filter" => "authweb"]);

$routes->get('product/getdata', 'Web\Product::getdata', ["filter" => "authweb"]); 
$routes->post('product/create', 'Web\Product::create', ["filter" => "authweb"]);
$routes->post('product/update', 'Web\Product::update', ["filter" => "authweb"]);
$routes->post('product/restock', 'Web\Product::restock', ["filter" => "authweb"]);

$routes->get('medical/getdata', 'Web\Medical::getdata', ["filter" => "authweb"]); 
$routes->post('medical/create', 'Web\Medical::create', ["filter" => "authweb"]);
$routes->post('medical/update', 'Web\Medical::update', ["filter" => "authweb"]);
$routes->post('medical/delete', 'Web\Medical::delete', ["filter" => "authweb"]);
$routes->post('medical/addgallery', 'Web\Medical::addgallery', ["filter" => "authweb"]);                //Medical Detail Add Gallery
$routes->post('medical/deletegallery', 'Web\Medical::deletegallery', ["filter" => "authweb"]);          //Medical Detail Delete Gallery
$routes->post('medical/cancel', 'Web\Medical::cancel', ["filter" => "authweb"]);                        //Medical Cancel Action
$routes->get('api/web/patient/get', 'Api\WebPatient::get', ["filter" => "authweb"]);

$routes->get('refer/getdata', 'Web\Refer::getdata', ["filter" => "authweb"]); 
$routes->post('refer/create', 'Web\Refer::create', ["filter" => "authweb"]);

$routes->get('invoice/getdata', 'Web\Invoice::getdata', ["filter" => "authweb"]); 

$routes->get('order/getdata', 'Web\Product_Order::getdata', ["filter" => "authweb"]);

$routes->get('appointment/getdata', 'Web\Appointment::getdata', ["filter" => "authweb"]);

$routes->post('transaction/cash', 'Web\Transaction::cash', ["filter" => "authweb"]);                    //Cash Pay Confirmation
$routes->post('medicalrefer/create', 'Web\MedicalRefer::create', ["filter" => "authweb"]);              //Medical Refer Create

$routes->get('patient/tes', 'Web\Patient::tes'); 

//Web Admin Access Frontend
$routes->get('/', 'Web\Landing::index');									        //Landing Front Page
$routes->get('/privacy', 'Web\Landing::privacy');									//Privacy Page
$routes->get('/terms-and-conditions', 'Web\Landing::toc');							//TOC Page
$routes->get('login', 'Web\Auth::login');  									        //Login Page
$routes->get('register', 'Web\Auth::register');  							        //Register Page
$routes->get('dashboard', 'Web\Dashboard::index', ["filter" => "authweb"]);         //Dashboard Page
$routes->get('/test_purchase', 'Web\Landing::test_pruchase');						//Untuk test verifikasi dari midtrans
$routes->get('/test_checkout', 'Web\Landing::test_checkout');	

$routes->get('patient', 'Web\Patient::index', ["filter" => "authweb"]);                     //Pasien Page
$routes->get('patient/formadd', 'Web\Patient::formadd', ["filter" => "authweb"]);           //Pasien Add Modal
$routes->post('patient/formdetail', 'Web\Patient::formdetail', ["filter" => "authweb"]);    //Pasien Detail Modal
$routes->post('patient/formedit', 'Web\Patient::formedit', ["filter" => "authweb"]);        //Pasien Edit Modal

$routes->get('treatment', 'Web\Treatment::index', ["filter" => "authweb"]);                //Treatment Page
$routes->get('treatment/formadd', 'Web\Treatment::formadd', ["filter" => "authweb"]);      //Treatment Add Modal
$routes->post('treatment/formedit', 'Web\Treatment::formedit', ["filter" => "authweb"]);   //Treatment Edit Modal
$routes->post('treatment/formdiscount', 'Web\Treatment::formdiscount', ["filter" => "authweb"]);   //Treatment Discount Modal

$routes->get('product', 'Web\Product::index', ["filter" => "authweb"]);                 //Product Page
$routes->get('product/formadd', 'Web\Product::formadd', ["filter" => "authweb"]);       //Product Add Modal
$routes->post('product/formedit', 'Web\Product::formedit', ["filter" => "authweb"]);    //Product Edit Modal
$routes->post('product/formstock', 'Web\Product::formstock', ["filter" => "authweb"]);  //Product Stock Modal

$routes->get('medical', 'Web\Medical::index', ["filter" => "authweb"]);                                 //Medical Page
$routes->get('medicalformadd', 'Web\Medical::formadd', ["filter" => "authweb"]);                        //Medical Add Page
$routes->post('medical/formdetail', 'Web\Medical::formdetail', ["filter" => "authweb"]);                //Medical Detail Modal

$routes->get('refer', 'Web\Refer::index', ["filter" => "authweb"]);                                     //Refer Page

$routes->get('invoice', 'Web\Invoice::index', ["filter" => "authweb"]);                                 //Invoice Page

$routes->get('order', 'Web\Product_Order::index', ["filter" => "authweb"]);                             //Product_Order Page

$routes->get('appointment', 'Web\Appointment::index', ["filter" => "authweb"]);                          //Appointment Page

$routes->get('transaction/(:any)/(:any)', 'Web\Transaction::checkout/$1/$2', ["filter" => "authweb"]);  //Pay & Invoice 

// $routes->get('transaction2/(:any)/(:any)', 'Web\Transaction::checkout/$1/$2', ["filter" => "authweb"]);  //Pay & Invoice 
$routes->post('transaction/token', 'Web\Midtrans::token', ["filter" => "authweb"]);  
$routes->post('transaction/finish', 'Web\Midtrans::finish'); 

$routes->post('transaction/formpayinfo', 'Web\Transaction::formpayinfo', ["filter" => "authweb"]);       //Cash Checkout Modal
// $routes->post('transaction/formcash', 'Web\Transaction::formcash', ["filter" => "authweb"]);         //Cash Checkout Modal

//Mobile API Endpoint Group Example
// $routes->group('api', ["filter" => "authapp"],  function($routes) {
// 	$routes->get('user', 'Api\User::index');
// });

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
