<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth::index', ['as' => 'loginPage', "filter" => "reverseAuth"]);
$routes->post('/login', 'Auth::login', ['as' => 'login', "filter" => "reverseAuth"]);
$routes->get('/register', 'Auth::register', ['as' => 'register', "filter" => "reverseAuth"]);
$routes->post('/register/newUser', 'Auth::createNewUser', ['as' => 'newUser', "filter" => "reverseAuth"]);
$routes->get('/logout', 'Auth::logout', ['as' => 'logout']);
$routes->get('/resetPw', 'Auth::resetPassword', ['as' => 'resetPw']);
$routes->post('/resetPw/save', 'Auth::sendPwdResetEmail', ['as' => 'resetPwPost']);
$routes->get('/resetPw/token/(:segment)', 'Auth::checkToken/$1', ['as' => 'token']);
$routes->post('/resetPw/saveNewPassword', 'Auth::saveNewPassword', ['as' => 'saveNewPassword']);

$routes->group('/dashboard', ["filter" => "authenticate"], function ($routes) {
    $routes->get('home', 'Dashboard::index', ['as' => 'dashboard']);
    $routes->get('allProjects', 'Projects::index', ['as' => 'allProjects']);
    $routes->get('newProject', 'Projects::newProject', ['as' => 'newProject']);
    $routes->get('editProject/(:segment)', 'Projects::editProject/$1', ['as' => 'editProject']);
    $routes->post('saveProject', 'Projects::saveProject', ['as' => 'saveProject']);
    $routes->get('updateStatus', 'Projects::updateStatus', ['as' => 'updateStatus']);
    $routes->get('deleteProject', 'Projects::deleteProject', ['as' => 'deleteProject']);
});
$routes->group('/account', ["filter" => "authenticate"], function ($routes) {
    $routes->get('profile', 'Account::index', ['as' => 'account']);
    $routes->get('edit', 'Account::edit', ['as' => 'editAccount']);
    $routes->post('save', 'Account::save', ['as' => 'saveAccount']);
    $routes->get('changePassword', 'Account::changePassword', ['as' => 'changePassword']);
    $routes->post('savePassword', 'Account::savePassword', ['as' => 'savePassword']);
});


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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
