<?php
namespace App\Models;
use \CodeIgniter\Model;

class IBEDFamilyBackgroundModel extends Model 
{
    protected $table = 'familybackground_ibed';
    protected $primaryKey = 'fbid';
    protected $allowedFields = [
        'studid', 'nfather', 'fmobile', 'fwork', 'femail',
        'foffice', 'nmother', 'mmobile', 'mwork', 'memail',
        'moffice', 'mstatus', 'misdel',
    ];
    protected $returnType = 'array';
    
}