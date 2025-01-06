<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('books', 'BooksController::index'); // List all books
$routes->post('books/create', 'BooksController::create'); // Create new book
$routes->get('books/show/(:num)', 'BooksController::show/$1'); // Show details of a book
$routes->get('books/update/(:num)', 'BooksController::update/$1'); // Update a book
$routes->match(['get', 'post'], 'books/update/(:num)', 'BooksController::update/$1');
$routes->delete('books/(:num)', 'BooksController::delete/$1');
$routes->get('books/toggleAvailability/(:num)', 'BooksController::toggleAvailability/$1');