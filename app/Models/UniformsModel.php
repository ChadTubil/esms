<?php
namespace App\Models;
use \CodeIgniter\Model;

class UniformsModel extends Model 
{
    protected $table = 'uniforms';
    protected $primaryKey = 'uniformid';
    protected $allowedFields = [
        'name', 'size', 'price', 'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}