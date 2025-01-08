<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Create a new book
// $routes->post('books/create', 'BooksController::create');
$routes->match(['get', 'post'], 'books/update/(:any)', 'BooksController::update/$1'); // Update a book
$routes->get('/', 'BooksController::index');
$routes->get('books', 'BooksController::index'); // List all books
$routes->post('books/create', 'BooksController::create');
$routes->delete('books/delete/(:any)', 'BooksController::delete/$1'); // Use DELETE for deleting a book
$routes->get('books/toggleAvailability/(:any)', 'BooksController::toggleAvailability/$1'); // Toggle availability
$routes->get('books/show/(:any)', 'BooksController::show/$1');  // Show a specific book by ID
$routes->get('books/show', 'BooksController::show');  // Show all books