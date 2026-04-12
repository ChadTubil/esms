<?php
namespace App\Models;
use \CodeIgniter\Model;

class AdditionalInfoIBEDModel extends Model 
{
    protected $table = 'additionalinfo_ibed';
    protected $primaryKey = 'aiid';
    protected $allowedFields = [
        'stuid','fdateofbirth', 'fplaceofbirth', 'faddress', 'feduc', 'flanguage',
        'mdateofbirth', 'mplaceofbirth', 'maddress', 'meducation', 'mlanguage',
        'pstatus', 'nameg', 'contactg', 'gaddress', 'contactperson', 'personcontactno',
        'siblingname', 'siblingwork', 'siblingage', 'interest',
        'talents', 'hobbies', 'goals', 'characteristics', 'fears',
        'disabilities', 'chronic_illnesses', 'medicine', 'vitamins', 'recent_accidents',
        'experience_accidents', 'recent_surgical', 'experience_surgical', 'vaccines', 'con_psy', 'con_psy_date',
        'con_psy_sessions', 'con_psy_diagnosis', 'con_regpsy', 'con_regpsy_date', 'con_regpsy_sessions',
        'con_regpsy_diagnosis', 'con_regguid', 'con_regguid_date', 'con_regguid_sessions', 'con_regguid_diagnosis',
        'aisdel',
    ];
    protected $returnType = 'array';
    
}   