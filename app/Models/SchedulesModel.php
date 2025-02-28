<?php
namespace App\Models;
use \CodeIgniter\Model;

class SchedulesModel extends Model 
{
    protected $table = 'schedule';
    protected $primaryKey = 'schedid';
    protected $allowedFields = [
        'schedcourid', 'schedsubid', 'schedsecid', 'schedday',
        'schedroom', 'schedteacher', 'schedtimeF',
        'schedtimeT', 'schedmaxstudent', 'schedstudcount',
        'schedday2', 'schedtimeF2', 'schedtimeT2',
        'schedstatus', 'schedisdel',
    ];
    protected $returnType = 'array';
    
}