<?php
namespace App\Models;
use \CodeIgniter\Model;

class RoomsModel extends Model 
{
    protected $table = 'rooms';
    protected $primaryKey = 'roomid';
    protected $allowedFields = [
        'roomcode', 'room', 'roomisdel',
    ];
    protected $returnType = 'array';
    
}