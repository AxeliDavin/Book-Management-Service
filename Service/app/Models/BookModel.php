<?php
namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table      = 'books';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'title', 'author', 'genre', 'isbn', 'published_date', 'availability_status'];

    // Automatically manage created_at and updated_at fields
    protected $useTimestamps = true;

    // Validation rules (optional)
    // protected $validationRules = [
    //     'title'             => 'required|min_length[3]',
    //     'author'            => 'required|min_length[3]',
    //     'genre'             => 'required|min_length[3]',
    //     'isbn'              => 'required|is_unique[books.isbn]',
    //     'published_date'    => 'required|valid_date',
    //     'availability_status' => 'required|in_list[Available,Borrowed]',
    // ];

    // Ensure a UUID is generated if not provided
    protected $useAutoIncrement = false;
}
