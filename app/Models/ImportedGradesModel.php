<?php
namespace App\Models;
use \CodeIgniter\Model;

class ImportedGradesModel extends Model 
{
    protected $table = 'importedgrades';
    protected $primaryKey = 'impgradeid';
    protected $allowedFields = [
        'studentno', 'fname', 'lname', 'course', 'courseid',
        'yearlevel', 'subjectid', 'scheduleid', 'subjectcode', 'subjectdescription',
        'nounits', 'nohours', 'prelim', 'midterm', 'final',
        'semestral', 'teacherid', 'teachername', 'sy', 'sem',
    ];
    protected $returnType = 'array';
    
}