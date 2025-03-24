<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\ImportedGradesModel;
use App\Models\StudentsModel;
use App\Models\SYModel;
use App\Models\SemesterModel;
use TCPDF;
class GradeController extends BaseController
{
    public $usersModel;
    public $importedGradeModel;
    public $studentsModel;
    public $syModel;
    public $semModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->importedGradeModel = new ImportedGradesModel();
        $this->studentsModel = new StudentsModel();
        $this->syModel = new SYModel();
        $this->semModel = new SemesterModel();
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

            $studexp = $db->query("SELECT * FROM importedgrades WHERE studentno = '$studentnum'");
            $studexpresult = $studexp->getRow(0);

            $syinfo = $db->query("SELECT * FROM sy WHERE syid = '$sy'");
            $syresult = $syinfo->getRow(0);
            $GETSY = $syresult->syname;

            $seminfo = $db->query("SELECT * FROM semester WHERE semid = '$sem'");
            $semresult = $seminfo->getRow(0);
            $GETSEM = $semresult->semester;

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
                        <td><strong>Semester: </strong>'.$semresult->semester.'</td>
                    </tr>
                    <tr>
                        <td><strong>Course: </strong>'.$studexpresult->course.'</td>
                        <td><strong>Year: </strong>'.$studexpresult->yearlevel.'</td>
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
}
