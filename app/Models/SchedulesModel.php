<?php
namespace App\Models;
use \CodeIgniter\Model;

class SchedulesModel extends Model 
{
    protected $table = 'schedule';
    protected $primaryKey = 'schedid';
    protected $allowedFields = [
        'schedcourid', 'schedsubid', 'schedsecid', 'schedday',
        'schedroom', 'schedroom2', 'schedroom3', 'schedteacher', 'schedtimeF',
        'schedtimeT', 'schedmaxstudent', 'schedstudcount',
        'schedday2', 'schedtimeF2', 'schedtimeT2',
        'schedstatus', 'schedisdel',
    ];
    protected $returnType = 'array';
    
}