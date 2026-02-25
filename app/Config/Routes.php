<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Frontend Routes
$routes->get('/', 'Home::index');
$routes->get('/collection', 'Product::index');
$routes->get('/detail/(:num)', 'Product::detail/$1');

// Auth Routes
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('/logout', 'Auth::logout');

// Cart Routes (AJAX)
$routes->post('/cart/add', 'Cart::add');
$routes->post('/cart/update', 'Cart::update');
$routes->post('/cart/remove', 'Cart::remove');
$routes->get('/cart/get', 'Cart::get');

// Admin Routes - Hanya bisa diakses oleh admin
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('dashboard', 'Admin\DashboardController::index');
    
    // Product Management
    $routes->get('products', 'Admin\ProductController::index');
    $routes->get('products/create', 'Admin\ProductController::create');
    $routes->post('products/store', 'Admin\ProductController::store');
    $routes->get('products/edit/(:num)', 'Admin\ProductController::edit/$1');
    $routes->post('products/update/(:num)', 'Admin\ProductController::update/$1');
    $routes->delete('products/delete/(:num)', 'Admin\ProductController::delete/$1');
    
    // Order Management
    $routes->get('orders', 'Admin\OrderController::index');
    $routes->get('orders/detail/(:num)', 'Admin\OrderController::detail/$1');
    $routes->post('orders/update-status/(:num)', 'Admin\OrderController::updateStatus/$1');
    
    // Customer Management
    $routes->get('customers', 'Admin\CustomerController::index');
});

// API Routes
$routes->group('api', function($routes) {
    $routes->get('products', 'Api\ProductController::index');
    $routes->get('products/(:num)', 'Api\ProductController::show/$1');
    $routes->post('products', 'Api\ProductController::create');
    $routes->put('products/(:num)', 'Api\ProductController::update/$1');
    $routes->delete('products/(:num)', 'Api\ProductController::delete/$1');
    
    $routes->get('orders', 'Api\OrderController::index');
    $routes->get('orders/(:num)', 'Api\OrderController::show/$1');
    $routes->post('orders', 'Api\OrderController::create');
});