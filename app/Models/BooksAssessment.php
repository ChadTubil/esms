<?php
namespace App\Models;
use \CodeIgniter\Model;

class BooksAssessment extends Model 
{
    protected $table = 'booksassessment';
    protected $primaryKey = 'baid';
    protected $allowedFields = [
        'studno', 'bookid', 'price', 'ornumber', 'transactionno', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}