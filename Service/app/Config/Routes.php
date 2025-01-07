<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// List all books
$routes->get('/', 'BooksController::index');
$routes->get('books', 'BooksController::index');

// Create a new book
$routes->post('books/create', 'BooksController::create');

// Show details of a specific book
$routes->get('books/show/(:any)', 'BooksController::show/$1');

// Update a specific book
$routes->match(['get', 'post'], 'books/update/(:any)', 'BooksController::update/$1');

// Delete a specific book
$routes->delete('books/(:any)', 'BooksController::delete/$1');


// Toggle availability status of a book
$routes->get('books/toggleAvailability/(:any)', 'BooksController::toggleAvailability/$1');
