<?php
namespace App\Models;
use \CodeIgniter\Model;

class RatesModel extends Model 
{
    protected $table = 'rates';
    protected $primaryKey = 'rateid';
    protected $allowedFields = [
        'sy', 'sem', 'course', 'year', 'major', 'minor',
        'nstp01', 'nstp02', 'registrationfee', 'library',
        'laboratory', 'athletics', 'medical', 'guidance', 'schoolorgan',
        'id', 'av', 'prisaa', 'internetfee', 'studenthb',
        'insurance', 'rso', 'cultural', 'studentcouncil', 'learningsystem',
        'due1', 'due2', 'due3', 'due4',
        'status', 'isdel',
    ];
    protected $returnType = 'array';
    
}