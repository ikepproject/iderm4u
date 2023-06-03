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
 * Route Healthcare
 * --------------------------------------------------------------------
 */

// Authentication API Endpoint Mobile - http://localhost:8080/api/mobile
$routes->post('api/app/auth/login', 'Api\AppAuth::login');         		

/**--- BACKEND FUNCTION ROUTES (Endpoint Function) ---*/
/**--- account ---*/
$routes->post('account/update', 'Web\Account::update', ["filter" => "authweb:1011-2020-2022-5050-5055-7077"]);
/**--- auth ---*/
$routes->post('dologin', 'Web\Auth::dologin'); 				
$routes->post('doregister', 'Web\Auth::doregister');
$routes->post('logout', 'Web\Auth::logout');
/**--- patient ---*/
$routes->get('patient/getdata', 'Web\Patient::getdata', ["filter" => "authweb:2020-2022-5050-5055-7077"]); 
$routes->post('patient/create', 'Web\Patient::create', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->post('patient/update', 'Web\Patient::update', ["filter" => "authweb:1011-2020-2022-5050-5055-7077"]);
$routes->post('patient/delete', 'Web\Patient::delete', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
/**--- treatment ---*/
$routes->get('treatment/getdata', 'Web\Treatment::getdata', ["filter" => "authweb:1011-2020-2022-5050-5055-7077"]); 
$routes->post('treatment/create', 'Web\Treatment::create', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->post('treatment/update', 'Web\Treatment::update', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->post('treatment/discount', 'Web\Treatment::discount', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
/**--- product ---*/
$routes->get('product/getdata', 'Web\Product::getdata', ["filter" => "authweb:2020-2022-5050-5055-7077"]); 
$routes->post('product/create', 'Web\Product::create', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->post('product/update', 'Web\Product::update', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->post('product/restock', 'Web\Product::restock', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
/**--- medical ---*/
$routes->get('medical/getdata', 'Web\Medical::getdata', ["filter" => "authweb:2020-2022-5050-5055-7077"]); 
$routes->post('medical/create', 'Web\Medical::create', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->post('medical/update', 'Web\Medical::update', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->post('medical/delete', 'Web\Medical::delete', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->post('medical/addgallery', 'Web\Medical::addgallery', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->post('medical/deletegallery', 'Web\Medical::deletegallery', ["filter" => "authweb:2020-2022-5050-5055-7077"]);          
$routes->post('medical/cancel', 'Web\Medical::cancel', ["filter" => "authweb:2020-2022-5050-5055-7077"]);                       
$routes->get('api/web/patient/get', 'Api\WebPatient::get', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->post('medical/diagnose', 'Web\Medical::diagnose', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->post('api/diagnose/aiclasify', 'Api\Diagnose::clasify', ["filter" => "authweb:2020-2022-5050-5055-7077"]);                        
/**--- refer (rujukan) ---*/
$routes->get('refer/getdata', 'Web\Refer::getdata', ["filter" => "authweb:2020-2022-5050-5055-7077"]); 
$routes->get('refer-visit/getdata', 'Web\Refer_Hospital::getdatavisit', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->get('refer-teledermatology/getdata', 'Web\Refer_Hospital::getdatatldm', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->get('refer-storefoward/getdata', 'Web\Refer_Hospital::getdatastfw', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->post('refer/create', 'Web\Refer::create', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->post('refer-visit/create', 'Web\Refer_Hospital::create', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->post('refer-visit/cancel', 'Web\Refer_Hospital::cancel', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
/**--- invoice ---*/
$routes->get('invoice/getdata', 'Web\Invoice::getdata', ["filter" => "authweb:1011-2020-2022-5050-5055-7077"]); 
/**--- product order ---*/
$routes->get('order/getdata', 'Web\Product_Order::getdata', ["filter" => "authweb:1011-2020-2022-5050-5055-7077"]);
/**--- appointment ---*/
$routes->get('appointment/getdata', 'Web\Appointment::getdata', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->post('appointment/accept', 'Web\Appointment::accept', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
/**--- transaction ---*/
$routes->post('transaction/cash', 'Web\Transaction::cash', ["filter" => "authweb:2020-2022-5050-5055-7077"]);                    
$routes->post('medicalrefer/create', 'Web\MedicalRefer::create', ["filter" => "authweb:2020-2022-5050-5055-7077"]);              
/**--- tes function ---*/
$routes->get('77test77/encrypt', 'Api\Test::encrypt:2020-2022-5050-5055-7077');
$routes->get('77test77/decrypt', 'Api\Test::decrypt:2020-2022-5050-5055-7077');
$routes->get('77test77/check', 'Api\Test::check:2020-2022-5050-5055-7077');  

/**--- FRONT END ROUTES (Endpoint pages)---*/
/**--- landing page ---*/
$routes->get('/', 'Web\Landing::index');									        
$routes->get('/privacy', 'Web\Landing::privacy');									
$routes->get('/terms-and-conditions', 'Web\Landing::toc');							
$routes->get('login', 'Web\Auth::login');  									        
$routes->get('register', 'Web\Auth::register');  							       
$routes->get('dashboard', 'Web\Dashboard::index', ["filter" => "authweb:1011-2020-2022-5050-5055-7077"]);         
$routes->get('/test_purchase', 'Web\Landing::test_pruchase');						
$routes->get('/test_checkout', 'Web\Landing::test_checkout');
/**--- Account ---*/
$routes->get('account', 'Web\Account::index', ["filter" => "authweb:1011-2020-2022-5050-5055-7077"]);
/**--- patient ---*/
$routes->get('patient', 'Web\Patient::index', ["filter" => "authweb:2020-2022-5050-5055-7077"]);                     
$routes->get('patient/formadd', 'Web\Patient::formadd', ["filter" => "authweb:2020-2022-5050-5055-7077"]);           
$routes->post('patient/formdetail', 'Web\Patient::formdetail', ["filter" => "authweb:2020-2022-5050-5055-7077"]);    
$routes->post('patient/formedit', 'Web\Patient::formedit', ["filter" => "authweb:2020-2022-5050-5055-7077"]);        
/**--- treatment ---*/
$routes->get('treatment', 'Web\Treatment::index', ["filter" => "authweb:1011-2020-2022-5050-5055-7077"]);                
$routes->get('treatment/formadd', 'Web\Treatment::formadd', ["filter" => "authweb:2020-2022-5050-5055-7077"]);      
$routes->post('treatment/formedit', 'Web\Treatment::formedit', ["filter" => "authweb:2020-2022-5050-5055-7077"]);   
$routes->post('treatment/formdiscount', 'Web\Treatment::formdiscount', ["filter" => "authweb:2020-2022-5050-5055-7077"]);   
/**--- product ---*/
$routes->get('product', 'Web\Product::index', ["filter" => "authweb:2020-2022-5050-5055-7077"]);                 
$routes->get('product/formadd', 'Web\Product::formadd', ["filter" => "authweb:2020-2022-5050-5055-7077"]);       
$routes->post('product/formedit', 'Web\Product::formedit', ["filter" => "authweb:2020-2022-5050-5055-7077"]);    
$routes->post('product/formstock', 'Web\Product::formstock', ["filter" => "authweb:2020-2022-5050-5055-7077"]);  
$routes->get('product-flow', 'Web\Product::flow', ["filter" => "authweb:2020-2022-5050-5055-7077"]);             
$routes->post('product-flow/filter', 'Web\Product::flow_filter', ["filter" => "authweb:2020-2022-5050-5055-7077"]); 
/**--- medical ---*/
$routes->get('medical', 'Web\Medical::index', ["filter" => "authweb:2020-2022-5050-5055-7077"]);                                 
$routes->get('medicalformadd', 'Web\Medical::formadd', ["filter" => "authweb:2020-2022-5050-5055-7077"]);                        
$routes->post('medical/formdetail', 'Web\Medical::formdetail', ["filter" => "authweb:1011-2020-2022-5050-5055-7077"]);                
$routes->post('medical/formdiagnose', 'Web\Medical::formdiagnose', ["filter" => "authweb:1011-2020-2022-5050-5055-7077"]);            
/**--- refer (rujukan) ---*/
$routes->get('refer', 'Web\Refer::index', ["filter" => "authweb:2020-2022-5050-5055-7077"]);                                     
$routes->get('refer-visit', 'Web\Refer_Hospital::index', ["filter" => "authweb:2020-2022-5050-5055-7077"]);                      
$routes->get('refer-teledermatology', 'Web\Refer_Hospital::index', ["filter" => "authweb:2020-2022-5050-5055-7077"]); 
$routes->get('refer-storefoward', 'Web\Refer_Hospital::index', ["filter" => "authweb:2020-2022-5050-5055-7077"]);           
$routes->get('refer-visit/add', 'Web\Refer_Hospital::refer_visit', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
/**--- invoice ---*/
$routes->get('invoice', 'Web\Invoice::index', ["filter" => "authweb:2020-2022-5050-5055-7077"]);                                 
/**--- product order ---*/
$routes->get('order', 'Web\Product_Order::index', ["filter" => "authweb:1011-2020-2022-5050-5055-7077"]);                            
/**--- appointment ---*/
$routes->get('appointment', 'Web\Appointment::index', ["filter" => "authweb:2020-2022-5050-5055-7077"]);                          
$routes->post('appointment/formaccept', 'Web\Appointment::formaccept', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
$routes->post('appointment/formdetail', 'Web\Appointment::formdetail', ["filter" => "authweb:2020-2022-5050-5055-7077"]);           
/**--- transaction ---*/
$routes->get('transaction/(:any)/(:any)', 'Web\Transaction::checkout/$1/$2', ["filter" => "authweb:1011-2020-2022-5050-5055-7077"]);   
$routes->post('transaction/token', 'Web\Midtrans::token', ["filter" => "authweb:1011-2020-2022-5050-5055-7077"]);  
$routes->post('transaction/finish', 'Web\Midtrans::finish'); 
$routes->post('transaction/hook', 'Web\Midtrans::hook');
$routes->post('transaction/formpayinfo', 'Web\Transaction::formpayinfo', ["filter" => "authweb:2020-2022-5050-5055-7077"]);
/**--- report ---*/       
$routes->get('report-treatment', 'Web\Report::report_treatment', ["filter" => "authweb:2020-2022-5050-5055-7077"]);             
$routes->post('report-treatment/filter', 'Web\Report::report_treatment_filter', ["filter" => "authweb:2020-2022-5050-5055-7077"]); 
$routes->get('report-product', 'Web\Report::report_product', ["filter" => "authweb:2020-2022-5050-5055-7077"]);             
$routes->post('report-product/filter', 'Web\Report::report_product_filter', ["filter" => "authweb:2020-2022-5050-5055-7077"]); 

//Mobile API Endpoint Group Example
// $routes->group('api', ["filter" => "authapp"],  function($routes) {
// 	$routes->get('user', 'Api\User::index');
// });

/**
 * --------------------------------------------------------------------
 * Route Patient
 * --------------------------------------------------------------------
 */
/**--- BACKEND FUNCTION ROUTES (Endpoint Function) ---*/
/**--- appointment ---*/
$routes->post('appointment-create', 'Web\Appointment::create_patient', ["filter" => "authweb:1011"]);
$routes->post('appointment/cancel', 'Web\Appointment::cancel', ["filter" => "authweb:1011"]); 
/**--- product order ---*/ 
$routes->post('order-product-search', 'Web\Product_Order::index_patient_search', ["filter" => "authweb:1011"]); 
$routes->post('order-product/formorder', 'Web\Product_Order::formorder', ["filter" => "authweb:1011"]); 
$routes->post('order-product/cart', 'Web\Product_Order::cart', ["filter" => "authweb:1011"]);
$routes->post('order-product/cancel', 'Web\Product_Order::cancel', ["filter" => "authweb:1011"]);
$routes->post('order-product/checkout', 'Web\Product_Order::checkout', ["filter" => "authweb:1011"]);

/**--- FRONT END ROUTES (Endpoint pages)---*/
/**--- appointment ---*/
$routes->get('appointment-list', 'Web\Appointment::index_patient', ["filter" => "authweb:1011"]);
$routes->get('appointment-getdata', 'Web\Appointment::getdata_patient', ["filter" => "authweb:1011"]);                           
$routes->get('appointment-formadd', 'Web\Appointment::formadd_patient', ["filter" => "authweb:1011"]);
/**--- medical ---*/ 
$routes->get('medical-record', 'Web\Medical::index_patient', ["filter" => "authweb:1011"]);  
$routes->get('medical-getdata', 'Web\Medical::getdata_patient', ["filter" => "authweb:1011"]);
/**--- product order ---*/ 
$routes->get('order-product', 'Web\Product_Order::index_patient', ["filter" => "authweb:1011"]);  
$routes->post('order-product/formorder', 'Web\Product_Order::formorder', ["filter" => "authweb:1011"]); 
$routes->get('order-cart', 'Web\Product_Order::cart_patient', ["filter" => "authweb:1011"]); 
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
