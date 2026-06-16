<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\EnrollmentTempDataModel;
use App\Models\StudentAccountsModel;
use App\Models\SYModel;
use App\Models\SemesterModel;
use App\Models\COLAssessmentModel;
use App\Models\COLStudentsModel;
class DashboardController extends BaseController
{
    public $usersModel;
    public $etdModel;
    public $syModel;
    public $semesterModel;
    public $studentAssessmentModel;
    public $colAssessmentModel;
    public $colStudentsModel;

    public $session;
    public function __construct() {
        $this->usersModel = new UsersModel();
        $this->etdModel = new EnrollmentTempDataModel();
        $this->studentAssessmentModel = new StudentAccountsModel();
        $this->semesterModel = new SemesterModel();
        $this->colAssessmentModel = new COLAssessmentModel();
        $this->colStudentsModel = new COLStudentsModel();

        $this->syModel = new SYModel();
        helper('form');
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Dashboard',
            'page_heading' => 'Hello! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $selectedSY = $this->syModel->where('systatus', 0)->where('syisdel', 0)->findAll();
        foreach($selectedSY as $sy) {
            $selectedSY = $sy['syname']; // Assign the current SY to $selectedSY
        }
        $selectedSEM = $this->semesterModel->where('semstatus', 0)->where('semisdel', 0)->findAll();
        foreach($selectedSEM as $sem) {
            $selectedSEM = $sem['semester']; // Assign the current SEM to $selectedSEM
        }

        $data['etdnewstudent'] = $this->etdModel->where('isdel', '0')->where('level', '1st Year')->countAllResults(); //COUNT NEW STUDENTS
        $data['etdoldstudent'] = $this->etdModel->where('isdel', '0')->where('level !=', '1st Year')->where('level !=', '')->countAllResults(); //COUNT OLD STUDENTS
        $data['etdregisteredstudent'] = $this->etdModel
            ->where('isdel', '0')
            ->where('status', 'Registered')
            ->orWhere('status', 'Admitted')
            ->countAllResults(); //COUNT REGISTERED STUDENTS
        $data['etdadmittedstudent'] = $this->etdModel->where('isdel', '0')->where('status', 'Admitted')->countAllResults(); //COUNT ADMITTED STUDENTS

        //BSIT
        $data['bsit1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_col.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();
        
        $data['bsit2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_col.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsit3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_col.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsit4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['BSITTOTAL'] = $data['bsit1st'] + $data['bsit2nd'] + $data['bsit3rd'] + $data['bsit4th']; //TOTAL BSIT STUDENTS

        //BSCS
        $data['bscs1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSCS')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();

        $data['bscs2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSCS')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();

        $data['bscs3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSCS')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();

        $data['bscs4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSCS')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();

        $data['BSCSTOTAL'] = $data['bscs1st'] + $data['bscs2nd'] + $data['bscs3rd'] + $data['bscs4th']; //TOTAL BSCS STUDENTS

        //BSCPE
        $data['bscpe1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSCpE')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();

        $data['bscpe2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSCpE')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();

        $data['bscpe3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSCpE')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();

        $data['bscpe4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSCpE')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();

        $data['BSCPETOTAL'] = $data['bscpe1st'] + $data['bscpe2nd'] + $data['bscpe3rd'] + $data['bscpe4th']; //TOTAL BSCPE STUDENTS

        //BSCE
        $data['bsce1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSCE')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();

        $data['bsce2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSCE')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();

        $data['bsce3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSCE')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();

        $data['bsce4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSCE')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();

        $data['BSCETOTAL'] = $data['bsce1st'] + $data['bsce2nd'] + $data['bsce3rd'] + $data['bsce4th']; //TOTAL BSCE STUDENTS

        //ACTNET
        $data['actnet1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'ACT-NETWORKING')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['actnet2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'ACT-NETWORKING')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['actnet3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'ACT-NETWORKING')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['actnet4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'ACT-NETWORKING')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['ACTNETTOTAL'] = $data['actnet1st'] + $data['actnet2nd'] + $data['actnet3rd'] + $data['actnet4th']; //TOTAL ACTNET STUDENTS

        //ACTDEV
        $data['actdev1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'ACT -APP DEV')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['actdev2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'ACT -APP DEV')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['actdev3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'ACT -APP DEV')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['actdev4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'ACT -APP DEV')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['ACTDEVTOTAL'] = $data['actdev1st'] + $data['actdev2nd'] + $data['actdev3rd'] + $data['actdev4th']; //TOTAL ACTDEV STUDENTS

        //TOTAL SCITE

        $data['total1stsc'] = $data['bsit1st'] + $data['bscs1st'] + $data['bscpe1st'] + $data['bsce1st'] + $data['actnet1st'] + $data['actdev1st']; //TOTAL 1ST YEAR STUDENTS
        $data['total2ndsc'] = $data['bsit2nd'] + $data['bscs2nd'] + $data['bscpe2nd'] + $data['bsce2nd'] + $data['actnet2nd'] + $data['actdev2nd']; //TOTAL 2ND YEAR STUDENTS
        $data['total3rdsc'] = $data['bsit3rd'] + $data['bscs3rd'] + $data['bscpe3rd'] + $data['bsce3rd'] + $data['actnet3rd'] + $data['actdev3rd']; //TOTAL 3RD YEAR STUDENTS
        $data['total4thsc'] = $data['bsit4th'] + $data['bscs4th'] + $data['bscpe4th'] + $data['bsce4th'] + $data['actnet4th'] + $data['actdev4th']; //TOTAL 4TH YEAR STUDENTS
        $data['TOTALSCITE'] = $data['total1stsc'] + $data['total2ndsc'] + $data['total3rdsc'] + $data['total4thsc']; //TOTAL SCITE STUDENTS

        //BSCRIM
        $data['bscrim1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSCrim')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bscrim2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSCrim')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bscrim3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSCrim')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bscrim4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSCrim')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['BSCRIMTOTAL'] = $data['bscrim1st'] + $data['bscrim2nd'] + $data['bscrim3rd'] + $data['bscrim4th']; //TOTAL BSCRIM STUDENTS

        //TOTAL SCJ

        $data['total1stcrim'] = $data['bscrim1st']; //TOTAL 1ST YEAR STUDENTS
        $data['total2ndcrim'] = $data['bscrim2nd']; //TOTAL 2ND YEAR STUDENTS
        $data['total3rdcrim'] = $data['bscrim3rd']; //TOTAL 3RD YEAR STUDENTS
        $data['total4thcrim'] = $data['bscrim4th']; //TOTAL 4TH YEAR STUDENTS
        $data['TOTALSCJ'] = $data['total1stcrim'] + $data['total2ndcrim'] + $data['total3rdcrim'] + $data['total4thcrim']; //TOTAL BSCRIM STUDENTS

        //BEED
        $data['beed1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BEEd')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['beed2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BEEd')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['beed3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BEEd')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['beed4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BEEd')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['BEEDTOTAL'] = $data['beed1st'] + $data['beed2nd'] + $data['beed3rd'] + $data['beed4th']; //TOTAL BEED STUDENTS

        //BSED - ENG
        $data['bseng1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSEd-ENGLISH')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bseng2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSEd-ENGLISH')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bseng3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSEd-ENGLISH')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bseng4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSEd-ENGLISH')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['BSEDENGTOTAL'] = $data['bseng1st'] + $data['bseng2nd'] + $data['bseng3rd'] + $data['bseng4th']; //TOTAL BSED - ENG STUDENTS

        //BSED - FIL
        $data['bsfil1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSEd-FILIPINO')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsfil2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSEd-FILIPINO')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsfil3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSEd-FILIPINO')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsfil4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSEd-FILIPINO')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['BSEDFILTOTAL'] = $data['bsfil1st'] + $data['bsfil2nd'] + $data['bsfil3rd'] + $data['bsfil4th']; //TOTAL BSED - FIL STUDENTS

