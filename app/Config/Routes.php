<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Admin');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

//admin routes
$routes->group("admin", ["filter" => "adminAuthGuard"], function ($routes) {
	$routes->add("dashboard", '\Modules\Dashboard\Controllers\AdminController::index');
	$routes->add("dashboard/export", '\Modules\Dashboard\Controllers\AdminController::exportData');
	$routes->add("dashboard/initChart", '\Modules\Dashboard\Controllers\AdminController::initChart');
	$routes->add("dashboard/monthlyCustomers", '\Modules\Dashboard\Controllers\AdminController::monthlyCustomers');
	$routes->add("dashboard/skip_traced_chart", '\Modules\Dashboard\Controllers\AdminController::skip_traced_chart');
	$routes->add("upload", '\Modules\Dashboard\Controllers\AdminController::upload');
	
	//$routes->add('img-upload', '\Modules\Challenges\Controllers\AdminController::imgUpload');
	$routes->add("remove_upload_images", '\Modules\Dashboard\Controllers\AdminController::remove_upload_images');
	$routes->add("claculate_retail_value", '\Modules\Dashboard\Controllers\AdminController::claculateRetailValue');
	$routes->add("claculate_rental_transaction", '\Modules\Dashboard\Controllers\AdminController::claculateRentalTransaction');
	$routes->add("claculate_membership_pie", '\Modules\Dashboard\Controllers\AdminController::CalculateMembershipPie');



	//for customers
	$routes->group('customers', function ($routes) {
		$routes->add('/', '\Modules\Customers\Controllers\AdminController::index');
		$routes->add('add', '\Modules\Customers\Controllers\AdminController::add');
		$routes->add('edit/(:num)', '\Modules\Customers\Controllers\AdminController::edit/$1');
		$routes->add('delete', '\Modules\Customers\Controllers\AdminController::delete');
		$routes->add('change_status', '\Modules\Customers\Controllers\AdminController::changeStatus');
	});



	
	//for Media
	$routes->group('media', function ($routes) {
		$routes->add('/', '\Modules\Media\Controllers\AdminController::index');
		$routes->add('gallery/(:num)', '\Modules\Media\Controllers\AdminController::gallery/$1');
		$routes->add('fileUpload', '\Modules\Media\Controllers\AdminController::fileUpload');
		$routes->add('delete/(:num)', '\Modules\Media\Controllers\AdminController::delete/$1');
		$routes->add('change_status', '\Modules\Media\Controllers\AdminController::changeStatus');
		$routes->add('remove_image', '\Modules\Media\Controllers\AdminController::removeImage');
	});
	


		//for Storyline
	$routes->group('department', function ($routes) {
		$routes->add('/', '\Modules\Department\Controllers\AdminController::index');
		$routes->add('add', '\Modules\Department\Controllers\AdminController::add');
		$routes->add('edit/(:num)', '\Modules\Department\Controllers\AdminController::edit/$1');
		$routes->add('delete', '\Modules\Department\Controllers\AdminController::delete');
		$routes->add('fileUpload', '\Modules\Department\Controllers\AdminController::fileUpload');
		$routes->add("img-upload", '\Modules\Department\Controllers\AdminController::imgUpload');
		$routes->add('remove_image', '\Modules\Department\Controllers\AdminController::removeImage');
		$routes->add('change_status', '\Modules\Department\Controllers\AdminController::changeStatus');
		$routes->add('delete_image/(:num)', '\Modules\Department\Controllers\AdminController::delete_image/$1');
		$routes->add('get-challenges', '\Modules\Department\Controllers\AdminController::getChallenges');
		$routes->add('clone/(:num)', '\Modules\Department\Controllers\AdminController::clone/$1');
	});

		//for Project
	$routes->group('project', function ($routes) {
		$routes->add('/', '\Modules\Project\Controllers\AdminController::index');
		$routes->add('add', '\Modules\Project\Controllers\AdminController::add');
		$routes->add('edit/(:num)', '\Modules\Project\Controllers\AdminController::edit/$1');
		$routes->add('delete', '\Modules\Project\Controllers\AdminController::delete');
		$routes->add('change_status', '\Modules\Project\Controllers\AdminController::changeStatus');
	});
	
	
	$routes->group('profile', function ($routes) {
		$routes->add('/', '\Modules\Profile\Controllers\AdminController::index');
	});

	
	$routes->add("logout", '\Modules\Dashboard\Controllers\AdminController::logout');
});

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
//for user
$routes->match(['get','post'],'login', 'Home::login');
$routes->get('/register', 'Home::register');
$routes->post('/register', 'Home::register');
$routes->get('/about', 'Home::about');
$routes->get('/faqs', 'Home::faqs');
$routes->get('/privacy-policy', 'Home::privacy_policy');
$routes->get('/terms-and-conditions', 'Home::term_condition');
$routes->get('/how-it-works', 'Home::how_it_works');
$routes->get('/contact', 'Home::contact');
$routes->get('/adventures', 'Home::adventures');
$routes->get('/adventure/(:any)', 'Home::adventure/$1');
$routes->post('/forgot_password', 'Home::forgot_password');
$routes->post('/add-contact-form', 'Home::add_contact_form');
//$routes->post('/get-in-touch', 'Home::get_in_touch');
$routes->match(['get','post'],'change-password', 'Home::change_password');



$routes->group("user", ["filter" => "userAuthGuard"], function ($routes) {
	//$routes->add("dashboard", 'User::index');
	// order
	$routes->add('checkout/(:num)', 'User::checkout/$1');

	// check team code
	$routes->add('check-teamcode', 'User::checkTeamCode');
	

	// inside account
	$routes->add('dashboard', 'User::dashboard');
	$routes->add('orders', 'User::orders');
	$routes->add("edit-profile", 'User::editProfile');
	$routes->add('booking-profile', 'User::bookingProfile');
	$routes->add('profile-history', 'User::profileHistory');
	$routes->add("thank-you", 'User::thankYou');
	$routes->add("email", 'User::email');
	$routes->add("logout", 'User::logout');
	$routes->add("upload-image", 'User::upload');
});

$routes->group("game",["filter" => "userAuthGuard"], function ($routes) {
	$routes->add("/", 'Game::index');
	$routes->add("challenge", 'Game::challenge');
	$routes->add("submit-challenge", 'Game::submitChallenge');
	$routes->add("continue-story-line", 'Game::continueStoryLine');
	$routes->add("get-completed", 'Game::getCompletedAt');
	
});
$routes->group("paypal",["filter" => "userAuthGuard"], function ($routes) {

	$routes->add("process", 'Paypal::index');
	$routes->add("payment-success", 'Paypal::paymentSuccess');
	$routes->add("payment-fail", 'Paypal::paymentFail');
	
});


//$routes->get('/', 'Admin::index');
$routes->get('lang/{locale}', 'Language::index'); 

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

/*
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

//...  

// Add this to Footer, Including all module routes

$modules_path = APPPATH . 'Modules/';
$modules = scandir($modules_path);

foreach ($modules as $module) {
	if ($module === '.' || $module === '..') {
		continue;
	}

	if (is_dir($modules_path) . '/' . $module) {
		$routes_path = $modules_path . $module . '/Config/Routes.php';
		if (file_exists($routes_path)) {
			require $routes_path;
		} else {
			continue;
		}
	}
}
