<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\EnrollmentTempDataModel;
use App\Models\StudentAccountsModel;
use App\Models\SYModel;
use App\Models\SemesterModel;
use App\Models\COLAssessmentModel;
use App\Models\COLStudentsModel;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DashboardController extends BaseController
{
    public $usersModel;
    public $etdModel;
    public $syModel;
    public $semesterModel;
    public $studentAssessmentModel;
    public $colAssessmentModel;
    public $colStudentsModel;
    public $studentsAccountModel;

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

        $data['etdnewstudent'] = $this->studentAssessmentModel->where('isdel', '0')->where('level', '1st Year')->countAllResults(); //COUNT NEW STUDENTS
        $data['etdoldstudent'] = $this->studentAssessmentModel->where('isdel', '0')->where('level !=', '1st Year')->where('level !=', '')->countAllResults(); //COUNT OLD STUDENTS
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
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();
        
        $data['bsit2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsit3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsit4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSITTOTAL'] = $data['bsit1st'] + $data['bsit2nd'] + $data['bsit3rd'] + $data['bsit4th']; //TOTAL BSIT STUDENTS

        //BSCS
        $data['bscs1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSCS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscs2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSCS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscs3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSCS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscs4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSCS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSCSTOTAL'] = $data['bscs1st'] + $data['bscs2nd'] + $data['bscs3rd'] + $data['bscs4th']; //TOTAL BSCS STUDENTS

        //BSCPE
        $data['bscpe1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSCpE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscpe2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSCpE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscpe3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSCpE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscpe4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSCpE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSCPETOTAL'] = $data['bscpe1st'] + $data['bscpe2nd'] + $data['bscpe3rd'] + $data['bscpe4th']; //TOTAL BSCPE STUDENTS

        //BSCE
        $data['bsce1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSCE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsce2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSCE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsce3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSCE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsce4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSCE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSCETOTAL'] = $data['bsce1st'] + $data['bsce2nd'] + $data['bsce3rd'] + $data['bsce4th']; //TOTAL BSCE STUDENTS

        //ACTDEV
        $data['actdev1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'ACT -APP DEV')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['actdev2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'ACT -APP DEV')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
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

        $data['total1stsc'] = $data['bsit1st'] + $data['bscs1st'] + $data['bscpe1st'] + $data['bsce1st'] + $data['actdev1st']; //TOTAL 1ST YEAR STUDENTS
        $data['total2ndsc'] = $data['bsit2nd'] + $data['bscs2nd'] + $data['bscpe2nd'] + $data['bsce2nd'] + $data['actdev2nd']; //TOTAL 2ND YEAR STUDENTS
        $data['total3rdsc'] = $data['bsit3rd'] + $data['bscs3rd'] + $data['bscpe3rd'] + $data['bsce3rd'] + $data['actdev3rd']; //TOTAL 3RD YEAR STUDENTS
        $data['total4thsc'] = $data['bsit4th'] + $data['bscs4th'] + $data['bscpe4th'] + $data['bsce4th'] + $data['actdev4th']; //TOTAL 4TH YEAR STUDENTS
        $data['TOTALSCITE'] = $data['total1stsc'] + $data['total2ndsc'] + $data['total3rdsc'] + $data['total4thsc']; //TOTAL SCITE STUDENTS

        //BSCRIM
        $data['bscrim1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSCrim')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscrim2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSCrim')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscrim3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSCrim')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscrim4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSCrim')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
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
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BEEd')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['beed2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BEEd')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['beed3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BEEd')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['beed4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BEEd')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BEEDTOTAL'] = $data['beed1st'] + $data['beed2nd'] + $data['beed3rd'] + $data['beed4th']; //TOTAL BEED STUDENTS

        //BSED - ENG
        $data['bseng1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSEd-ENGLISH')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bseng2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSEd-ENGLISH')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bseng3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSEd-ENGLISH')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bseng4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSEd-ENGLISH')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSEDENGTOTAL'] = $data['bseng1st'] + $data['bseng2nd'] + $data['bseng3rd'] + $data['bseng4th']; //TOTAL BSED - ENG STUDENTS

        //BSED - FIL
        $data['bsfil1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSEd-FILIPINO')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsfil2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSEd-FILIPINO')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsfil3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSEd-FILIPINO')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsfil4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSEd-FILIPINO')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSEDFILTOTAL'] = $data['bsfil1st'] + $data['bsfil2nd'] + $data['bsfil3rd'] + $data['bsfil4th']; //TOTAL BSED - FIL STUDENTS

        //BSED - MATH
        $data['bsmath1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSEd-MATHEMATICS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsmath2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSEd-MATHEMATICS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsmath3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSEd-MATHEMATICS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsmath4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSEd-MATHEMATICS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSEDMATHTOTAL'] = $data['bsmath1st'] + $data['bsmath2nd'] + $data['bsmath3rd'] + $data['bsmath4th']; //TOTAL BSED - MATH STUDENTS

        //BSED - SCIENCE
        $data['bssci1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSEd-SCIENCE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bssci2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSEd-SCIENCE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bssci3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSEd-SCIENCE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bssci4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSEd-SCIENCE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSEDSCITOTAL'] = $data['bssci1st'] + $data['bssci2nd'] + $data['bssci3rd'] + $data['bssci4th']; //TOTAL BSED - SCIENCE STUDENTS

        //BSED - PSYCH
        $data['bspsy1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSPsych')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bspsy2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSPsych')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bspsy3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSPsych')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bspsy4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSPsych')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSEDPsychtOTAL'] = $data['bspsy1st'] + $data['bspsy2nd'] + $data['bspsy3rd'] + $data['bspsy4th']; //TOTAL BSED - PSYCH STUDENTS

        //BSED - METHODS
        $data['bsmet1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'METHODS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsmet2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'METHODS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsmet3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'METHODS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsmet4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'METHODS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
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
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSA')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsa2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSA')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsa3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSA')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsa4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSA')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSATOTAL'] = $data['bsa1st'] + $data['bsa2nd'] + $data['bsa3rd'] + $data['bsa4th']; //TOTAL BSA STUDENTS

        //BSAIS
        $data['bsais1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSAIS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsais2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSAIS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsais3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSAIS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsais4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSAIS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();
        
        $data['BSAISTOTAL'] = $data['bsais1st'] + $data['bsais2nd'] + $data['bsais3rd'] + $data['bsais4th']; //TOTAL BSAIS STUDENTS

        //BSBA - MM
        $data['bsbamm1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSBA-MM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsbamm2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSBA-MM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsbamm3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSBA-MM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults(); 

        $data['bsbamm4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSBA-MM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSBAMMTOTAL'] = $data['bsbamm1st'] + $data['bsbamm2nd'] + $data['bsbamm3rd'] + $data['bsbamm4th']; //TOTAL BSBA - MM STUDENTS

        //BSBA - FM
        $data['bsbafm1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSBA-FM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsbafm2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSBA-FM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsbafm3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSBA-FM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsbafm4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSBA-FM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
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
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSHM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bshm2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSHM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bshm3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSHM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bshm4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSHM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSHMTOTAL'] = $data['bshm1st'] + $data['bshm2nd'] + $data['bshm3rd'] + $data['bshm4th']; //TOTAL BSHM STUDENTS

        //BSTM
        $data['bstm1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bstm2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bstm3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bstm4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
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
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'KINDER 1')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //KINDER 2
        $data['kinder2'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'KINDER 2')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 1
        $data['grade1'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 1')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 2
        $data['grade2'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 2')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 3
        $data['grade3'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 3')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 4
        $data['grade4'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 4')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 5
        $data['grade5'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 5')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 6
        $data['grade6'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 6')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 7
        $data['grade7'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 7')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 8
        $data['grade8'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 8')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 9
        $data['grade9'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 9')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 10
        $data['grade10'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 10')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        $data['TOTALIBED'] = $data['kinder1'] + $data['kinder2'] + $data['grade1'] + $data['grade2'] + $data['grade3'] + $data['grade4'] + $data['grade5'] + $data['grade6'] + $data['grade7'] + $data['grade8'] + $data['grade9'] + $data['grade10']; //TOTAL IBED STUDENTS

        //GRADE 11 - ASSH
        $data['assh11'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 11')
        ->where('studentsaccounts.cluster', 'ASSH')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 11 - STEM
        $data['stem11'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 11')
        ->where('studentsaccounts.cluster', 'STEM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 11 - HT
        $data['ht11'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 11')
        ->where('studentsaccounts.cluster', 'HT')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 11 - BE
        $data['be11'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 11')
        ->where('studentsaccounts.cluster', 'BE')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 11 - ICT
        $data['ict11'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 11')
        ->where('studentsaccounts.cluster', 'ICT')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 12 - STEM
        $data['stem12'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 12')
        ->where('studentsaccounts.cluster', 'STEM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 12 - ABM
        $data['abm12'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 12')
        ->where('studentsaccounts.cluster', 'ABM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 12 - HUMSS
        $data['humss12'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 12')
        ->where('studentsaccounts.cluster', 'HUMSS')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 12 - HE
        $data['he12'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 12')
        ->where('studentsaccounts.cluster', 'HE')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 12 - ICT
        $data['ict12'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 12')
        ->where('studentsaccounts.cluster', 'ICT')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
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
    public function enrollmentList() {
        $pageSize = array(216, 330);
        $pdf = new TCPDF('P', 'mm', $pageSize, true, 'UTF-8', false);
        // Load TCPDF library
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetCreator('Holy Cross College');
        $pdf->SetAuthor('TRS Department');
        $pdf->SetTitle('Enrollment List');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(5,40,5,0);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->AddPage();

        $imagePath = FCPATH .'public/uploads/hccheader3.png';
        $pdf->Image($imagePath, $x = 5, $y = 0, $w = 201, $h = 36); 
        $pdf->Line(5, 37, 206, 37);

        // $shsStudents = $this->shsStudentsModel->where('studentno', $id)->findAll();
        // $ibedStudents = $this->ibedStudentsModel->where('studentno', $id)->findAll();
        // $studentdata = array_merge($shsStudents, $ibedStudents);
        // foreach($studentdata as $sd) {
        //     $STUDFULLNAME = $sd['studfullname'];
        //     $STUDNO = $sd['studentno'];
        // }
        
        //BSIT
        $data['bsit1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();
        
        $data['bsit2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsit3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsit4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSIT')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSITTOTAL'] = $data['bsit1st'] + $data['bsit2nd'] + $data['bsit3rd'] + $data['bsit4th']; //TOTAL BSIT STUDENTS

        //BSCS
        $data['bscs1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSCS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscs2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSCS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscs3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSCS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscs4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSCS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSCSTOTAL'] = $data['bscs1st'] + $data['bscs2nd'] + $data['bscs3rd'] + $data['bscs4th']; //TOTAL BSCS STUDENTS

        //BSCPE
        $data['bscpe1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSCpE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscpe2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSCpE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscpe3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSCpE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscpe4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSCpE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSCPETOTAL'] = $data['bscpe1st'] + $data['bscpe2nd'] + $data['bscpe3rd'] + $data['bscpe4th']; //TOTAL BSCPE STUDENTS

        //BSCE
        $data['bsce1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSCE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsce2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSCE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsce3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSCE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsce4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSCE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSCETOTAL'] = $data['bsce1st'] + $data['bsce2nd'] + $data['bsce3rd'] + $data['bsce4th']; //TOTAL BSCE STUDENTS

        //ACTDEV
        $data['actdev1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'ACT -APP DEV')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['actdev2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'ACT -APP DEV')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['actdev3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'ACT -APP DEV')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['actdev4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'ACT -APP DEV')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['ACTDEVTOTAL'] = $data['actdev1st'] + $data['actdev2nd'] + $data['actdev3rd'] + $data['actdev4th']; //TOTAL ACTDEV STUDENTS

        //TOTAL SCITE

        $data['total1stsc'] = $data['bsit1st'] + $data['bscs1st'] + $data['bscpe1st'] + $data['bsce1st'] + $data['actdev1st']; //TOTAL 1ST YEAR STUDENTS
        $data['total2ndsc'] = $data['bsit2nd'] + $data['bscs2nd'] + $data['bscpe2nd'] + $data['bsce2nd'] + $data['actdev2nd']; //TOTAL 2ND YEAR STUDENTS
        $data['total3rdsc'] = $data['bsit3rd'] + $data['bscs3rd'] + $data['bscpe3rd'] + $data['bsce3rd'] + $data['actdev3rd']; //TOTAL 3RD YEAR STUDENTS
        $data['total4thsc'] = $data['bsit4th'] + $data['bscs4th'] + $data['bscpe4th'] + $data['bsce4th'] + $data['actdev4th']; //TOTAL 4TH YEAR STUDENTS
        $data['TOTALSCITE'] = $data['total1stsc'] + $data['total2ndsc'] + $data['total3rdsc'] + $data['total4thsc']; //TOTAL SCITE STUDENTS

        //BSCRIM
        $data['bscrim1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSCrim')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscrim2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSCrim')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscrim3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSCrim')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bscrim4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSCrim')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
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
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BEEd')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['beed2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BEEd')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['beed3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BEEd')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['beed4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BEEd')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BEEDTOTAL'] = $data['beed1st'] + $data['beed2nd'] + $data['beed3rd'] + $data['beed4th']; //TOTAL BEED STUDENTS

        //BSED - ENG
        $data['bseng1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSEd-ENGLISH')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bseng2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSEd-ENGLISH')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bseng3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSEd-ENGLISH')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bseng4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSEd-ENGLISH')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSEDENGTOTAL'] = $data['bseng1st'] + $data['bseng2nd'] + $data['bseng3rd'] + $data['bseng4th']; //TOTAL BSED - ENG STUDENTS

        //BSED - FIL
        $data['bsfil1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSEd-FILIPINO')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsfil2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSEd-FILIPINO')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsfil3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSEd-FILIPINO')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsfil4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSEd-FILIPINO')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSEDFILTOTAL'] = $data['bsfil1st'] + $data['bsfil2nd'] + $data['bsfil3rd'] + $data['bsfil4th']; //TOTAL BSED - FIL STUDENTS

        //BSED - SCIENCE
        $data['bsmath1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSEd-MATHEMATICS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsmath2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSEd-MATHEMATICS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsmath3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSEd-MATHEMATICS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsmath4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSEd-MATHEMATICS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSEDMATHTOTAL'] = $data['bsmath1st'] + $data['bsmath2nd'] + $data['bsmath3rd'] + $data['bsmath4th']; //TOTAL BSED - MATH STUDENTS

        //BSED - SCIENCE
        $data['bssci1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSEd-SCIENCE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bssci2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSEd-SCIENCE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bssci3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSEd-SCIENCE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bssci4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSEd-SCIENCE')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSEDSCITOTAL'] = $data['bssci1st'] + $data['bssci2nd'] + $data['bssci3rd'] + $data['bssci4th']; //TOTAL BSED - SCIENCE STUDENTS

        //BSED - PSYCH
        $data['bspsy1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSPsych')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bspsy2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSPsych')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bspsy3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSPsych')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bspsy4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSPsych')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSEDPsychtOTAL'] = $data['bspsy1st'] + $data['bspsy2nd'] + $data['bspsy3rd'] + $data['bspsy4th']; //TOTAL BSED - PSYCH STUDENTS

        //BSED - METHODS
        $data['bsmet1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'METHODS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsmet2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'METHODS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsmet3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'METHODS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsmet4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'METHODS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
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
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSA')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsa2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSA')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsa3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSA')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsa4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSA')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSATOTAL'] = $data['bsa1st'] + $data['bsa2nd'] + $data['bsa3rd'] + $data['bsa4th']; //TOTAL BSA STUDENTS

        //BSAIS
        $data['bsais1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSAIS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsais2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSAIS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsais3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSAIS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsais4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSAIS')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();
        
        $data['BSAISTOTAL'] = $data['bsais1st'] + $data['bsais2nd'] + $data['bsais3rd'] + $data['bsais4th']; //TOTAL BSAIS STUDENTS

        //BSBA - MM
        $data['bsbamm1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSBA-MM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsbamm2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSBA-MM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsbamm3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSBA-MM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults(); 

        $data['bsbamm4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSBA-MM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSBAMMTOTAL'] = $data['bsbamm1st'] + $data['bsbamm2nd'] + $data['bsbamm3rd'] + $data['bsbamm4th']; //TOTAL BSBA - MM STUDENTS

        //BSBA - FM
        $data['bsbafm1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSBA-FM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsbafm2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSBA-FM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsbafm3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSBA-FM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bsbafm4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSBA-FM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
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
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSHM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bshm2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSHM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bshm3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSHM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bshm4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSHM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['BSHMTOTAL'] = $data['bshm1st'] + $data['bshm2nd'] + $data['bshm3rd'] + $data['bshm4th']; //TOTAL BSHM STUDENTS

        //BSTM
        $data['bstm1st'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '1st Year')
        ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bstm2nd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '2nd Year')
        ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bstm3rd'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '3rd Year')
        ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
        ->countAllResults();

        $data['bstm4th'] = $this->studentAssessmentModel
        ->select('students_col.studid')
        ->join('students_col', 'students_col.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', '4th Year')
        ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_col.studid')  // Group by student ID
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
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'KINDER 1')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //KINDER 2
        $data['kinder2'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'KINDER 2')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 1
        $data['grade1'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 1')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 2
        $data['grade2'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 2')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 3
        $data['grade3'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 3')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 4
        $data['grade4'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 4')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 5
        $data['grade5'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 5')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 6
        $data['grade6'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 6')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 7
        $data['grade7'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 7')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 8
        $data['grade8'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 8')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 9
        $data['grade9'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 9')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 10
        $data['grade10'] = $this->studentAssessmentModel
        ->select('students_ibed.studid')
        ->join('students_ibed', 'students_ibed.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'GRADE 10')
        // ->where('studentsaccounts.course', 'BSTM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_ibed.studid')  // Group by student ID
        ->countAllResults();

        $data['TOTALIBED'] = $data['kinder1'] + $data['kinder2'] + $data['grade1'] + $data['grade2'] + $data['grade3'] + $data['grade4'] + $data['grade5'] + $data['grade6'] + $data['grade7'] + $data['grade8'] + $data['grade9'] + $data['grade10']; //TOTAL IBED STUDENTS

        //GRADE 11 - ASSH
        $data['assh11'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 11')
        ->where('studentsaccounts.cluster', 'ASSH')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 11 - STEM
        $data['stem11'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 11')
        ->where('studentsaccounts.cluster', 'STEM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 11 - HT
        $data['ht11'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 11')
        ->where('studentsaccounts.cluster', 'HT')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 11 - BE
        $data['be11'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 11')
        ->where('studentsaccounts.cluster', 'BE')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 11 - ICT
        $data['ict11'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 11')
        ->where('studentsaccounts.cluster', 'ICT')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 12 - STEM
        $data['stem12'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 12')
        ->where('studentsaccounts.cluster', 'STEM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 12 - ABM
        $data['abm12'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 12')
        ->where('studentsaccounts.cluster', 'ABM')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 12 - HUMSS
        $data['humss12'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 12')
        ->where('studentsaccounts.cluster', 'HUMSS')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 12 - HE
        $data['he12'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 12')
        ->where('studentsaccounts.cluster', 'HE')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        //GRADE 12 - ICT
        $data['ict12'] = $this->studentAssessmentModel
        ->select('students_shs.studid')
        ->join('students_shs', 'students_shs.studentno = studentsaccounts.studentno')
        // ->where('studentsaccounts.isdel', '0')
        ->where('studentsaccounts.level', 'Grade 12')
        ->where('studentsaccounts.cluster', 'ICT')
        ->where('studentsaccounts.sy', '2026-2027')
        // ->where('studentsaccounts.sem', '1st Semester')
        ->where('studentsaccounts.totalpayments !=', 0.00)
        ->groupBy('students_shs.studid')  // Group by student ID
        ->countAllResults();

        $data['TOTALGR11'] = $data['assh11'] + $data['stem11'] + $data['ht11'] + $data['be11'] + $data['ict11']; //TOTAL GR 11 STUDENTS
        $data['TOTALGR12'] = $data['stem12'] + $data['abm12'] + $data['humss12'] + $data['he12'] + $data['ict12']; //TOTAL GR 12 STUDENTS
        $data['TOTALSHS'] = $data['TOTALGR11'] + $data['TOTALGR12']; //TOTAL SHS STUDENTS
        $data['TOTALCOLLEGE'] = $data['TOTALSCITE'] + $data['TOTALSCJ'] + $data['TOTALSASED'] + $data['TOTALSBA'] + $data['TOTALSTHM']; //TOTAL COLLEGE STUDENTS

        $data['TOTALENROLLED'] = $data['TOTALIBED'] + $data['TOTALSHS'] + $data['TOTALCOLLEGE']; //TOTAL ENROLLED STUDENTS
        // foreach($bookassessementd as $bookassd) {
        //     // $STUDFULLNAME = $bookassd['studfullname'];
        //     // $STUDNO = $bookassd['studno'];
        //     $BOOKTITLE = $bookassd['name'];
        //     $BOOKLEVEL = $bookassd['level'];
        //     $BOOKPRICE = $bookassd['price'];
        // }

        $html = '
            <style>        
                    .evaluation {
                    border: 1px solid black;
                }
                table td{
                    font-size: 12px;
                    font-family: Verdana, Geneva, Tahoma, sans-serif;
                }
                .misctbl{
                    display: inline-block;
                }
                .wrap-title {
                word-wrap: break-word;      /* Allow words to break if needed */
                white-space: normal;        /* Allow wrapping */
                max-width: 250px;           /* Optional: set a max width */
                }
            </style>

            <table>
                <tr>
                    <td style="background-color: #b5b5b5; font-size: 16px; font-weight: bold; text-align: center;">DAILY ENROLLMENT REPORT (' . date('F j Y h:i A') . ')</td>
                </tr>
            </table><br><br>

            <table style="width: 100%; font-size: 10px; border: 1px solid black; border-collapse: collapse;">
                <tbody>
                    <tr>
                        <td style="width: 70%; text-align: left; font-weight: bold; border: 1px solid black;">DEPARTMENT</td>
                        <td style="width: 30%; text-align: left; font-weight: bold; border: 1px solid black;">TOTAL</td>
                    </tr>
                    <tr>
                        <td style="width: 70%; text-align: left; font-weight: bold; border: 1px solid black;">IBED</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">KINDER 1</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['kinder1'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">KINDER 2</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['kinder2'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 1</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['grade1'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 2</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['grade2'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 3</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['grade3'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 4</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['grade4'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 5</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['grade5'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 6</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['grade6'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 7</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['grade7'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 8</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['grade8'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold;border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 9</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['grade9'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold;border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 10</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['grade10'].'</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td style="width: 40%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="text-align: left; width: 30%; font-weight: bold; border: 1px solid black;">TOTAL:</td>
                        <td style="text-align: left; font-weight: bold; width: 30%; border: 1px solid black;">'.$data['TOTALIBED'].'</td>
                    </tr>
                </tfoot>
            </table>
            <br><br>

            <table style="width: 100%; font-size: 10px; border: 1px solid black; border-collapse: collapse;">
                <tbody>
                    <tr>
                        <td style="width: 70%; text-align: left; font-weight: bold; border: 1px solid black;">DEPARTMENT</td>
                        <td style="width: 30%; text-align: left; font-weight: bold; border: 1px solid black;">TOTAL</td>
                    </tr>
                    <tr>
                        <td style="width: 70%; text-align: left; font-weight: bold; border: 1px solid black;">SHS</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 11-ASSH</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['assh11'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 11-STEM</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['stem11'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 11-HT</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['ht11'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 11-BE</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['be11'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 11-ICT</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['ict11'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 40%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="text-align: left; width: 30%; font-weight: bold; border: 1px solid black;">TOTAL GRADE 11:</td>
                        <td style="text-align: left; font-weight: bold; width: 30%; border: 1px solid black;">'.$data['TOTALGR11'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 12-STEM</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['stem12'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 12-ABM</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['abm12'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 12-HUMSS</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['humss12'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 12-HE</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['he12'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 12-HE</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['he12'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; text-align: left; font-weight: bold;border: 1px solid black;"></td>
                        <td style="width: 60%; text-align: left; border: 1px solid black;">GRADE 12-ICT</td>
                        <td style="width: 30%; text-align: left; border: 1px solid black;">'.$data['ict12'].'</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td style="width: 40%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="text-align: left; width: 30%; font-weight: bold; border: 1px solid black;">TOTAL GRADE 12:</td>
                        <td style="text-align: left; font-weight: bold; width: 30%; border: 1px solid black;">'.$data['TOTALGR12'].'</td>
                    </tr>
                </tfoot>
            </table>
            <br><br>

            <table style="width: 100%; font-size: 10px; border: 1px solid black; border-collapse: collapse;">
                <tbody>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;">DEPARTMENT</td>
                        <td style="width: 16%; text-align: left; font-weight: bold; border: 1px solid black;">COURSE</td>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;">1st Year</td>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;">2nd Year</td>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;">3rd Year</td>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;">4th Year</td>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;">TOTAL</td>
                    </tr>
                    <tr>
                        <td style="width: 100%; text-align: left; font-weight: bold; border: 1px solid black;">SASED</td>
                        <td style="width:text-align: left; border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BEEd</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['beed1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['beed2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['beed3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['beed4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BEEDTOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BSEd - ENG</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bseng1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bseng2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bseng3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bseng4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSEDENGTOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BSEd - SCIENCE</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bssci1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bssci2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bssci3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bssci4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSEDSCITOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BSEd - MATH</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsmath1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsmath2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsmath3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsmath4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSEDMATHTOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BSEd - FILIPINO</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsfil1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsfil2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsfil3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsfil4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSEDFILTOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BSPSYCH</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bspsy1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bspsy2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bspsy3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bspsy4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSEDPsychtOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">METHODS</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsmet1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsmet2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsmet3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsmet4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSEDMETHODSTOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 100%; text-align: left; font-weight: bold; border: 1px solid black;">SCJ</td>
                        <td style="width:text-align: left; border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BSCRIM</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bscrim1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bscrim2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bscrim3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bscrim4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSCRIMTOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 100%; text-align: left; font-weight: bold; border: 1px solid black;">SBA</td>
                        <td style="width:text-align: left; border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BSA</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsa1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsa2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsa3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsa4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSATOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BSAIS</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsais1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsais2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsais3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsais4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSAISTOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BSBA - FM</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsbafm1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsbafm2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsbafm3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsbafm4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSBAFMTOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BSBA - MM</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsbamm1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsbamm2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsbamm3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsbamm4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSBAMMTOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 100%; text-align: left; font-weight: bold; border: 1px solid black;">STHM</td>
                        <td style="width: text-align: left; border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BSHM</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bshm1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bshm2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bshm3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bshm4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSHMTOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BSTM</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bstm1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bstm2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bstm3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bstm4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSTMTOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 100%; text-align: left; font-weight: bold; border: 1px solid black;">SCITE</td>
                        <td style="width: text-align: left; border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">ACT</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['actdev1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['actdev2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['actdev3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['actdev4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['ACTDEVTOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BSIT</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsit1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsit2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsit3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsit4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSITTOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BSCS</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bscs1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bscs2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bscs3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bscs4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSCSTOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BSCpE</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bscpe1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bscpe2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bscpe3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bscpe4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSCPETOTAL'].'</td>
                    </tr>
                    <tr>
                        <td style="width: 14%; text-align: left; font-weight: bold; border: 1px solid black;"></td>
                        <td style="width: 16%; text-align: left;border: 1px solid black;">BSCE</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsce1st'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsce2nd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsce3rd'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['bsce4th'].'</td>
                        <td style="width: 14%; text-align: left;border: 1px solid black;">'.$data['BSCETOTAL'].'</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th style="width: 25%; text-align: center; font-weight: bold; color: red;">TOTAL IBED</th>
                        <th style="width: 25%; text-align: center; font-weight: bold; color: red;">TOTAL SHS</th>
                        <th style="width: 25%; text-align: center; font-weight: bold; color: red;">TOTAL COLLEGE</th>
                        <th style="width: 25%; text-align: center; font-weight: bold; color: red;">TOTAL ENROLLED</th>
                    </tr>
                    <tr>
                        <td style="width: 25%; text-align: center; font-weight: bold; font-size: 14px; color: red;">'.$data['TOTALIBED'].'</td>
                        <td style="width: 25%; text-align: center; font-weight: bold; font-size: 14px; color: red;">'.$data['TOTALSHS'].'</td>
                        <td style="width: 25%; text-align: center; font-weight: bold; font-size: 14px; color: red;">'.$data['TOTALCOLLEGE'].'</td>
                        <td style="width: 25%; text-align: center; font-weight: bold; font-size: 14px; color: red;">'.$data['TOTALENROLLED'].'</td>
                    </tr>
                </tfoot>
            </table>
        ';
        $pdf->writeHTML($html, true, false, false, false, '');
        $filename = 'ENROLLMENT_REPORT_' . date('F j Y h:i A') . '.pdf';
        $pdfContent = $pdf->Output($filename, 'S');
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody($pdfContent);
    }

    private function generateOutput($writer) {
        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_contents();
        ob_end_clean();

        return $excelOutput;
    }
}
