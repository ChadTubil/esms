<?php
namespace App\Models;
use \CodeIgniter\Model;

class ClustersModel extends Model 
{
    protected $table = 'clusters';
    protected $primaryKey = 'cluid';
    protected $allowedFields = [
        'code', 'cluster', 'isdel',
    ];
    protected $returnType = 'array';
    
}