<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\ImportedGradesModel;
use App\Models\StudentsModel;
use App\Models\SYModel;
use App\Models\SemesterModel;
use App\Models\EmployeesModel;
use App\Models\SectionTempModel;
use App\Models\CoursesModel;
use TCPDF;
class GradeController extends BaseController
{
    public $usersModel;
    public $importedGradeModel;
    public $studentsModel;
    public $syModel;
    public $semModel;
    public $empModel;
    public $stModel;
    public $courseModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->importedGradeModel = new ImportedGradesModel();
        $this->studentsModel = new StudentsModel();
        $this->syModel = new SYModel();
        $this->semModel = new SemesterModel();
        $this->empModel = new EmployeesModel();
        $this->stModel = new SectionTempModel();
        $this->courseModel = new CoursesModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Grades',
            'page_heading' => 'GRADES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];

        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['schoolyeardata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semesterdata'] = $this->semModel->where('semisdel', 0)->findAll();

        if($this->request->is('post')) {
            $searchStudent = $this->request->getVar('searchstud');
            if($searchStudent == '') {
                $StudentsCondition = array('studisdel' => 0);
                $data['resultStudent'] = $this->studentsModel->where($StudentsCondition)->findAll();
                return view('gradeviewresult', $data);
            } else {
                $StudentsCondition = array('studisdel' => 0);
                $data['resultStudent'] = $this->studentsModel->where($StudentsCondition)
                ->like('studentno', $searchStudent)
                ->orLike('studln', $searchStudent)
                ->orLike('studfn', $searchStudent)->findAll();
                return view('gradeviewresult', $data);
            }
        }
        return view('gradeview', $data);
    }
    public function gradesImportedLock() {
        
        $this->studentsModel
        ->set('studstatus', 0)
        ->where('studisdel', 0)
        ->update();

        return redirect()->to(base_url()."grades");
    }
    public function setSemestral() {
        $db = \Config\Database::connect();
        $sql = 'UPDATE importedgrades SET semestral = (prelim * .3) + (midterm * .3) + (final* .4)';
        $db->query($sql);

        return redirect()->to(base_url()."grades");
    }
    public function gradeView($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | Student Grades',
            'page_heading' => 'GRADES ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $usersinfo = $this->usersModel->where('uid', $uid)->findAll();
        $data['accountinfo'] = $this->studentsModel->where('studentno', $id)->findAll();
        $data['schoolyeardata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semesterdata'] = $this->semModel->where('semisdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'schoolyear' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'School year is required.',
                    ],
                ],
                'semester' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Semester is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $sy = $this->request->getVar('schoolyear');
                $sem = $this->request->getVar('semester');
                $this->session->set('selected_sy', $sy);
                $this->session->set('selected_sem', $sem);
                return redirect()->to(base_url().'gradesview/result/'.$id);
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('gradeviewing', $data);
    }
    public function gradeViewResult($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | Student Grades',
            'page_heading' => 'GRADES ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $usersinfo = $this->usersModel->where('uid', $uid)->findAll();
        $data['accountinfo'] = $this->studentsModel->where('studentno', $id)->findAll();
        $syid = session()->get('selected_sy');
        $semid = session()->get('selected_sem');
        $data['selectedsy'] = $this->syModel->where('syname', $syid)->findAll();
        $data['selectedsem'] = $this->semModel->where('semester', $semid)->findAll();
        $data['schoolyeardata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semesterdata'] = $this->semModel->where('semisdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'schoolyear' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'School year is required.',
                    ],
                ],
                'semester' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Semester is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $sy = $this->request->getVar('schoolyear');
                $sem = $this->request->getVar('semester');
                $this->session->set('selected_sy', $sy);
                $this->session->set('selected_sem', $sem);
                return redirect()->to(base_url().'gradesview/result/'.$id);
            } else {
                $data['validation'] = $this->validator;
            }
        }
        $importedGradeCondition = array('sy' => $syid, 'sem' => $semid, 'studentno' => $id);
        $data['importedGradeData'] = $this->importedGradeModel->where($importedGradeCondition)->findAll();
        return view('gradeviewingresult', $data);
    }
    public function gradeViewUpdate($id=null) {
        if($this->request->is('post')) {
            $studid = $this->request->getVar('studnotext');
            $data = [
                'prelim' => $this->request->getVar('prelimtext'),
                'midterm' => $this->request->getVar('midtermtext'),
                'final' => $this->request->getVar('finaltext'),
            ];

            $this->importedGradeModel->where('impgradeid', $id)->update($id, $data);
            // UPDATE SEMESTRAL
            $db = \Config\Database::connect();
            $sql = 'UPDATE importedgrades SET semestral = (prelim * .3) + (midterm * .3) + (final* .4)';
            $db->query($sql);

            session()->setTempdata('updatesuccess', 'Update is Successful!', 2);
            return redirect()->to(base_url()."gradesview/result/".$studid);
        }
    }
    public function gradesDownload() {
        
        if($this->request->is('post')){
            $sy = $this->request->getVar('schoolyear');
            $sem = $this->request->getVar('semester');
            $studentnum = $this->request->getVar('studno');

            // $StudentsCondition = array('studentno' => $studentnum, 'sy' => $sy, 'sem' => $sem);
            // $studinfo = $this->importedGradeModel->where($StudentsCondition)->findAll();
            
            // $db = \Config\Database::connect();
            // $studinfo = $db->query("SELECT * FROM importedgrades WHERE studentno = '$studentnum' AND sy = '$sy' AND sem = '$sem'");
            // foreach($studinfo->get() as $studvalue){
            //     $studlastname = $studvalue['lname'];
            //     $studfirstname = $studvalue['fname'];
            //     $studcourse = $studvalue['course'];
            //     $studyear = $studvalue['year'];
            // }

            // Load TCPDF library
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->SetAuthor('MIS Department');
            $pdf->SetTitle('Certification of Grades');

            // set default header data
            // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(5,40,5);
            //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetHeaderMargin(0);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }

            // set font
            $pdf->SetFont('dejavusans', '', 10);

            // add a page
            $pdf->AddPage();
            $sy = $this->request->getVar('schoolyear');
            $sem = $this->request->getVar('semester');
            $studentnum = $this->request->getVar('studno');

            // HEADER
            
            $imagePath = FCPATH .'public/uploads/hccheader.png';
            $pdf->Image($imagePath, $x = 5, $y = 0, $w = 206, $h = 36); 
            $pdf->Line(5, 37, 211, 37);

            $db = \Config\Database::connect();

            $studinfo = $db->query("SELECT * FROM students WHERE studentno = '$studentnum'");
            $studresult = $studinfo->getRow(0);

            

            $syinfo = $db->query("SELECT * FROM sy WHERE syid = '$sy'");
            $syresult = $syinfo->getRow(0);
            $GETSY = $syresult->syname;

            $seminfo = $db->query("SELECT * FROM semester WHERE semid = '$sem'");
            $semresult = $seminfo->getRow(0);
            $GETSEM = $semresult->semester;

            $studexp = $db->query("SELECT * FROM importedgrades WHERE studentno = '$studentnum' AND sy = '$GETSY' AND sem = '$GETSEM'");
            $studexpresult = $studexp->getRow(0);

            $totalunits = $db->query("SELECT SUM(nounits) as TOTALUNITS FROM importedgrades 
            WHERE studentno = '$studentnum' AND sy = '$GETSY' AND sem = '$GETSEM'");
            $totalunitsresult = $totalunits->getRow();
            $SUMUNITS = $totalunitsresult->TOTALUNITS;

            $semestralxunits = $db->query("SELECT SUM(semestral * nounits) as COMPUTED FROM importedgrades
            WHERE studentno = '$studentnum' AND sy = '$GETSY' AND sem = '$GETSEM'");
            $totalsemestralxunits = $semestralxunits->getRow();
            $SEMXUNIT = $totalsemestralxunits->COMPUTED;
            
            $html = '
            
                <style>        
                    .evaluation {
                        border: 1px solid black;
                    }
                    table td{
                        font-size: 12px;
                        font-family: Verdana, Geneva, Tahoma, sans-serif;
                    }
                </style>
                <div style="background-image:url('.base_url().'/public/assets/images/logohcc.png); height:500px;width:500px;"></div>
                <table>
                    <tr>
                        <td style="width: 70%;"></td>
                        <td><h3>COLLEGE DEPARTMENT</h3></td>
                    </tr>
                </table><br><br>

                <table>
                    <tr>
                        <td style="background-color: #b5b5b5; font-size: 25px; font-weight: bold; text-align: center;">CERTIFICATION OF GRADES</td>
                    </tr>
                </table><br><br>

                <table>
                    <tr>
                        <td style="width: 70%;"><strong>Name: </strong>'.$studresult->studln.', '.$studresult->studfn.' '.$studresult->studextension.' '.$studresult->studmn.'</td>
                        <td><strong>School Year: </strong>'.$syresult->syname.'</td>
                    </tr>
                    <tr>
                        <td><strong>Student Number: </strong>'.$studentnum.'</td>
                        <td><strong>Year: </strong>'.$studexpresult->yearlevel.'</td>
                    </tr>
                    <tr>
                        <td><strong>Course: </strong>'.$studexpresult->course.'</td>
                        <td><strong>Semester: </strong>'.$semresult->semester.'</td>
                    </tr>
                    <tr>
                        <td><strong>Address: </strong>'.$studresult->studstbarangay.' '.$studresult->studcity.', '.$studresult->studprovince.'</td>
                        <td><strong>Section: </strong>'.$studresult->studcreatedat.'</td>
                    </tr>
                    <tr>
                        <td></td> 
                        <td><h3 style="color: red;"><strong>GWA: '.round($SEMXUNIT / $SUMUNITS, 2).'</strong></h3></td>
                    </tr>
            </table><br><br>

            <table border="1" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 15%;text-align: center;font-weight: bold;">Subject Code</th>
                        <th style="width: 39%;text-align: center;font-weight: bold;">Subject Description</th>
                        <th style="width: 8%;text-align: center;font-weight: bold;">Grade</th>
                        <th style="width: 7%;text-align: center;font-weight: bold;">Eqv.</th>
                        <th style="width: 10%;text-align: center;font-weight: bold;">Remarks</th>
                        <th style="width: 19%;text-align: center;font-weight: bold;">Teacher</th>
                    </tr>
                </thead>
                <tbody>           
            ';
            $igmCondition = array('studentno' => $studentnum, 'sy' => $GETSY, 'sem' => $GETSEM);
            $igm = $this->importedGradeModel->where($igmCondition)->findAll();

            foreach($igm as $row){

                if($row['prelim'] == 'INC' || $row['prelim'] == 'UW' || $row['prelim'] == 'FA' || $row['prelim'] == '' || $row['prelim'] == 'inc' || $row['prelim'] == 'fa' || $row['prelim'] == 'uw' || $row['prelim'] == 'DRP' || $row['prelim'] == 'drp'){
                    $PRELIM = '0';
                }else{
                    $PRELIM = $row['prelim'] * .3;
                }

                if($row['midterm'] == 'INC' || $row['midterm'] == 'UW' || $row['midterm'] == 'FA' || $row['midterm'] == '' || $row['prelim'] == 'inc' || $row['prelim'] == 'fa' || $row['prelim'] == 'uw' || $row['prelim'] == 'DRP' || $row['prelim'] == 'drp'){
                    $MIDTERM = '0';
                }else{
                    $MIDTERM = $row['midterm'] * .3;
                }
                
                if($row['final'] == 'INC' || $row['final'] == 'UW' || $row['final'] == 'FA' || $row['final'] == '' || $row['prelim'] == 'inc' || $row['prelim'] == 'fa' || $row['prelim'] == 'uw' || $row['prelim'] == 'DRP' || $row['prelim'] == 'drp'){
                    $FINALS = '0';
                }else{
                    $FINALS = $row['final'] * .4;
                }
                
                $SEMESTRAL = $PRELIM + $MIDTERM + $FINALS;
                $FORMATED = round($SEMESTRAL, 0, PHP_ROUND_HALF_UP);

                if($FORMATED >= '97' && $FORMATED <= '100'){
                    $EQUIVALENT = '1.00';
                }else if($FORMATED >= '94' && $FORMATED <= '96'){
                    $EQUIVALENT = '1.25';
                }else if($FORMATED >= '91' && $FORMATED <= '93'){
                    $EQUIVALENT = '1.50';
                }else if($FORMATED >= '88' && $FORMATED <= '90'){
                    $EQUIVALENT = '1.75';
                }else if($FORMATED >= '85' && $FORMATED <= '87'){
                    $EQUIVALENT = '2.00';
                }else if($FORMATED >= '82' && $FORMATED <= '84'){
                    $EQUIVALENT = '2.25';
                }else if($FORMATED >= '79' && $FORMATED <= '81'){
                    $EQUIVALENT = '2.50';
                }else if($FORMATED >= '76' && $FORMATED <= '78'){
                    $EQUIVALENT = '2.75';
                }else if($FORMATED == '75' ){
                    $EQUIVALENT = '3.00';
                }else if($FORMATED == '74'){
                    $EQUIVALENT = '5.00';
                }else if($row['prelim'] == 'INC' || $row['prelim'] == 'inc' || $row['midterm'] == 'INC' || $row['midterm'] == 'inc' || $row['final'] == 'INC' || $row['final'] == 'inc'){
                    $EQUIVALENT = 'INC';
                }else{
                    $EQUIVALENT = 'FA';
                }

                if($FORMATED >= '75' || $FORMATED == '100'){
                    $REMARK = 'PASSED';
                }else if($row['prelim'] == 'INC' || $row['prelim'] == 'inc' || $row['midterm'] == 'INC' || $row['midterm'] == 'inc' || $row['final'] == 'INC' || $row['final'] == 'inc'){
                    $REMARK = 'INC';
                }else if($row['prelim'] == 'UW' || $row['midterm'] == 'UW' || $row['final'] == 'UW' || $row['prelim'] == 'uw' || $row['midterm'] == 'uw' || $row['final'] == 'uw'){
                    $REMARK = 'UW';
                }else if($row['prelim'] == 'DRP' || $row['midterm'] == 'DRP' || $row['final'] == 'DRP' || $row['prelim'] == 'drp' || $row['midterm'] == 'drp' || $row['final'] == 'drp'){
                    $REMARK = 'UW';
                }else{
                    $REMARK = 'FAILED';
                }

                $html .= '<tr>
                    <td style="width: 15%;"> '.$row['subjectcode'].'</td>
                    <td style="width: 39%;"> '.$row['subjectdescription'].' </td>
                    <td style="width: 8%; text-align: center;"> '.$FORMATED.'</td>
                    <td style="width: 7%; text-align: center;"> '.$EQUIVALENT.'</td>
                    <td style="width: 10%; text-align: center;"> '.$REMARK.'</td>
                    <td style="width: 19%; text-align: center; font-size: 9px"> '.$row['teachername'].'</td>

                </tr>';
            }

            

            $html .= ' </tbody>
                        </table><br><br>  
                        
                        
                <table>
                    <tr>
                        <td style="text-align: center;">*** THIS IS A STUDENT\'S E-COPY, NOT VALID AS AN OFFICIAL DOCUMENT WITHOUT THE REGISTRAR\'S SIGNATURE ***</td>
                    </tr>
                </table><br><br><br><br><br><br><br><br><br><br><br><br><br><br>            
                        
            <table>
                <tr>
                    <td style="text-align: center;"><strong>BENJIE B. NOLASCO, LPT, MAEd.</strong></td>
                    <td style="text-align: center;"></td>
                </tr>
                <tr>
                    <td style="text-align: center;">Dean SASD<br>Acting Registrar</td>
                    <td style="text-align: center;"></td>
                </tr>
            </table>        
            ';

            // Output PDF to browser
            $pdf->writeHTML($html, true, false, false, false, '');
            $pdf->Output($studresult->studln.','.$studresult->studfn.'.pdf', 'D');
        }
    }
    public function gradesCollege() {
        $data = [
            'page_title' => 'Holy Cross College | College Grades Encoding',
            'page_heading' => 'COLLEGE GRADES ENCODING! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['schoolyeardata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semesterdata'] = $this->semModel->where('semisdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'schoolyear' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'School year is required.',
                    ],
                ],
                'semester' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Semester is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $sy = $this->request->getVar('schoolyear');
                $sem = $this->request->getVar('semester');
                $this->session->set('selected_sy', $sy);
                $this->session->set('selected_sem', $sem);
                return redirect()->to(base_url().'grades-college-result');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('collegegradesview', $data);
    }
    public function gradesCollegeResult() {
        $data = [
            'page_title' => 'Holy Cross College | College Grades Encoding',
            'page_heading' => 'COLLEGE GRADES ENCODING! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ]; 

        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        foreach($data['usersaccess'] as $user) {
            $ACCOUNTNO = $user['uaccountid'];
        }
        $IMPNO = $this->empModel->where('empnum', $ACCOUNTNO)->findColumn('impno');
        $syid = session()->get('selected_sy');
        $semid = session()->get('selected_sem');
        $data['selectedsy'] = $this->syModel->where('syname', $syid)->findAll();
        $data['selectedsem'] = $this->semModel->where('semester', $semid)->findAll();
        $data['schoolyeardata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semesterdata'] = $this->semModel->where('semisdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'schoolyear' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'School year is required.',
                    ],
                ],
                'semester' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Semester is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $sy = $this->request->getVar('schoolyear');
                $sem = $this->request->getVar('semester');
                $this->session->set('selected_sy', $sy);
                $this->session->set('selected_sem', $sem);
                return redirect()->to(base_url().'grades-college-result');
            } else {
                $data['validation'] = $this->validator;
            }
        }
        
        $importedGradeCondition = array('sy' => $syid, 'sem' => $semid, 'teacherid' => $IMPNO);
        $data['importedGradeData'] = $this->importedGradeModel->where($importedGradeCondition)->groupBy('scheduleid')->findAll();
        $data['sectionTempData'] = $this->stModel->findAll();
        return view('collegegradesresultview', $data);
    }
    public function gradesCollegeEncoding($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | College Grades Encoding',
            'page_heading' => 'COLLEGE GRADES ENCODING! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ]; 

        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        foreach($data['usersaccess'] as $user) {
            $ACCOUNTNO = $user['uaccountid'];
        }
        $IMPNO = $this->empModel->where('empnum', $ACCOUNTNO)->findColumn('impno');
        $syid = session()->get('selected_sy');
        $semid = session()->get('selected_sem');
        $data['selectedsy'] = $this->syModel->where('syname', $syid)->findAll();
        $data['selectedsem'] = $this->semModel->where('semester', $semid)->findAll();
        $data['schoolyeardata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semesterdata'] = $this->semModel->where('semisdel', 0)->findAll();

        $importedGradeCondition = array('sy' => $syid, 'sem' => $semid, 'teacherid' => $IMPNO, 'scheduleid' => $id);
        $data['importedGradeData'] = $this->importedGradeModel->where($importedGradeCondition)->orderBy('lname', 'ASC')->findAll();

        return view('collegegradesencodingview', $data);
    }
    public function gradesCollegeEncodingSubmit() {
        // if($this->request->is('post')) {
        //     $SCHEDID = $this->request->getVar('scheduleid');
        //     $data = [
        //         'prelim' => $this->request->getVar('prelim'),
        //         'midterm' => $this->request->getVar('midterm'),
        //         'final' => $this->request->getVar('final'),
        //     ];

        //     $this->importedGradeModel->where('impgradeid', $id)->update($id, $data);
        //     // UPDATE SEMESTRAL
        //     $db = \Config\Database::connect();
        //     $sql = 'UPDATE importedgrades SET semestral = (prelim * .3) + (midterm * .3) + (final* .4)';
        //     $db->query($sql);

        //     session()->setTempdata('updatesuccess', 'Update is Successful!', 2);
        //     return redirect()->to(base_url()."grades-college-encoding/".$SCHEDID);
        // }
        if($this->request->is('post')) {
            $importedG = new ImportedGradesModel();
            $SCHEDID = $this->request->getVar('schedid');
            $ids = $this->request->getPost('id');
            $prelims = $this->request->getPost('prelim');
            $midterms = $this->request->getPost('midterm');
            $finals = $this->request->getPost('final');

            // Use a transaction to ensure data integrity
            $db = \Config\Database::connect();
            $db->transStart();
            
            try {
                foreach ($ids as $index => $id) {
                    $data = [
                        'prelim' => $prelims[$index],
                        'midterm' => $midterms[$index],
                        'final' => $finals[$index],
                    ];
                    
                    // Update each record individually
                    $importedG->update($id, $data);
                }
                
                $db->transComplete();
                
                if ($db->transStatus() === FALSE) {
                    session()->setTempdata('error', 'Update failed!', 2);
                } else {
                    $sql = 'UPDATE importedgrades SET semestral = (prelim * .3) + (midterm * .3) + (final* .4)';
                    $db->query($sql);
                    session()->setTempdata('updatesuccess', 'Update is Successful!', 2);
                }
                
            } catch (\Exception $e) {
                $db->transRollback();
                session()->setTempdata('error', 'Update failed: ' . $e->getMessage(), 2);
            }
            
            return redirect()->to(base_url()."grades-college-encoding/".$SCHEDID);
        }
    }
    public function gradesCollegePrint($id=null) {
        // Load TCPDF library
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetAuthor('TRS Department');
        $pdf->SetTitle('Summary of Grades');

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(5,40,5,0);
        //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

            // set font
        $pdf->SetFont('dejavusans', '', 10);
        // add a page
        $pdf->AddPage();

        // HEADER
        $imagePath = FCPATH .'public/uploads/hccheader.png';
        $pdf->Image($imagePath, $x = 5, $y = 0, $w = 206, $h = 36); 
        $pdf->Line(5, 37, 211, 37);

        $db = \Config\Database::connect();
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        foreach($data['usersaccess'] as $user) {
            $ACCOUNTNO = $user['uaccountid'];
        }
        $IMPNO = $this->empModel->where('empnum', $ACCOUNTNO)->findAll();
        foreach($IMPNO as $impvalue){
            $TEACHERIMP = $impvalue['impno'];
        }
        $syid = session()->get('selected_sy');
        $semid = session()->get('selected_sem');

        $summarygradeinfo = $db->query("SELECT * FROM importedgrades WHERE sy = '$syid' 
        AND teacherid = '$TEACHERIMP' AND sem = '$semid' AND scheduleid = '$id'");
        $summarygradeinforesult = $summarygradeinfo->getRow(0);
        $IMPSCHEDID = $summarygradeinforesult->scheduleid;
        $IMPCOURSE = $summarygradeinforesult->course;
        $sectionTempData = $this->stModel->where('schedid', $IMPSCHEDID)->findAll();
        foreach($sectionTempData as $sectionvalue){
            $SECTIONNAME = $sectionvalue['section'];
        }
        $courseData = $this->courseModel->where('courcode', $IMPCOURSE)->findAll();
        foreach($courseData as $coursevalue){
            $COURSENAME = $coursevalue['course'];
        }

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
            </style>

            <table>
                <tr>
                    <td style="width: 75%;"></td>
                    <td><h3>COLLEGE DEPARTMENT</h3></td>
                </tr>   
            </table><br><br>

            <table>
                <tr>
                    <td style="background-color: #b5b5b5; font-size: 25px; font-weight: bold; text-align: center;">SUMMARY OF GRADES</td>
                </tr>
            </table><br><br>

            <table>
                <tr>
                    <td style="width: 60%;">Course Code: <strong>'. strtoupper($summarygradeinforesult->subjectcode) .'</strong></td>
                    <td>Instructor: <strong>'. strtoupper($summarygradeinforesult->teachername) .'</strong></td>
                </tr>
                <tr>
                    <td>Course Title: <strong>'. strtoupper($summarygradeinforesult->subjectdescription) .'</strong></td>
                    <td>Semester: <strong>'. strtoupper($summarygradeinforesult->sem) .'</strong></td>
                </tr>
                <tr>
                    <td>Unit: <strong>'. strtoupper($summarygradeinforesult->nounits) .'</strong></td>
                    <td>School Year: <strong>'. strtoupper($summarygradeinforesult->sy) .'</strong></td>
                </tr>
                <tr>
                    <td>Program: <strong>'. strtoupper($COURSENAME) .'</strong></td>
                    <td>Section: <strong>'. strtoupper($SECTIONNAME) .'</strong></td>
                </tr>
            </table><br><br>

            <table border="1" style="width: 100%; font-size: 10px;">
                <thead>
                    <tr>
                        <th style="width: 10%;text-align: center;">STUDENT</th>
                        <th style="width: 29%;text-align: center;">NAME</th>
                        <th style="width: 15%;text-align: center;">PROGRAM</th>
                        <th style="width: 7%;text-align: center;">PRELIM</th>
                        <th style="width: 7%;text-align: center; font-size: 9px;">MIDTERM</th>
                        <th style="width: 7%;text-align: center;">FINAL</th>
                        <th style="width: 7%;text-align: center;">GRADE</th>
                        <th style="width: 9%;text-align: center;">RATING</th>
                        <th style="width: 9%;text-align: center;">REMARKS</th>
                    </tr>
                </thead>
                <tbody>
        ';
        $importedGradeCondition = array('sy' => $syid, 'sem' => $semid, 'teacherid' => $TEACHERIMP, 'scheduleid' => $id);
        $importedGradeData = $this->importedGradeModel->where($importedGradeCondition)->orderBy('lname', 'ASC')->findAll();
        foreach($importedGradeData as $igd) {
            if($igd['prelim'] == 'INC' || $igd['prelim'] == 'UW' || $igd['prelim'] == 'FA' || $igd['prelim'] == '' || $igd['prelim'] == 'inc' || $igd['prelim'] == 'fa' || $igd['prelim'] == 'uw' || $igd['prelim'] == 'DRP' || $igd['prelim'] == 'drp'){
                    $PRELIM = '0';
                }else{
                    $PRELIM = $igd['prelim'] * .3;
                }

                if($igd['midterm'] == 'INC' || $igd['midterm'] == 'UW' || $igd['midterm'] == 'FA' || $igd['midterm'] == '' || $igd['prelim'] == 'inc' || $igd['prelim'] == 'fa' || $igd['prelim'] == 'uw' || $igd['prelim'] == 'DRP' || $igd['prelim'] == 'drp'){
                    $MIDTERM = '0';
                }else{
                    $MIDTERM = $igd['midterm'] * .3;
                }
                
                if($igd['final'] == 'INC' || $igd['final'] == 'UW' || $igd['final'] == 'FA' || $igd['final'] == '' || $igd['prelim'] == 'inc' || $igd['prelim'] == 'fa' || $igd['prelim'] == 'uw' || $igd['prelim'] == 'DRP' || $igd['prelim'] == 'drp'){
                    $FINALS = '0';
                }else{
                    $FINALS = $igd['final'] * .4;
                }
                
                $SEMESTRAL = $PRELIM + $MIDTERM + $FINALS;
                $FORMATED = round($SEMESTRAL, 0, PHP_ROUND_HALF_UP);

                if($FORMATED >= '97' && $FORMATED <= '100'){
                    $EQUIVALENT = '1.00';
                }else if($FORMATED >= '94' && $FORMATED <= '96'){
                    $EQUIVALENT = '1.25';
                }else if($FORMATED >= '91' && $FORMATED <= '93'){
                    $EQUIVALENT = '1.50';
                }else if($FORMATED >= '88' && $FORMATED <= '90'){
                    $EQUIVALENT = '1.75';
                }else if($FORMATED >= '85' && $FORMATED <= '87'){
                    $EQUIVALENT = '2.00';
                }else if($FORMATED >= '82' && $FORMATED <= '84'){
                    $EQUIVALENT = '2.25';
                }else if($FORMATED >= '79' && $FORMATED <= '81'){
                    $EQUIVALENT = '2.50';
                }else if($FORMATED >= '76' && $FORMATED <= '78'){
                    $EQUIVALENT = '2.75';
                }else if($FORMATED == '75' ){
                    $EQUIVALENT = '3.00';
                }else if($FORMATED == '74'){
                    $EQUIVALENT = '5.00';
                }else if($igd['prelim'] == 'INC' || $igd['prelim'] == 'inc' || $igd['midterm'] == 'INC' || $igd['midterm'] == 'inc' || $igd['final'] == 'INC' || $igd['final'] == 'inc'){
                    $EQUIVALENT = 'INC';
                }else if($igd['prelim'] == 'UW' || $igd['prelim'] == 'uw' || $igd['midterm'] == 'UW' || $igd['midterm'] == 'uw' || $igd['final'] == 'UW' || $igd['final'] == 'uw'){
                    $EQUIVALENT = 'UW';
                }else if($igd['prelim'] == 'DRP' || $igd['prelim'] == 'drp' || $igd['midterm'] == 'DRP' || $igd['midterm'] == 'drp' || $igd['final'] == 'DRP' || $igd['final'] == 'drp'){
                    $EQUIVALENT = 'DRP';
                }else{
                    $EQUIVALENT = 'FA';
                }

                if($FORMATED >= '75' || $FORMATED == '100'){
                    $REMARK = 'PASSED';
                }else if($igd['prelim'] == 'INC' || $igd['prelim'] == 'inc' || $igd['midterm'] == 'INC' || $igd['midterm'] == 'inc' || $igd['final'] == 'INC' || $igd['final'] == 'inc'){
                    $REMARK = 'INC';
                }else if($igd['prelim'] == 'UW' || $igd['midterm'] == 'UW' || $igd['final'] == 'UW' || $igd['prelim'] == 'uw' || $igd['midterm'] == 'uw' || $igd['final'] == 'uw'){
                    $REMARK = 'UW';
                }else if($igd['prelim'] == 'DRP' || $igd['midterm'] == 'DRP' || $igd['final'] == 'DRP' || $igd['prelim'] == 'drp' || $igd['midterm'] == 'drp' || $igd['final'] == 'drp'){
                    $REMARK = 'DRP';
                }else{
                    $REMARK = 'FAILED';
                }
            $html .= '<tr>
                    <td style="width: 10%;text-align: center;">'.strtoupper($igd['studentno']).'</td>
                    <td style="width: 29%;text-align: left;">'.strtoupper($igd['lname']).','.strtoupper($igd['fname']).'</td>
                    <td style="width: 15%;text-align: center;">'.strtoupper($igd['course']).'</td>
                    <td style="width: 7%;text-align: center;">'.strtoupper($igd['prelim']).'</td>
                    <td style="width: 7%;text-align: center;">'.strtoupper($igd['midterm']).'</td>
                    <td style="width: 7%;text-align: center;">'.strtoupper($igd['final']).'</td>
                    <td style="width: 7%;text-align: center;">'.strtoupper(round($igd['semestral'])).'</td>
                    <td style="width: 9%;text-align: center;">'.strtoupper($EQUIVALENT).'</td>
                    <td style="width: 9%;text-align: center;">'.strtoupper($REMARK).'</td>
                </tr>';
        }
        $html .= ' 
                <tr>
                    <td style="width: 100%; text-align: center;">NOTHING FOLLOWS</td>
                </tr></tbody>
            </table><br><br>';
        $html .='
            <table>
                <tbody>
                    <tr>
                        <td style="width: 1%;"></td>
                        <td style="width: 32%;">Submitted by:</td>
                        <td style="width: 1%;"></td>
                        <td style="width: 32%;">Noted by:</td>
                        <td style="width: 1%;"></td>
                        <td style="width: 32%;">Approved by:</td>
                    </tr>
                    <br>
                    <br>
                    <tr>
                        <td style="width: 2%;"></td>
                        <td style="width: 32%;"><strong>'. strtoupper($summarygradeinforesult->teachername) .'</strong></td>
                        <td style="width: 1%;"></td>
                        <td style="width: 32%; border-bottom: 1px solid #000000ff"></td>
                        <td style="width: 1%;"></td>
                        <td style="width: 32%; border-bottom: 1px solid #000000ff"></td>
                    </tr>
                    <tr>
                        <td style="width: 2%;"></td>
                        <td style="width: 32%;">Instructor</td>
                        <td style="width: 1%;"></td>
                        <td style="width: 32%;">Program Chair</td>
                        <td style="width: 1%;"></td>
                        <td style="width: 32%;">Dean</td>
                    </tr>
                </tbody>
            </table><br><br>
        ';
        $html .='
            <table>
                <tbody>
                    <tr>
                        <td style="width: 70%;">
                            <table style="width: 100%; font-size: 9px;">
                                <tbody>
                                    <tr>
                                        <td style="width: 30%;">97 - 100 = 1.00</td>
                                        <td style="width: 30%;">82 - 84 = 2.25</td>
                                        <td style="width: 40%;">FA - Failure due to Absences</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">94 - 96 = 1.25</td>
                                        <td style="width: 30%;">79 - 81 = 2.50</td>
                                        <td style="width: 40%;">INC - INCOMPLETE</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">91 - 93 = 1.50</td>
                                        <td style="width: 30%;">76 - 78 = 2.75</td>
                                        <td style="width: 40%;">UW - Unauthorized Withdrawal</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">88 - 90 = 1.75</td>
                                        <td style="width: 30%;">75 = 3.00</td>
                                        <td style="width: 40%;">DRP - Authorized Withdrawal</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%;">85 - 87 = 2.00</td>
                                        <td style="width: 30%;">Below 75% = 5.00</td>
                                        <td style="width: 40%;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table><br><br>
        ';
        // Output PDF to browser
        $pdf->writeHTML($html, true, false, false, false, '');
        $pdf->Output(strtoupper($SECTIONNAME).' - Summary of Grades.pdf', 'D');
    }
    public function gradesCollegeFaculty() {
        $data = [
            'page_title' => 'Holy Cross College | College Faculty Grades',
            'page_heading' => 'COLLEGE FACULTY GRADES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['schoolyeardata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semesterdata'] = $this->semModel->where('semisdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'schoolyear' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'School year is required.',
                    ],
                ],
                'semester' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Semester is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $sy = $this->request->getVar('schoolyear');
                $sem = $this->request->getVar('semester');
                $this->session->set('selected_sy', $sy);
                $this->session->set('selected_sem', $sem);
                return redirect()->to(base_url().'grades-college-faculty-result');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('collegefacultygradesview', $data);
    }
    public function gradesCollegeFacultyResult() {
        $data = [
            'page_title' => 'Holy Cross College | College Faculty Grades',
            'page_heading' => 'COLLEGE FACULTY GRADES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ]; 

        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        
        $syid = session()->get('selected_sy');
        $semid = session()->get('selected_sem');
        $data['selectedsy'] = $this->syModel->where('syname', $syid)->findAll();
        $data['selectedsem'] = $this->semModel->where('semester', $semid)->findAll();
        $data['schoolyeardata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semesterdata'] = $this->semModel->where('semisdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'schoolyear' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'School year is required.',
                    ],
                ],
                'semester' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Semester is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $sy = $this->request->getVar('schoolyear');
                $sem = $this->request->getVar('semester');
                $this->session->set('selected_sy', $sy);
                $this->session->set('selected_sem', $sem);
                return redirect()->to(base_url().'grades-college-faculty-result');
            } else {
                $data['validation'] = $this->validator;
            }
        }
        
        $importedGradeCondition = array('sy' => $syid, 'sem' => $semid);
        $data['importedGradeData'] = $this->importedGradeModel->where($importedGradeCondition)->groupBy('teacherid')->findAll();
        $data['sectionTempData'] = $this->stModel->findAll();
        return view('collegefacultygradesresultview', $data);
    
    }
    public function gradesCollegeFacultySubjects($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | College Faculty Grades',
            'page_heading' => 'COLLEGE FACULTY GRADES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ]; 

        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        
        $syid = session()->get('selected_sy');
        $semid = session()->get('selected_sem');
        $data['selectedsy'] = $this->syModel->where('syname', $syid)->findAll();
        $data['selectedsem'] = $this->semModel->where('semester', $semid)->findAll();
        $data['schoolyeardata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semesterdata'] = $this->semModel->where('semisdel', 0)->findAll();
        
        $importedGradeCondition = array('sy' => $syid, 'sem' => $semid, 'teacherid' => $id);
        $data['importedGradeData'] = $this->importedGradeModel->where($importedGradeCondition)->groupBy('scheduleid')->findAll();
        $data['sectionTempData'] = $this->stModel->findAll();
        return view('collegefacultysubjectsview', $data);
    
    }
    public function gradesCollegeFacultyStudents($id=null, $schedid=null) {
        $data = [
            'page_title' => 'Holy Cross College | College Faculty Grades',
            'page_heading' => 'COLLEGE FACULTY GRADES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ]; 

        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        
        $syid = session()->get('selected_sy');
        $semid = session()->get('selected_sem');
        $data['selectedsy'] = $this->syModel->where('syname', $syid)->findAll();
        $data['selectedsem'] = $this->semModel->where('semester', $semid)->findAll();
        $data['schoolyeardata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semesterdata'] = $this->semModel->where('semisdel', 0)->findAll();

        $importedGradeCondition = array('sy' => $syid, 'sem' => $semid, 'teacherid' => $id, 'scheduleid' => $schedid);
        $data['importedGradeData'] = $this->importedGradeModel->where($importedGradeCondition)->orderBy('lname', 'ASC')->findAll();

        $data['sectionTempData'] = $this->stModel->findAll();
        return view('collegefacultystudentsview', $data);
    
    }
    public function gradesCollegeFacultyStudentsSubmit() {
        if($this->request->is('post')) {
            $importedG = new ImportedGradesModel();
            $SCHEDID = $this->request->getVar('schedid');
            $ids = $this->request->getPost('id');
            $prelims = $this->request->getPost('prelim');
            $midterms = $this->request->getPost('midterm');
            $finals = $this->request->getPost('final');

            // Use a transaction to ensure data integrity
            $db = \Config\Database::connect();
            $db->transStart();
            
            try {
                foreach ($ids as $index => $id) {
                    $data = [
                        'prelim' => $prelims[$index],
                        'midterm' => $midterms[$index],
                        'final' => $finals[$index],
                    ];
                    
                    // Update each record individually
                    $importedG->update($id, $data);
                }
                
                $db->transComplete();
                
                if ($db->transStatus() === FALSE) {
                    session()->setTempdata('error', 'Update failed!', 2);
                } else {
                    $sql = 'UPDATE importedgrades SET semestral = (prelim * .3) + (midterm * .3) + (final* .4)';
                    $db->query($sql);
                    session()->setTempdata('updatesuccess', 'Update is Successful!', 2);
                }
                
            } catch (\Exception $e) {
                $db->transRollback();
                session()->setTempdata('error', 'Update failed: ' . $e->getMessage(), 2);
            }
            
            return redirect()->to(base_url()."grades-college-faculty-result");
        }
    }
}
