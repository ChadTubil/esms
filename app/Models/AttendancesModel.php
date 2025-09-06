<?php
namespace App\Models;
use \CodeIgniter\Model;

class AttendancesModel extends Model 
{
    protected $table = 'attendance';
    protected $primaryKey = 'attid';
    protected $allowedFields = [
        'employeeno', 'rfid', 'sy', 'date', 'timein', 'timeout',
        'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}