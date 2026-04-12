<?php
namespace App\Models;
use \CodeIgniter\Model;

class IBEDStudentsModel extends Model 
{
    protected $table = 'students_ibed';
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