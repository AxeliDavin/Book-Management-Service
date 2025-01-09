<?php
namespace Config;

$routes->get('/', 'AuthController::index');  // Show login page
$routes->get('login', 'AuthController::index');  // Show login page
$routes->post('login', 'AuthController::login'); // Handle login form submission
$routes->post('/logout', 'AuthController::logout');

// Apply the AuthFilter to protected routes
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('books', 'BooksController::index');
    $routes->post('books/create', 'BooksController::create');
    $routes->get('books/update/(:any)', 'BooksController::update/$1');
    $routes->post('books/update/(:any)', 'BooksController::update/$1');
    $routes->delete('books/delete/(:any)', 'BooksController::delete/$1');
    $routes->get('books/toggleAvailability/(:any)', 'BooksController::toggleAvailability/$1'); // Toggle availability
    $routes->get('books/show/(:any)', 'BooksController::show/$1');
    $routes->get('books/show', 'BooksController::show');
});
