<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\StudentsModel;
use App\Models\SYModel;
use App\Models\SemesterModel;
use App\Models\LevelsModel;
use App\Models\CoursesModel;
use App\Models\SchoolRecordModel;
use App\Models\AssessmentModel;
use App\Models\PermanentRecordModel;
use App\Models\EnrollmentTempDataModel;
use App\Models\FamilyBackgroundModel;
use App\Models\CurriculumsModel;
use App\Models\CurriculumDataModel;
use App\Models\StudentCurriculumModel;
use App\Models\CollegeGradesModel;
use App\Models\SectionsModel;
class EnrollmentController extends BaseController
{
    public $usersModel;
    public $studentsModel;
    public $syModel;
    public $semModel;
    public $levelsModel;
    public $coursesModel;
    public $srModel;
    public $assModel;
    public $prModel;
    public $etdModel;
    public $fbModel;
    public $curriModel;
    public $currdataModel;
    public $studcurriModel;
    public $colgradesModel;
    public $sectionsModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->studentsModel = new StudentsModel();
        $this->syModel = new SYModel();
        $this->semModel = new SemesterModel();
        $this->levelsModel = new LevelsModel();
        $this->coursesModel = new CoursesModel();
        $this->srModel = new SchoolRecordModel();
        $this->assModel = new AssessmentModel();
        $this->prModel = new PermanentRecordModel();
        $this->etdModel = new EnrollmentTempDataModel();
        $this->fbModel = new FamilyBackgroundModel();
        $this->curriModel = new CurriculumsModel();
        $this->currdataModel = new CurriculumDataModel();
        $this->studcurriModel = new StudentCurriculumModel();
        $this->colgradesModel = new CollegeGradesModel();
        $this->sectionsModel = new SectionsModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Registration',
            'page_heading' => 'REGISTRATION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        

