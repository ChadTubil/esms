<?php
namespace App\Models;
use \CodeIgniter\Model;

class BooksModel extends Model 
{
    protected $table = 'books';
    protected $primaryKey = 'bookid';
    protected $allowedFields = [
        'name', 'price', 'level', 'cluster', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}