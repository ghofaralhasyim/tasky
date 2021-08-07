<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
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
$routes->get('/project','Usr::project',['filter' => 'auth']);
$routes->get('/task-list/(:any)','Usr::task_list/$1',['filter' => 'auth']);
$routes->get('/task-details/(:any)/(:any)','Usr::task_details/$1/$2',['filter' => 'auth']);
$routes->add('/join-team','Usr::join_page',['filter' => 'auth']);
$routes->get('/request/(:any)','Usr::request_project/$1',['filter' => 'auth']);
$routes->get('/cancel-join/(:any)','Usr::cancel_request/$1',['filter' => 'auth']);

$routes->get('/team/(:any)','Usr::team/$1',['filter' => 'auth']);
$routes->get('/acc-request/(:any)/(:any)/(:any)','Usr::accept_request/$1/$2/$3',['filter' => 'auth']);
$routes->get('/reject-request/(:any)/(:any)','Usr::reject_request/$1/$2',['filter' => 'auth']);
$routes->get('/delete-team/(:any)/(:any)','Usr::delete_team/$1/$2',['filter' => 'auth']);
$routes->get('/role/(:any)/(:any)/(:any)','Usr::update_role/$1/$2/$3',['filter' => 'auth']);

$routes->add('/new-project','Usr::new_project',['filter' => 'auth']);
$routes->get('/dev-info','Usr::dev_info',['filter' => 'auth']);
$routes->add('/new-task/(:any)','Usr::new_task/$1',['filter' => 'auth']);
$routes->add('/update-task','Usr::update_task',['filter' => 'auth']);
$routes->post('/upload-file','Usr::file_upload',['filter' => 'auth']);
$routes->get('/download/(:any)/(:any)','Usr::download_file/$1/$2',['filter' => 'auth']);
$routes->get('/delete-file/(:any)/(:any)/(:any)','Usr::delete_file/$1/$2/$3',['filter' => 'auth']);
$routes->get('/delete-task/(:any)/(:any)','Usr::delete_task/$1/$2',['filter' => 'auth']);
$routes->get('/dasboard/(:any)','Usr::dasboard/$1',['filter' => 'auth']);
$routes->get('/delete-project/(:any)','Usr::delete_project/$1',['filter' => 'auth']);
$routes->add('/steplane-profile/(:any)','Usr::profile/$1',['filter' => 'auth']);
$routes->add('/edit-project/(:any)','Usr::update_project/$1',['filter' => 'auth']);
$routes->post('/post','Usr::add_post',['filter' => 'auth']);

$routes->get('/reset-password','Usr::mail_reset_password',['filter' => 'auth']);
$routes->post('/update-email','Usr::mail_new_email',['filter' => 'auth']);
$routes->add('/update-email/form','Usr::update_email',['filter' => 'auth']);
$routes->add('/email-verification','Usr::email_verify',['filter' => 'auth']);
$routes->add('/reset-password/new-password','Usr::reset_password',['filter' => 'auth']);
$routes->add('/edit-profile','Usr::update_profile',['filter' => 'auth']);

$routes->get('/', 'Pub::index');
$routes->add('/sign-in','Pub::login');
$routes->add('/sign-up','Pub::register');
$routes->get('/sign-out','Pub::logout');
$routes->get('/home','Pub::index');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