        //BSED - MATH
        $data['bsmath1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSEd-MATHEMATICS')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsmath2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSEd-MATHEMATICS')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsmath3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSEd-MATHEMATICS')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsmath4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSEd-MATHEMATICS')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['BSEDMATHTOTAL'] = $data['bsmath1st'] + $data['bsmath2nd'] + $data['bsmath3rd'] + $data['bsmath4th']; //TOTAL BSED - MATH STUDENTS

        //BSED - SCIENCE
        $data['bssci1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSEd-SCIENCE')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bssci2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSEd-SCIENCE')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bssci3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSEd-SCIENCE')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bssci4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSEd-SCIENCE')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['BSEDSCITOTAL'] = $data['bssci1st'] + $data['bssci2nd'] + $data['bssci3rd'] + $data['bssci4th']; //TOTAL BSED - SCIENCE STUDENTS

        //BSED - PSYCH
        $data['bspsy1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSPsych')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();

        $data['bspsy2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSPsych')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();

        $data['bspsy3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSPsych')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();

        $data['bspsy4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSPsych')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();

        $data['BSEDPsychtOTAL'] = $data['bspsy1st'] + $data['bspsy2nd'] + $data['bspsy3rd'] + $data['bspsy4th']; //TOTAL BSED - PSYCH STUDENTS

        //BSED - METHODS
        $data['bsmet1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'METHODS')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsmet2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'METHODS')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsmet3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'METHODS')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsmet4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'METHODS')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['BSEDMETHODSTOTAL'] = $data['bsmet1st'] + $data['bsmet2nd'] + $data['bsmet3rd'] + $data['bsmet4th']; //TOTAL BSED - METHODS STUDENTS

        //TOTAL SASED

        $data['total1stsased'] = $data['beed1st'] + $data['bseng1st'] + $data['bsfil1st'] + $data['bsmath1st'] + $data['bssci1st'] + $data['bspsy1st'] + $data['bsmet1st']; //TOTAL 1ST YEAR STUDENTS
        $data['total2ndsased'] = $data['beed2nd'] + $data['bseng2nd'] + $data['bsfil2nd'] + $data['bsmath2nd'] + $data['bssci2nd'] + $data['bspsy2nd'] + $data['bsmet2nd']; //TOTAL 2ND YEAR STUDENTS
        $data['total3rdsased'] = $data['beed3rd'] + $data['bseng3rd'] + $data['bsfil3rd'] + $data['bsmath3rd'] + $data['bssci3rd'] + $data['bspsy3rd'] + $data['bsmet3rd']; //TOTAL 3RD YEAR STUDENTS
        $data['total4thsased'] = $data['beed4th'] + $data['bseng4th'] + $data['bsfil4th'] + $data['bsmath4th'] + $data['bssci4th'] + $data['bspsy4th'] + $data['bsmet4th']; //TOTAL 4TH YEAR STUDENTS
        $data['TOTALSASED'] = $data['total1stsased'] + $data['total2ndsased'] + $data['total3rdsased'] + $data['total4thsased']; //TOTAL SASED STUDENTS

        //BSA
        $data['bsa1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSA')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsa2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSA')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsa3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSA')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsa4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSA')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['BSATOTAL'] = $data['bsa1st'] + $data['bsa2nd'] + $data['bsa3rd'] + $data['bsa4th']; //TOTAL BSA STUDENTS

        //BSAIS
        $data['bsais1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSAIS')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsais2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSAIS')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsais3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSAIS')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsais4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSAIS')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        
        $data['BSAISTOTAL'] = $data['bsais1st'] + $data['bsais2nd'] + $data['bsais3rd'] + $data['bsais4th']; //TOTAL BSAIS STUDENTS

        //BSBA - MM
        $data['bsbamm1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSBA-MM')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsbamm2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSBA-MM')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsbamm3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSBA-MM')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsbamm4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSBA-MM')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['BSBAMMTOTAL'] = $data['bsbamm1st'] + $data['bsbamm2nd'] + $data['bsbamm3rd'] + $data['bsbamm4th']; //TOTAL BSBA - MM STUDENTS

        //BSBA - FM
        $data['bsbafm1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSBA-FM')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsbafm2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSBA-FM')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsbafm3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSBA-FM')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bsbafm4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSBA-FM')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['BSBAFMTOTAL'] = $data['bsbafm1st'] + $data['bsbafm2nd'] + $data['bsbafm3rd'] + $data['bsbafm4th']; //TOTAL BSBA - FM STUDENTS

        //TOTAL SBA

        $data['total1stsba'] = $data['bsa1st'] + $data['bsais1st'] + $data['bsbamm1st'] + $data['bsbafm1st']; //TOTAL 1ST YEAR STUDENTS
        $data['total2ndsba'] = $data['bsa2nd'] + $data['bsais2nd'] + $data['bsbamm2nd'] + $data['bsbafm2nd']; //TOTAL 2ND YEAR STUDENTS
        $data['total3rdsba'] = $data['bsa3rd'] + $data['bsais3rd'] + $data['bsbamm3rd'] + $data['bsbafm3rd']; //TOTAL 3RD YEAR STUDENTS
        $data['total4thsba'] = $data['bsa4th'] + $data['bsais4th'] + $data['bsbamm4th'] + $data['bsbafm4th']; //TOTAL 4TH YEAR STUDENTS
        $data['TOTALSBA'] = $data['total1stsba'] + $data['total2ndsba'] + $data['total3rdsba'] + $data['total4thsba']; //TOTAL SBA STUDENTS

        //BSHM
        $data['bshm1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSHM')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bshm2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSHM')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bshm3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSHM')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bshm4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSHM')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['BSHMTOTAL'] = $data['bshm1st'] + $data['bshm2nd'] + $data['bshm3rd'] + $data['bshm4th']; //TOTAL BSHM STUDENTS

        //BSTM
        $data['bstm1st'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bstm2nd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bstm3rd'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['bstm4th'] = $this->studentAssessmentModel
        ->select('studentsaccounts.*, paymenttransactions.*')
        ->join('paymenttransactions', 'paymenttransactions.studentno = studentsaccounts.studentno')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', $selectedSY)
        ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->countAllResults();
        $data['BSTMTOTAL'] = $data['bstm1st'] + $data['bstm2nd'] + $data['bstm3rd'] + $data['bstm4th']; //TOTAL BSTM STUDENTS

        //TOTAL STHM

        $data['total1ststhm'] = $data['bshm1st'] + $data['bstm1st']; //TOTAL 1ST YEAR STUDENTS
        $data['total2ndsthm'] = $data['bshm2nd'] + $data['bstm2nd']; //TOTAL 2ND YEAR STUDENTS
        $data['total3rdsthm'] = $data['bshm3rd'] + $data['bstm3rd']; //TOTAL 3RD YEAR STUDENTS
        $data['total4thsthm'] = $data['bshm4th'] + $data['bstm4th']; //TOTAL 4TH YEAR STUDENTS
        $data['TOTALSTHM'] = $data['total1ststhm'] + $data['total2ndsthm'] + $data['total3rdsthm'] + $data['total4thsthm']; //TOTAL STHM STUDENTS

        //KINDER 1
        $data['kinder1'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_ibed.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'KINDER 1')
        // ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //KINDER 2
        $data['kinder2'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_ibed.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'KINDER 2')
        // ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 1
        $data['grade1'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_ibed.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 1')
        // ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 2
        $data['grade2'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_ibed.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 2')
        // ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 3
        $data['grade3'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_ibed.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 3')
        // ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 4
        $data['grade4'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_ibed.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 4')
        // ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 5
        $data['grade5'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_ibed.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 5')
        // ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 6
        $data['grade6'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_ibed.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 6')
        // ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 7
        $data['grade7'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_ibed.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 7')
        // ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 8
        $data['grade8'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_ibed.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 8')
        // ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 9
        $data['grade9'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_ibed.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 9')
        // ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 10
        $data['grade10'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_ibed.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 10')
        // ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        $data['TOTALIBED'] = $data['kinder1'] + $data['kinder2'] + $data['grade1'] + $data['grade2'] + $data['grade3'] + $data['grade4'] + $data['grade5'] + $data['grade6'] + $data['grade7'] + $data['grade8'] + $data['grade9'] + $data['grade10']; //TOTAL IBED STUDENTS

        //GRADE 11 - ASSH
        $data['assh11'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_shs.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 11')
        ->where('studentsaccounts.cluster', 'ASSH')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->orWhere('paymenttransactions.paymentstatus', 'Paid')
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 11 - STEM
        $data['stem11'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_shs.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 11')
        ->where('studentsaccounts.cluster', 'STEM')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->orWhere('paymenttransactions.paymentstatus', 'Paid')
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 11 - HT
        $data['ht11'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_shs.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 11')
        ->where('studentsaccounts.cluster', 'HT')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->orWhere('paymenttransactions.paymentstatus', 'Paid')
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 11 - BE
        $data['be11'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_shs.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 11')
        ->where('studentsaccounts.cluster', 'BE')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->orWhere('paymenttransactions.paymentstatus', 'Paid')
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 11 - ICT
        $data['ict11'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_shs.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 11')
        ->where('studentsaccounts.cluster', 'ICT')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->orWhere('paymenttransactions.paymentstatus', 'Paid')
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 12 - STEM
        $data['stem12'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_shs.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 12')
        ->where('studentsaccounts.cluster', 'STEM')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->orWhere('paymenttransactions.paymentstatus', 'Paid')
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 12 - ABM
        $data['abm12'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_shs.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 12')
        ->where('studentsaccounts.cluster', 'ABM')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->orWhere('paymenttransactions.paymentstatus', 'Paid')
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 12 - HUMSS
        $data['humss12'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_shs.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 12')
        ->where('studentsaccounts.cluster', 'HUMSS')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->orWhere('paymenttransactions.paymentstatus', 'Paid')
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 12 - HE
        $data['he12'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_shs.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 12')
        ->where('studentsaccounts.cluster', 'HE')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->orWhere('paymenttransactions.paymentstatus', 'Paid')
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 12 - ICT
        $data['ict12'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        ->join('paymenttransactions', 'paymenttransactions.studfullname = students_shs.studfullname')
        ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 12')
        ->where('studentsaccounts.cluster', 'ICT')
        ->where('studentsaccounts.sy', $selectedSY)
        // ->where('studentsaccounts.sem', $selectedSEM)
        ->where('paymenttransactions.paymentstatus', 'Allocated')
        ->orWhere('paymenttransactions.paymentstatus', 'Paid')
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        $data['TOTALGR11'] = $data['assh11'] + $data['stem11'] + $data['ht11'] + $data['be11'] + $data['ict11']; //TOTAL GR 11 STUDENTS
        $data['TOTALGR12'] = $data['stem12'] + $data['abm12'] + $data['humss12'] + $data['he12'] + $data['ict12']; //TOTAL GR 12 STUDENTS

        return view('dashboardview', $data);
        //
        
    }
    public function logout() 
    {
        session()->remove('logged_user');
        session()->destroy();
        return redirect()->to(base_url());
    }
}