        if($this->request->is('post')) {
            $rules = [
                'lname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Last name is required.',
                    ],
                ],
                'fname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'First name is required.',
                    ],
                ],
                'mname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Middle name is required.',
                    ],
                ],
                'birthdate' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Birthday is required.',
                    ],
                ],
                'city' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Municipality/City is required.',
                    ],
                ],
                'province' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Province is required.',
                    ],
                ],
                'contact' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Contact number is required.',
                    ],
                ],
                'eschool' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Grade school name is required.',
                    ],
                ],
                'eyeargraduate' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Grade school year graduated is required.',
                    ],
                ],
                'jhschool' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Junior high school name is required.',
                    ],
                ],
                'jhyeargraduate' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Junior high school year graduated is required.',
                    ],
                ],
                'shschool' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Senior high school name is required.',
                    ],
                ],
                'shyeargraduate' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Senior high school year graduated is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $L = $this->request->getVar('lname');
                $F = $this->request->getVar('fname');
                $MN = $this->request->getVar('mname');
                $EXT = $this->request->getVar('extname');
                $FULLNAME = $L.', '.$F.' '.$MN.' '.$EXT;
                $CheckStudent = $this->studentsModel->where('studfullname', $FULLNAME)->findAll();
                // print_r($CheckStudent);
                if(empty($CheckStudent)) {
                    
                    $studdata = [
                        'studln' => $this->request->getVar('lname'),
                        'studfn' => $this->request->getVar('fname'),
                        'studmn' => $this->request->getVar('mname'),
                        'studextension' => $this->request->getVar('extname'),
                        'studfullname' => $FULLNAME,
                        'studbirthday' => $this->request->getVar('birthdate'),
                        'studage' => $this->request->getVar('age'),
                        'studgender' => $this->request->getVar('gender'),
                        'studstbarangay' => $this->request->getVar('barangay'),
                        'studcity' => $this->request->getVar('city'),
                        'studprovince' => $this->request->getVar('province'),
                        'studcontact' => $this->request->getVar('contact'),
                        'studcitizenship' => $this->request->getVar('citizenship'),
                        'studreligion' => $this->request->getVar('religion'),
                        'studemail' => $this->request->getVar('email'),
                        'studbirthplace' => $this->request->getVar('birthplace'),
                    ];
                    $this->studentsModel->save($studdata);
                    $findStudent = $this->studentsModel->where('studfullname', $FULLNAME)->findAll();
                    foreach($findStudent as $fS) {
                        $StudentID = $fS['studid'];
                    }
                    $prdata = [
                        'studid' => $StudentID,
                        'eschool' => $this->request->getVar('eschool'),
                        'eyeargraduate' => $this->request->getVar('eyeargraduate'),
                        'jhschool' => $this->request->getVar('jhschool'),
                        'jhyeargraduate' => $this->request->getVar('jhyeargraduate'),
                        'shschool' => $this->request->getVar('shschool'),
                        'shyeargraduate' => $this->request->getVar('shyeargraduate'),
                    ];
                    $this->prModel->save($prdata);
                    $etdData = [
                        'studno' => $StudentID,
                        'fullname' => $FULLNAME,
                        'date' => date('Y-m-d'),
                        'status' => 'Registered',
                    ];
                    $this->etdModel->save($etdData);
                    $findStudentPR = $this->prModel->where('studid', $StudentID)->findAll();
                    foreach($findStudentPR as $fSPR) {
                        $StudentPRID = $fSPR['prid'];
                    }
                    $studprdata = [
                        'studsprid' => $StudentPRID,
                    ];
                    $this->studentsModel->where('studid', $StudentID)->update($StudentID, $studprdata);
                    session()->setTempdata('addsuccess','Student added successfully', 3);
                    return redirect()->to(current_url());
                }else {
                    session()->setTempdata('error','This student is already registered.', 3);
                    return redirect()->to(current_url());
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('registerstudentview', $data);
    }
    public function admission() {
        $data = [
            'page_title' => 'Holy Cross College | Admission',
            'page_heading' => 'ADMISSION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['etdlist'] = $this->etdModel->where('status', 'Registered')->where('sy', '')->where('sem', '')->where('level', '')->findAll();
        $data['studentinfo'] = $this->studentsModel->findAll();

        return view('admissionview', $data);
    }
    public function admissionview($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | Admission',
            'page_heading' => 'ADMISSION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['students'] = $this->studentsModel->where('studid', $id)->findAll();

        $data['schoolyear'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semester'] = $this->semModel->where('semisdel', 0)->findAll();
        $data['level'] = $this->levelsModel->where('levelisdel', 0)->findAll();
        $data['course'] = $this->coursesModel->where('courisdel', 0)->findAll();

        return view('admissionprocessview', $data);
    }
    public function admissionGenerate($id=null) {
        $year = date('y');
        // print_r($year);
        $laststudentno = $this->studentsModel
        ->like('studentno', $year . '-', 'after')
        ->orderBy('studentno', 'DESC')
        ->get()
        ->getFirstRow();

        if ($laststudentno) {
            $lastNumber = (int)substr($laststudentno->studentno, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = '1';
        }

        $studentNumber = $year . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        // print_r($studentNumber);
        $data = [
            'studentno' => $studentNumber,
        ];
        $this->studentsModel->where('studid', $id)->update($id, $data);
        return redirect()->to(base_url()."admission-view/".$id);
    }
    public function deleteAdmission($id=null) {
        $data = [
            'studisdel' => '1',
        ];

        $this->studentsModel->where('studid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Application is deleted!', 2);
        return redirect()->to(base_url()."admission");
    }
    public function processAdmission($id=null) {
        if($this->request->is('post')) {
            // STUDENT RECORDS
            $irreg = $this->request->getVar('irreg');
            if($irreg == '') {
                $IRREG = 0;
            } else {
                $IRREG = 1;
            }
            $schoolrecorddata = [
                'srstudid' => $id,
                'srsy' => $this->request->getVar('schoolyear'),
                'srsem' => $this->request->getVar('semester'),
                'srlevel' => $this->request->getVar('level'),
                'srirregular' => $IRREG,
                'srcourseid' => $this->request->getVar('course'),
                'srmajor' => $this->request->getVar('major'),
                'srstatus' => $this->request->getVar('status'),
            ];
            $this->srModel->save($schoolrecorddata);
            $findAdmission = $this->srModel->where('srstudid', $id)->findAll();
            foreach($findAdmission as $fA){
                $AdmissionID = $fA['ssrid'];
                $SY = $fA['srsy'];
                $SEM = $fA['srsem'];
                $LEVEL = $fA['srlevel'];
                $COURSE = $fA['srcourseid'];
            }
            // FAMILY BACKGROUND
            $fbdata = [
                'studid' => $id,
                'nfather' => $this->request->getVar('fname'),
                'fmobile' => $this->request->getVar('fcontact'),
                'fwork' => $this->request->getVar('femail'),
                'femail' => $this->request->getVar('fwork'),
                'foffice' => $this->request->getVar('foffice'),
                'nmother' => $this->request->getVar('mname'),
                'mmobile' => $this->request->getVar('mcontact'),
                'mwork' => $this->request->getVar('memail'),
                'memail' => $this->request->getVar('mwork'),
                'moffice' => $this->request->getVar('moffice'),
            ];
            $this->fbModel->save($fbdata);
            $findFB = $this->fbModel->where('studid', $id)->findAll();
            foreach($findFB as $FB){
                $FBID = $FB['fbid'];
            }
            // SAVE STUDENT RECORD ID TO STUDENT TABLE
            $studdata = [
                'studssrid' => $AdmissionID,
                'studsfbid' => $FBID,
            ];
            $this->studentsModel->where('studid', $id)->update($id, $studdata);
            // ENROLLMENT TEMP DATA UPDATE
            $ETDInfo = $this->etdModel->where('studno', $id)->findAll();
            foreach($ETDInfo as $etdi) {
                $ETDID = $etdi['etdid'];
            }
            $data = [
                'sy' => $this->request->getVar('schoolyear'),
                'sem' => $this->request->getVar('semester'),
                'level' => $this->request->getVar('level'),
                'course' => $this->request->getVar('course'),
                'status' => 'Admitted',
            ];
            
            $this->etdModel->where('etdid', $ETDID)->update($ETDID, $data);
            session()->setTempdata('updatesuccess', 'Admission Process Successful!', 2);
            return redirect()->to(base_url()."admission");
            // print_r($StudentNumber);
        }
    }
    public function assessment() {
        $data = [
            'page_title' => 'Holy Cross College | Assessment',
            'page_heading' => 'ASSESSMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['schoolyear'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semester'] = $this->semModel->where('semisdel', 0)->findAll();
        $data['level'] = $this->levelsModel->where('levelisdel', 0)->findAll();
        $data['course'] = $this->coursesModel->where('courisdel', 0)->findAll();

        if($this->request->is('post')) {
            $searchStudent = $this->request->getVar('searchstud');

            if($searchStudent == ''){
                $StudentsCondition = array('isdel' => 0);
                // $data['resultStudent'] = $this->studentsModel->where($StudentsCondition)->findAll(); //OLD SYNTAX
                $data['resultStudent'] = $this->etdModel->where($StudentsCondition); //NEW SYNTAX
                return view('assessmentviewresult', $data);
            }
            else{
                $StudentsCondition = array('isdel' => 0, 'status' => 'Admitted');
                // $data['resultStudent'] = $this->studentsModel->where($StudentsCondition)
                // ->like('studentno', $searchStudent)
                // ->orLike('studln', $searchStudent)
                // ->orLike('studfn', $searchStudent)
                // ->orLike('studfullname', $searchStudent)
                // ->findAll(); //OLD SYNTAX
                $data['resultStudent'] = $this->etdModel
                    ->select('enrollmenttempdata.*, students.*')
                    ->join('students', 'students.studid = enrollmenttempdata.studno')
                    ->where($StudentsCondition)
                    ->groupStart()
                        ->like('students.studentno', $searchStudent)
                        ->orLike('enrollmenttempdata.fullname', $searchStudent)
                    ->groupEnd()
                    ->findAll();
                return view('assessmentviewresult', $data);
            }
        }

        return view('assessmentview', $data);
    }
    public function assessmentProcess($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | Assessment',
            'page_heading' => 'ASSESSMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['schoolyear'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semester'] = $this->semModel->where('semisdel', 0)->findAll();
        $data['level'] = $this->levelsModel->where('levelisdel', 0)->findAll();
        $data['course'] = $this->coursesModel->where('courisdel', 0)->findAll();
        $data['curriculums'] = $this->curriModel->where('isdel', 0)->findAll();
        $data['studcurriculums'] = $this->studcurriModel->where('studentno', $id)->findAll();
        
        $data['students'] = $this->studentsModel->where('studid', $id)->findAll();
        // $data['schoolrecord'] = $this->srModel->where('srstudid', $id)->findAll();

        $data['etddata'] = $this->etdModel->where('studno', $id)->where('status', 'Admitted')->findAll();

        $data['assessment'] = $this->assModel->where('studentno', $id)->findAll();

        $ETDData = $this->etdModel->where('studno', $id)->findAll();
        foreach($ETDData as $etdd) {
            $ETDSY = $etdd['sy'];
            $ETDSEM = $etdd['sem'];
            $ETDLEVEL = $etdd['level'];
            $ETDCOURSE = $etdd['course'];
        }
        $data['sectiondata'] = $this->sectionsModel->where('seccourid', $ETDCOURSE)
        ->where('seclevelid', $ETDLEVEL)->where('secsemid', $ETDSEM)->where('secsyid', $ETDSY)->findAll();

        return view('assessmentviewprocess', $data);
    }
    public function assessmentProcess2($id=null) {
        if($this->request->is('post')) {
            $SY = $this->request->getVar('sy');
            $SEM = $this->request->getVar('sem');
            $COURSE = $this->request->getVar('course');
            $LEVEL = $this->request->getVar('yl');
            $CURRICULUM = $this->request->getVar('curriculum');
            $SECTION = $this->request->getVar('section');

            $assessmentinfo = $this->assModel->where('studentno', $id)
            ->where('sy', $SY)->where('sem', $SEM)->where('course', $COURSE)
            ->where('level', $LEVEL)->findAll();

            if(empty($assessmentinfo)){
                $assessmentdata = [
                    'studentno' => $id,
                    'sy' => $SY,
                    'sem' => $SEM,
                    'level' => $LEVEL,
                    'course' => $COURSE,
                    'curriculum' => $CURRICULUM,
                    'section' => $SECTION,
                    'date' => date('Y-m-d'),
                ];
                // print_r($assessmentdata);
                $this->assModel->save($assessmentdata);
                
                $FindAssessmentId = $this->assModel->where('studentno', $id)->where('sy', $SY)
                ->where('sem', $SEM)->where('level', $LEVEL)->where('course', $COURSE)->findAll();

                foreach($FindAssessmentId as $FAId) {
                    $ASSID = $FAId['assid'];
                    
                }
                
                $CurriculumData = $this->currdataModel->where('curriculumid', $CURRICULUM)
                ->where('level', $LEVEL)->where('sem', $SEM)->findAll();
                
                foreach($CurriculumData as $currdata) {
                    $collegegradesdata = [
                        'studentno' => $id, // change to student no
                        'assid' => $ASSID, // change to assessment id
                        'currid' => $CURRICULUM,
                        'subid' => $currdata['subjectsid'],
                        'section' => $SECTION,
                    ];
                    $this->colgradesModel->save($collegegradesdata);
                    // print_r($asas);
                    
                }
                session()->setTempdata('success', 'Assessment Process Successful!', 2);
                return redirect()->to(base_url()."assessment/process/".$id);
            }
            else{
                session()->setTempdata('processnotsuccess', 'The assessment is already exists.!', 2);
                return redirect()->to(base_url()."assessment/process/".$id);
            }
        }
    }
    public function viewSubjects($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | Assessment',
            'page_heading' => 'ASSESSMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        return view('assessmentviewprocess', $data);
    }
    public function curricullumSet($id=null) {
        if($this->request->is('post')) {
            $data = [
                'studentno' => $id,
                'currid' => $this->request->getVar('curriculum'),
            ];
            $this->studcurriModel->save($data);
            session()->setTempdata('success', 'Creating Curriculum Successful!', 2);
            return redirect()->to(base_url()."assessment/process/".$id);
        }
    }
    public function registrationselect() {
        $data = [
            'page_title' => 'Holy Cross College | Registration',
            'page_heading' => 'REGISTRATION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        return view('registrationselectview', $data);
    }
    public function collegeenrollment() {
        $data = [
            'page_title' => 'Holy Cross College | College Enrollment',
            'page_heading' => 'COLLEGE ENROLLMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['schoolyear'] = $this->syModel->where('syisdel', 0)->where('systatus', 0)->findAll();
        $data['semester'] = $this->semModel->where('semisdel', 0)->where('semstatus', 0)->findAll();
        $data['level'] = $this->levelsModel->where('levelisdel', 0)->findAll();

        $UserData = $this->usersModel->where('uid', $uid)->findAll();
        foreach($UserData as $user) {
            $STUDID = $user['uaccountid'];
        }
        $StudData = $this->studentsModel->where('studentno', $STUDID)->findAll();
        foreach($StudData as $stud) {
            $STUDENTID = $stud['studid'];
            $STUDENTNAME = $stud['studfullname'];
        }
        $SRData = $this->srModel->where('srstudid', $STUDENTID)->findAll();
        foreach($SRData as $sr) {
            $SRCOURSE = $sr['srcourseid'];
        }
        $data['etddata'] = $this->etdModel->where('studno', $STUDENTID)->findAll();
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
            if($this->validate($rules)){
                $SY = $this->request->getVar('schoolyear');
                $SEM = $this->request->getVar('semester');
                $LEVEL = $this->request->getVar('level');
                $CheckEnrollment = $this->etdModel->where('sy', $SY)->where('sem', $SEM)->where('level', $LEVEL)->where('studno', $STUDENTID)->findAll();
                if(empty($CheckEnrollment)) {
                    $etdData = [
                        'studno' => $STUDENTID,
                        'fullname' => $STUDENTNAME,
                        'sy' => $SY,
                        'sem' => $SEM,
                        'level' => $LEVEL,
                        'course' => $SRCOURSE,
                        'status' => 'Registered',
                        'date' => date('Y-m-d'),
                    ];
                    $this->etdModel->save($etdData);
                    session()->setTempdata('success', 'You have successfully registered for the school year '.$SY.' , semester '.$SEM.' and year level '.$LEVEL.' .', 3);
                    return redirect()->to(current_url());
                } else {
                    session()->setTempdata('error', 'You are already registered in this school year, semester and year level.', 3);
                    return redirect()->to(current_url());
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('collegeenrollment', $data);
    }
    public function oldstudent() {
        $data = [
            'page_title' => 'Holy Cross College | Admission',
            'page_heading' => 'ADMISSION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['etddata'] = $this->etdModel->where('status', 'Registered')
        ->where('sy !=', '')->where('sem !=', '')->where('level !=', '')->findAll();
        foreach($data['etddata'] as $etdd) {
            $ETDSTUDID = $etdd['studno'];
        }

        $data['schoolyear'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semester'] = $this->semModel->where('semisdel', 0)->findAll();
        $data['level'] = $this->levelsModel->where('levelisdel', 0)->findAll();
        $data['course'] = $this->coursesModel->where('courisdel', 0)->findAll();

        $data['studentinfo'] = $this->studentsModel->findAll();
        $data['schoolrecord'] = $this->srModel->findAll();
        
        
        return view('registeroldstudent', $data);
    }
    public function oldstudentprocess($id=null) {
        $ETDData = $this->etdModel->where('etdid', $id)->findAll();
        foreach($ETDData as $etdd) {
            $ETDSTUDID = $etdd['studno'];
        }
        $SRData = $this->srModel->where('srstudid', $ETDSTUDID)->findAll();
        foreach($SRData as $sr) {
            $STUDENTSR = $sr['ssrid'];
        }
        if($this->request->is('post')) {
            $irreg = $this->request->getVar('irreg');
            if($irreg == '') {
                $IRREG = 0;
            } else {
                $IRREG = 1;
            }
            $schoolrecorddata = [
                'srsy' => $this->request->getVar('schoolyear'),
                'srsem' => $this->request->getVar('semester'),
                'srlevel' => $this->request->getVar('level'),
                'srirregular' => $IRREG,
                'srcourseid' => $this->request->getVar('course'),
                'srmajor' => $this->request->getVar('major'),
                'srstatus' => $this->request->getVar('status'),
            ];
            $this->srModel->where('ssrid', $STUDENTSR)->update($STUDENTSR, $schoolrecorddata);
            $etdData = [
                'sy' => $this->request->getVar('schoolyear'),
                'sem' => $this->request->getVar('semester'),
                'level' => $this->request->getVar('level'),
                'course' => $this->request->getVar('course'),
                'date' => date('Y-m-d'),
                'status' => 'Admitted',
            ];
            $this->etdModel->where('etdid', $id)->update($id, $etdData);
            session()->setTempdata('updatesuccess', 'Admission Process Successful!', 2);
            return redirect()->to(base_url()."register-oldstudent");
        }
    }
}