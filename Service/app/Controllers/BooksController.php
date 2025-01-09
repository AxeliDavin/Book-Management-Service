<?php
namespace App\Controllers;

use App\Models\BookModel;
use CodeIgniter\RESTful\ResourceController;

class BooksController extends ResourceController
{
    protected $modelName = 'App\Models\BookModel';
    protected $format    = 'json';

    public function __construct()
    {
        helper('auth');
    }

    // List all books
    public function index()
    {
        $model = new BookModel();
        $data['books'] = $model->findAll();
        
        // Returning a JSON response (you don't need to return a view)
        return $this->respond($data['books']);
    }

    // Create a new book
    public function create()
    {    
        $available = $this->request->getPost('availability_status');
        
        $data = [
            'id'               => uniqid(),
            'title'            => $this->request->getPost('title'),
            'author'           => $this->request->getPost('author'),
            'genre'            => $this->request->getPost('genre'),
            'isbn'             => $this->request->getPost('isbn'),
            'published_date'   => $this->request->getPost('published_date'),
            'availability_status'=> $available,
        ];
    
        $model = new BookModel();
    
        if ($model->insert($data)) {
            // Redirect to books page after successful insertion, no view rendering
            return redirect()->to(getenv('APP_URL') . '/books')->with('success', 'Book added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add book');
        }
    }

    // Update a book's information
    public function update($id = null)
    {
        $model = new BookModel();
        $book = $model->find($id);
    
        if (!$book) {
            return $this->failNotFound('Book not found');
        }

        if ($this->request->getMethod() === 'post' || $this->request->getMethod() === 'put') {
            $data = [
                'title'    => $this->request->getPost('title'),
                'author'   => $this->request->getPost('author'),
                'genre'    => $this->request->getPost('genre'),
                'isbn'     => $this->request->getPost('isbn'),
                'published_date' => $this->request->getPost('published_date'),
                'availability_status' => $this->request->getPost('availability_status'),
            ];
    
            if (!$model->update($id, $data)) {  
                return $this->fail('Update failed');
            }
    
            // Redirect to books page after successful update
            return redirect()->to(getenv('APP_URL') . '/books')->with('success', 'Book updated successfully!');
        }
    
        return $this->respond($book); // Just return JSON data
    }

    // Delete a book
    public function delete($id = null)
    {
        $model = new BookModel();
    
        if (!$model->find($id)) {
            return $this->failNotFound('Book not found');
        }
    
        if ($model->delete($id)) {
            return redirect()->to(getenv('APP_URL') . '/books')->with('success', 'Book deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to delete book.');
        }
    }

    // Show a single book
    public function show($id = null)
    {
        $model = new BookModel();
    
        if ($id === null) {
            // Return all books in JSON format
            $books = $model->findAll();
            return $this->respond($books);
        }
    
        $book = $model->find($id);
    
        if (!$book) {
            return $this->failNotFound('Book not found');
        }
    
        return $this->respond($book);
    }
}
