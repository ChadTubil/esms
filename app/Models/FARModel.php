<?php
namespace App\Models;
use \CodeIgniter\Model;

class FARModel extends Model 
{
    protected $table = 'far';
    protected $primaryKey = 'farid';
    protected $allowedFields = [
        'farevaluator', 'faraccountid', 'farname', 'farsubject', 'fardepartment',
        'farcourse', 'farsy', 'farsem', 'farq1', 'farq2',
        'farq3', 'farq4', 'farq5', 'farq6', 'farq7',
        'farq8', 'farq9', 'farq10', 'farq11', 'farq12',
        'farq13', 'farq14', 'farq15', 'farq16', 'farq17',
        'farq18', 'farq19', 'farq20', 'farq21', 'farq22',
        'farq23', 'farq24', 'farq25', 'farq26', 'farq27',
        'farq28', 'farq29', 'farq30', 'farq31', 'farq32',
        'farq33', 'farq34', 'farq35', 'farq36', 'farq37',
        'farq38', 'farq39', 'farq40', 'farq41', 'farq42', 'farqtotal',
        'farcomment', 'farstatus',
    ];
    protected $returnType = 'array';
    
}