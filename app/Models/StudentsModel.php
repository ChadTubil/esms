<?php
namespace App\Models;
use \CodeIgniter\Model;

class StudentsModel extends Model 
{
    protected $table = 'students';
    protected $primaryKey = 'studid';
    protected $allowedFields = [
        'studentno', 'studln', 'studfn', 'studmn', 'studextension',
        'studfullname', 'studbirthday', 'studage', 'studgender', 'studstbarangay',
        'studcity', 'studprovince', 'studcontact', 'studcitizenship', 'studreligion',
        'studemail', 'studbirthplace', 'studimage', 'studssrid', 'studsfbid',
        'studsprid', 'studcreatedat', 'studstatus', 'studisdel',
    ];
    protected $returnType = 'array';
    
}