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
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/admin_login', 'Auth::admin_login', ['filter' => 'noAuth']);
$routes->get('/logout', 'Auth::logout');

$routes->get('/', 'Auth::index', ['filter' => 'noAuth']);

$routes->get('/admin', 'Admin::index', ['filter' => 'authAdmin']);
$routes->get('/index', 'Admin::index', ['filter' => 'authAdmin']);
$routes->get('/teacher', 'Teacher::index', ['filter' => 'authAdmin']);
$routes->get('/student', 'Student::index', ['filter' => 'authAdmin']);
$routes->get('/attendance', 'Attendance::index', ['filter' => 'authAdmin']);
$routes->get('/analytics', 'Attendance::analytics', ['filter' => 'authAdmin']);

$routes->get('/dashboard', 'TeacherUser::index', ['filter' => 'auth']);
$routes->get('/teacher_profile', 'TeacherUser::profile', ['filter' => 'auth']);
$routes->get('/teacher_attendance', 'TeacherUser::teacher_attendance', ['filter' => 'auth']);


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
