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
use App\Models\SubjectsModel;
use App\Models\SchedulesModel;
use App\Models\RatesModel;
use App\Models\RateOtherFeesModel;
use App\Models\RateDuesModel;
use App\Models\RoomsModel;
use TCPDF;
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
    public $subjectsModel;
    public $schedulesModel;
    public $rofModel;
    public $ratesModel;
    public $rateDuesModel;
    public $roomsModel;
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
        $this->subjectsModel = new SubjectsModel();
        $this->schedulesModel = new SchedulesModel();
        $this->ratesModel = new RatesModel();
        $this->rofModel = new RateOtherFeesModel();
        $this->rateDuesModel = new RateDuesModel();
        $this->roomsModel = new RoomsModel();
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
            'page_title' => 'Holy Cross College | Advising',
            'page_heading' => 'ADVISING! ',
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
        $data['studentinfo'] = $this->studentsModel->findAll();

        if($this->request->is('post')) {
            $searchStudent = $this->request->getVar('searchstud');

            if($searchStudent == ''){
                $StudentsCondition = array('status' => 'Admitted');
                // $data['resultStudent'] = $this->studentsModel->where($StudentsCondition)->findAll(); //OLD SYNTAX
                $data['resultStudent'] = $this->etdModel->where($StudentsCondition)->findAll(); //NEW SYNTAX
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
            'page_title' => 'Holy Cross College | Advising',
            'page_heading' => 'ADVISING! ',
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
        
        $data['studcurriculums'] = $this->studcurriModel->where('studentno', $id)->findAll();
        
        $data['students'] = $this->studentsModel->where('studid', $id)->findAll();
        // $data['schoolrecord'] = $this->srModel->where('srstudid', $id)->findAll();

        $data['etddata'] = $this->etdModel->where('studno', $id)->where('status', 'Admitted')->findAll();

        $ETDData = $this->etdModel->where('studno', $id)->where('status', 'Admitted')->findAll();
        foreach($ETDData as $etdd) {
            $ETDSTUDNO = $etdd['studno'];
            $ETDSY = $etdd['sy'];
            $ETDSEM = $etdd['sem'];
            $ETDLEVEL = $etdd['level'];
            $ETDCOURSE = $etdd['course'];
        }
        $COURSEData = $this->coursesModel->where('courid', $ETDCOURSE)->findAll();
        foreach($COURSEData as $courd) {
            $COURCODE = $courd['courcode'];
        }
        $data['curriculums'] = $this->curriModel->where('course', $COURCODE)->findAll();

        $data['sectiondata'] = $this->sectionsModel->where('seccourid', $ETDCOURSE)
        ->where('seclevelid', $ETDLEVEL)->where('secsemid', $ETDSEM)->where('secsyid', $ETDSY)->findAll();

        $data['assessment'] = $this->assModel->where('studentno', $ETDSTUDNO)
        ->where('sy', $ETDSY)->where('sem', $ETDSEM)->where('level', $ETDLEVEL)->where('course', $ETDCOURSE)->findAll();

        $data['studdata'] = $this->studentsModel->findAll();
        $data['curriculumdata'] = $this->curriModel->findAll();
        $data['secdata'] = $this->sectionsModel->findAll();

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
            'page_title' => 'Holy Cross College | Advising',
            'page_heading' => 'ADVISING! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['assessment'] = $this->assModel->where('assid', $id)->findAll();
        $data['studdata'] = $this->studentsModel->findAll();
        $data['course'] = $this->coursesModel->findAll();
        $data['curriculumdata'] = $this->curriModel->findAll();
        $data['secdata'] = $this->sectionsModel->findAll();
        $data['subdata'] = $this->subjectsModel->findAll();
        $data['scheddata'] = $this->schedulesModel->findAll();
        $data['colgradesdata'] = $this->colgradesModel->where('assid', $id)->findAll();
        $assData= $this->assModel->where('assid', $id)->findAll();
        foreach($assData as $ass) {
            $SY = $ass['sy'];
            $SEM = $ass['sem'];
            $LEVEL = $ass['level'];
            $COURSE = $ass['course'];
        }
        $courdata = $this->coursesModel->where('courid', $COURSE)->findAll();
        foreach($courdata as $cd) {
            $COURSECODE = $cd['courcode'];
        }
        $ratesData = $this->ratesModel
        ->where('sy', $SY)
        ->where('sem', $SEM)
        ->where('year', $LEVEL)
        ->where('course', $COURSECODE)->findAll();
        foreach($ratesData as $ratesD) {
            $RATESID = $ratesD['rateid'];
        }
        $data['rofdata'] = $this->rofModel->where('rateid', $RATESID)->findAll();
        $data['ratesdata'] = $this->ratesModel->where('rateid', $RATESID)->findAll();

        $data['totalotherfees'] = $this->rofModel->select('
            SUM(rateotherfees.otherfees) as totalrof
            ')->join('rates', 'rates.rateid = rateotherfees.rateid')
            ->where('rates.rateid', $RATESID)
            ->findAll();
        $data['totalminorunits'] = $this->colgradesModel->select('
            SUM(subjects.units) as totalminorunits
            ')->join('subjects', 'subjects.subid = collegegrades.subid')
            ->where('collegegrades.assid', $id)
            ->where('subjects.major', 0)
            ->where('subjects.subcode !=', "NSTP01")
            ->where('subjects.subcode !=', "NSTP02")
            ->findAll();
        $data['totalmajorunits'] = $this->colgradesModel->select('
            SUM(subjects.units) as totalmajorunits
            ')->join('subjects', 'subjects.subid = collegegrades.subid')
            ->where('collegegrades.assid', $id)
            ->where('subjects.major', 1)
            ->where('subjects.subcode !=', "NSTP01")
            ->where('subjects.subcode !=', "NSTP02")
            ->findAll();
        $data['totalmajorhours'] = $this->colgradesModel->select('
            SUM(subjects.hours) as totalmajorhours
            ')->join('subjects', 'subjects.subid = collegegrades.subid')
            ->where('collegegrades.assid', $id)
            ->where('subjects.major', 1)
            ->where('subjects.subcode !=', "NSTP01")
            ->where('subjects.subcode !=', "NSTP02")
            ->findAll();
        $data['totalminorhours'] = $this->colgradesModel->select('
            SUM(subjects.hours) as totalminorhours
            ')->join('subjects', 'subjects.subid = collegegrades.subid')
            ->where('collegegrades.assid', $id)
            ->where('subjects.subcode !=', "NSTP01")
            ->where('subjects.subcode !=', "NSTP02")
            ->where('subjects.major', 0)
            ->findAll();

        return view('assessmentviewsubject', $data);
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
    public function assessmentFinalize($id=null) {
        $findAssessment = $this->assModel->where('studentno', $id)->findAll();
        foreach($findAssessment as $fa) {
            $ASSID = $fa['assid'];
        }
        $assData = [
            'status' => 'Finalized',
        ];
        $this->assModel->where('assid', $ASSID)->update($ASSID, $assData);
        $findETD = $this->etdModel->where('studno', $id)->findAll();
        foreach($findETD as $fetd) {
            $ETDID = $fetd['etdid'];
        }
        $etdData = [
            'status' => 'Advised',
        ];
        $this->etdModel->where('etdid', $ETDID)->update($ETDID, $etdData);
        session()->setTempdata('activatesuccess', 'Assessment Finalize Successful!', 2);
        return redirect()->to(base_url()."assessment");
    
    }
    public function assessmentCOR() {
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
        $data['etddata'] = $this->etdModel->where('status', 'Advised')->findAll();
        $data['studentinfo'] = $this->studentsModel->findAll();
        $data['course'] = $this->coursesModel->findAll();

        if($this->request->is('post')) {
            $searchStudent = $this->request->getVar('searchstud');

            if($searchStudent == ''){
                $StudentsCondition = array('status' => 'Advised');
                $data['etddata'] = $this->etdModel->where($StudentsCondition)->findAll();
                return view('assessmentcorview', $data);
            }
            else{
                $StudentsCondition = array('isdel' => 0, 'status' => 'Advised');
                $data['etddata'] = $this->etdModel
                    ->select('enrollmenttempdata.*, students.*')
                    ->join('students', 'students.studid = enrollmenttempdata.studno')
                    ->where($StudentsCondition)
                    ->groupStart()
                        ->like('students.studentno', $searchStudent)
                        ->orLike('enrollmenttempdata.fullname', $searchStudent)
                    ->groupEnd()
                    ->findAll();
                return view('assessmentcorview', $data);
            }
        }

        return view('assessmentcorview', $data);
    }
    public function assessmentCORview($id=null) {
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
        $data['studentinfo'] = $this->studentsModel->findAll();
        $data['course'] = $this->coursesModel->findAll();
        $data['section'] = $this->sectionsModel->findAll();
        $data['ETDData'] = $this->etdModel->where('etdid', $id)->findAll();
        $ETDData = $this->etdModel->where('etdid', $id)->findAll();
        foreach ($ETDData as $etd) {
            $ETDStudno = $etd['studno'];
        }
        $data['assessment'] = $this->assModel->where('studentno', $ETDStudno)
        ->where('status', 'Finalized')->findAll();
        foreach($data['assessment'] as $ass) {
            $ASSID = $ass['assid'];
            $SECTION = $ass['section'];
            $SY = $ass['sy'];
            $SEM = $ass['sem'];
            $LEVEL = $ass['level'];
            $COURSE = $ass['course'];
        }
        $data['students'] = $this->studentsModel->where('studid', $ETDStudno)->findAll();
        $data['colgradesdata'] = $this->colgradesModel->where('assid', $ASSID)->findAll();
        $data['subject'] = $this->subjectsModel->findAll();
        $data['schedule'] = $this->schedulesModel->findAll();
        $COURSEData = $this->coursesModel->where('courid', $COURSE)->findAll();
        foreach($COURSEData as $courd) {    
            $COURCODE = $courd['courcode'];
        }
        $ratesData = $this->ratesModel
        ->where('sy', $SY)
        ->where('sem', $SEM)
        ->where('year', $LEVEL)
        ->where('course', $COURCODE)->findAll();
        foreach($ratesData as $ratesD) {
            $RATESID = $ratesD['rateid'];
        }
        $data['rofdata'] = $this->rofModel->where('rateid', $RATESID)->findAll();
        $data['duedata'] = $this->rateDuesModel->where('rateid', $RATESID)->findAll();
        

        return view('assessmentcorresultview', $data);
    }
    public function assessmentCORprint($id=null) {
        
        // Load TCPDF library
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        

        $pdf->SetAuthor('TRS Department');
        $pdf->SetTitle('Certificate of Registration');

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

        // HEADER
        $imagePath = FCPATH .'public/uploads/hccheader.png';
        $pdf->Image($imagePath, $x = 5, $y = 0, $w = 206, $h = 36); 
        $pdf->Line(5, 37, 211, 37);

        $db = \Config\Database::connect();
        $studinfo = $db->query("SELECT * FROM enrollmenttempdata WHERE etdid = '$id'");
        $studresult = $studinfo->getRow(0);
        $etdData = $this->etdModel->where('etdid', $id)->findAll();
        foreach ($etdData as $etd) {
            $ETDStudno = $etd['studno'];
        }
        $assessData = $this->assModel->where('studentno', $ETDStudno)
        ->where('status', 'Finalized')->findAll();
        foreach($assessData as $ass) {
            $ASSID = $ass['assid'];
            $SECTION = $ass['section'];
            $SY = $ass['sy'];
            $SEM = $ass['sem'];
            $LEVEL = $ass['level'];
            $COURSE = $ass['course'];
            $CURRICULUM = $ass['curriculum'];
        }
        $studData = $this->studentsModel->where('studid', $ETDStudno)->findAll();
        foreach($studData as $sd) {
            $STUDENTNO = $sd['studentno'];
            $BARANGAY = $sd['studstbarangay'];
            $MUNICIPALITY = $sd['studcity'];
            $PROVINCE = $sd['studprovince'];
            $ADDRESS = $BARANGAY .' '. $MUNICIPALITY .', '. $PROVINCE;
        }
        $courData = $this->coursesModel->where('courid', $COURSE)->findAll();
        foreach($courData as $cd) {
            $COURSECODE = $cd['courcode'];
            $COURSE = $cd['course'];
        }
        $sectionData = $this->sectionsModel->where('secid', $SECTION)->findAll();
        foreach($sectionData as $sec) {
            $SECTION = $sec['section'];
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
                    <td style="background-color: #b5b5b5; font-size: 25px; font-weight: bold; text-align: center;">CERTIFICATE OF REGISTRATION</td>
                </tr>
            </table><br><br>

            <table>
                <tr>
                    <td style="width: 65%;">STUDENT No.: '. $STUDENTNO .' </td>
                    <td>SCHOOL YEAR: '. $studresult->sy .'</td>
                </tr>
                <tr>
                    <td>STUDENT: <strong>'. strtoupper($studresult->fullname) .'</strong></td>
                    <td>SEMESTER: '. $studresult->sem .'</td>
                </tr>
                <tr>
                    <td>COURSE: '. strtoupper($COURSE) .'</td>
                    <td>LEVEL: '. $studresult->level .'</td>
                </tr>
                <tr>
                    <td>ADDRESS: '. strtoupper($ADDRESS) .'</td>
                    <td>SECTION: '. $SECTION .'</td>
                </tr>
            </table><br><br>

            <table border="1" style="width: 100%; font-size: 11px;">
                <thead>
                    <tr>
                        <th style="width: 10%;text-align: center;">CODE</th>
                        <th style="width: 40%;text-align: center;">SUBJECT</th>
                        <th style="width: 7%;text-align: center;">UNIT</th>
                        <th style="width: 7%;text-align: center;">HOUR</th>
                        <th style="width: 26%;text-align: center;">SCHEDULE</th>
                        <th style="width: 10%;text-align: center;">ROOM</th>
                    </tr>
                </thead>
                <tbody>
        ';
        $colgradesData = $this->colgradesModel->where('assid', $ASSID)->findAll();
        foreach($colgradesData as $colgrade){
            $subjectData = $this->subjectsModel->where('subid', $colgrade['subid'])->findAll();
            foreach($subjectData as $subd) {
                $SUBCODE = $subd['subcode'];
                $SUBJECT = $subd['subject'];
                $UNIT = $subd['units'];
                $UNITFORMATED =  number_format($UNIT, 2);
                $HOUR = $subd['hours'];
                $HOURFORMATED =  number_format($HOUR, 2);
            }
            $schedData = $this->schedulesModel->where('schedsecid', $colgrade['section'])->where('schedsubid', $colgrade['subid'])->findAll();
            foreach($schedData as $sched){
                if($sched['schedtimeF2'] == '' || $sched['schedtimeF2'] == '00:00:00') {
                    $TIMEF = date('h:i A', strtotime($sched['schedtimeF']));
                    $TIMET = date('h:i A', strtotime($sched['schedtimeT']));
                    $DAY = substr($sched['schedday'], 0, 3);
                    $SCHEDULE = $TIMEF . ' - ' . $TIMET . '  ' . $DAY;
                } else {
                    $TIMEF = date('h:i A', strtotime($sched['schedtimeF']));
                    $TIMET = date('h:i A', strtotime($sched['schedtimeT']));
                    $TIMEF2 = date('h:i A', strtotime($sched['schedtimeF2']));
                    $TIMET2 = date('h:i A', strtotime($sched['schedtimeT2']));
                    $DAY1 = substr($sched['schedday'], 0, 3);
                    $DAY2 = substr($sched['schedday2'], 0, 3);
                    $SCHEDULE = $TIMEF . ' - ' . $TIMET . ' ' . $DAY1 . '<br>' .$TIMEF2 . ' - ' . $TIMET2 . '  ' . $DAY2;
                }
                $SCHEDROOM = $sched['schedroom'];
            }
            $roomData = $this->roomsModel->where('roomid', $SCHEDROOM)->findAll();
            foreach($roomData as $rd) {
                $ROOM = $rd['roomcode'];
            }
            $html .= '<tr>
                    <td style="width: 10%; text-align: center;">'.$SUBCODE.'</td>
                    <td style="width: 40%; text-align: left">'.$SUBJECT.' </td>
                    <td style="width: 7%; text-align: center;">'.$UNITFORMATED.'</td>
                    <td style="width: 7%; text-align: center;">'.$HOURFORMATED.'</td>
                    <td style="width: 26%; text-align: center;">'.$SCHEDULE.'</td>
                    <td style="width: 10%; text-align: center;">'.$ROOM.'</td>

                </tr>';
        }
        // GET TOTAL UNITS
        $gettotalunits = $db->query("SELECT subjectsid, SUM(units) AS TOTALUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '1st Semester' AND curriculumid = ".$CURRICULUM);
        $result = $gettotalunits->getRow(0);
        $TOTALUNITS = $result->TOTALUNITS;
        $TOTALUNITSFORMATED = number_format($TOTALUNITS, 2);
        // GET TOTAL HOURS
        $gettotalhours = $db->query("SELECT subjectsid, SUM(hours) AS TOTALHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '1st Semester' AND curriculumid = ".$CURRICULUM);
        $result = $gettotalhours->getRow(0);
        $TOTALHOURS = $result->TOTALHOURS;
        $TOTALHOURSSFORMATED = number_format($TOTALHOURS, 2);
        $html .= '<tr>
                <td style="width: 50%; text-align: right;"><strong>TOTAL</strong></td>
                <td style="width: 7%; text-align: center"><strong>'.$TOTALUNITSFORMATED.'</strong></td>
                <td style="width: 7%; text-align: center;"><strong>'.$TOTALHOURSSFORMATED.'</strong></td>
                <td style="width: 26%; text-align: center;"></td>
                <td style="width: 10%; text-align: center;"></td>
            </tr>';

        $html .= ' </tbody>
            </table><br><br>';
        $html .= '<table>
                <tr>
                    <td style="width: 100%; font-size: 14px; text-align: center;"><strong>A D M I S S I O N &nbsp; F O R M</strong></td>
                </tr>   
            </table><br><br>';
        $html .= '<table>
                <tr>
                    <td style="width: 100%; text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;This is to certify that <strong>'. strtoupper($studresult->fullname) .'</strong> is cleared and enrolled for SY <strong>'. $studresult->sy .'</strong>, <strong>'. $studresult->sem .'</strong> for <strong>'. strtoupper($COURSE) .'</strong>, <strong>'. $studresult->level .'</strong> level.</td>
                </tr>   
            </table><br><br>';
        $html .= '<table>
                <tr>
                    <td style="width: 100%; font-size: 14px; text-align: center;"><strong>A S S E S S M E N T &nbsp; O F &nbsp; F E E S</strong></td>
                </tr>   
            </table><br>';
        // GET TOTAL UNITS MAJOR
        $gettotalmajorunits = $db->query("SELECT subjectsid, major, SUM(units) AS TOTALMAJORUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '1st Semester' AND major = '1' AND curriculumid = ".$CURRICULUM);
        $result = $gettotalmajorunits->getRow(0);
        $TOTALMAJOR = $result->TOTALMAJORUNITS;
        $TOTALMAJORFORMATED = number_format($TOTALMAJOR, 2);
        if(empty($TOTALMAJORFORMATED)){
            $MAJOR = "-";
        } else {
            $MAJOR = $TOTALMAJORFORMATED;
        }
        // GET TOTAL HOURS MAJOR
        $gettotalmajorhours = $db->query("SELECT subjectsid, major, SUM(hours) AS TOTALMAJORHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '1st Semester' AND major = '1' AND subcode != 'NSTP01' AND subcode != 'NSTP02' AND curriculumid = ".$CURRICULUM);
        $result = $gettotalmajorhours->getRow(0);
        $TOTALMAJORHOURS = $result->TOTALMAJORHOURS;
        $TOTALMAJORHOURSFORMATED = number_format($TOTALMAJORHOURS, 2);
        if(empty($TOTALMAJORHOURSFORMATED)){
            $MAJORHOURS = "-";
        } else {
            $MAJORHOURS = $TOTALMAJORHOURSFORMATED;
        }
        // GET TOTAL UNITS MINOR
        $gettotalminorunits = $db->query("SELECT subjectsid, major, subcode, SUM(units) AS TOTALMINORUNITS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '1st Semester' AND major = '0' AND subcode != 'NSTP01' AND subcode != 'NSTP02' AND curriculumid = ".$CURRICULUM);
        $result = $gettotalminorunits->getRow(0);
        $TOTALMINORUNITS = $result->TOTALMINORUNITS;
        $TOTALMAJORFORMATED = number_format($TOTALMINORUNITS, 2);
        if(empty($TOTALMAJORFORMATED)){
            $MINOR = "-";
        } else {
            $MINOR = $TOTALMAJORFORMATED;
        }
        // GET TOTAL HOURS MINOR
        $gettotalminorhours = $db->query("SELECT subjectsid, major, subcode, SUM(hours) AS TOTALMINORHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '1st Semester' AND major = '0' AND subcode != 'NSTP01' AND subcode != 'NSTP02' AND curriculumid = ".$CURRICULUM);
        $result = $gettotalminorhours->getRow(0);
        $TOTALMINORHOURS = $result->TOTALMINORHOURS;
        $TOTALMINORHOURSFORMATED = number_format($TOTALMINORHOURS, 2);
        if(empty($TOTALMINORHOURSFORMATED)){
            $MINORHOURS = "-";
        } else {
            $MINORHOURS = $TOTALMINORHOURSFORMATED;
        }
        // GET RATE
        $rateDataCondition = array('sy' => $SY, 'sem' => $SEM, 'course' => $COURSECODE, 'year' => $LEVEL);
        $rateData = $this->ratesModel->where($rateDataCondition)->findAll();
        foreach($rateData as $rd) {
            $RATESID = $rd['rateid'];
            $RATEMAJOR = $rd['major'];
            $RATEMINOR = $rd['minor'];
            $RATENSTP1 = $rd['nstp01'];
            $RATENSTP2 = $rd['nstp02'];
            if($RATENSTP2 == '0.00'){
                $NSTP = $RATENSTP1;
            }else{
                $NSTP = $RATENSTP2;
            }
        }
        //MAJOR COMPUTATION
        $MAJORAMOUNT = $RATEMAJOR * $MAJORHOURS;
        //MINOR COMPUTATION
        $MINORAMOUNT = $RATEMINOR * $MINORHOURS;
        //TOTAL TUITION FEE
        $TOTALTUITIONFEE = $MAJORAMOUNT + $MINORAMOUNT + $NSTP;
        // GET TOTAL HOURS
        $gettotalhours = $db->query("SELECT subjectsid, SUM(hours) AS TOTALHOURS FROM currdata LEFT JOIN subjects ON subjectsid = subid WHERE level = '1st Year' AND sem = '1st Semester' AND curriculumid = ".$CURRICULUM);
        $result = $gettotalhours->getRow(0);
        $TOTALHOURS = $result->TOTALHOURS;
        $TOTALHOURSSFORMATED = number_format($TOTALHOURS, 2);

        $gettotalrof = $db->query("SELECT rateid, SUM(otherfees) AS TOTALROFFEES FROM rateotherfees WHERE rateid =".$RATESID);
        $result = $gettotalrof->getRow(0);
        $TOTALROF = $result->TOTALROFFEES;
        $TOTALROFFORMATED = number_format($TOTALROF, 2);

        //GRAND TOTAL TUITION FEE
        $GRANDTOTAL = $TOTALTUITIONFEE + $TOTALROF;
        $GRANDTOTALFORMATED = number_format($GRANDTOTAL, 2);

        $html .= '<table style="width: 100%;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <table border="1" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="width: 30%; text-align: left;">Tuition Fees</td>
                                    <td style="width: 14%; text-align: center;">Subject</td>
                                    <td style="width: 12%; text-align: center;">Unit</td>
                                    <td style="width: 12%; text-align: center;">Hours</td>
                                    <td style="width: 14%; text-align: center;">Rate</td>
                                    <td style="width: 18%; text-align: center;">Amount</td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; text-align: left;">Regular Subjects</td>
                                    <td style="width: 14%; text-align: left;">Major</td>
                                    <td style="width: 12%; text-align: right;">'. $MAJOR .'</td>
                                    <td style="width: 12%; text-align: right;">'. $MAJORHOURS .'</td>
                                    <td style="width: 14%; text-align: right;">'. number_format($RATEMAJOR, 2) .'</td>
                                    <td style="width: 18%; text-align: right;">'. number_format($MAJORAMOUNT,2) .'</td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; text-align: left;">Regular Subjects</td>
                                    <td style="width: 14%; text-align: left;">Minor</td>
                                    <td style="width: 12%; text-align: right;">'. $MINOR .'</td>
                                    <td style="width: 12%; text-align: right;">'. $MINORHOURS .'</td>
                                    <td style="width: 14%; text-align: right;">'. number_format($RATEMINOR, 2) .'</td>
                                    <td style="width: 18%; text-align: right;">'. number_format($MINORAMOUNT,2) .'</td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; text-align: left;">Fixed Amount</td>
                                    <td style="width: 14%; text-align: left;">NSTP</td>
                                    <td style="width: 12%; text-align: center;">3.00</td>
                                    <td style="width: 12%; text-align: center;">3.00</td>
                                    <td style="width: 14%; text-align: center;">0.00</td>
                                    <td style="width: 18%; text-align: right;">'. number_format($NSTP,2) .'</td>
                                </tr>
                                <tr>
                                    <td style="width: 82%; text-align: left;">Total Tuition Fees</td>
                                    <td style="width: 18%; text-align: right;">'. number_format($TOTALTUITIONFEE,2) .'</td>
                                </tr>
                                <tr>
                                    <td style="width: 82%; text-align: left;">Less Discount(0.00%)</td>
                                    <td style="width: 18%; text-align: right;">-</td>
                                </tr>
                                <tr>
                                    <td style="width: 82%; text-align: left;"><strong>TUITION FEES - NET</strong></td>
                                    <td style="width: 18%; text-align: right;"><strong>'. number_format($TOTALTUITIONFEE,2) .'</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <p style="font-size: 11px">I promise to pay my tuition and other fees based on the installment schedule below:</p>
                        <table border="1" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="width: 70%; text-align: left;">Due Date</td>
                                    <td style="width: 30%; text-align: center;">Amount</td>
                                </tr>';
                        $DUEDATE = $this->rateDuesModel->where('rateid', $RATESID)->findAll();
                        $COUNTDUEDATE = $this->rateDuesModel->where('rateid', $RATESID)->countAllResults();
                        $DUEAMOUNT = $GRANDTOTAL / $COUNTDUEDATE;
                        $DUEAMOUNTFORMATTED = number_format($DUEAMOUNT,2);
                        foreach($DUEDATE as $duedate){
                            $html .='<tr>
                                    <td style="width: 70%; text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;'. date("F j, Y", strtotime($duedate['due'])) .'</td>
                                    <td style="width: 30%; text-align: center;">'. $DUEAMOUNTFORMATTED .'</td>
                                </tr>';
                        }
                $html .= '  </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; vertical-align: top;">
                        <table  style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="width: 100%; text-align: left; font-size: 12px;"><strong>OTHER FEES:</strong></td>
                                </tr>
                                <tr>
                                    <td style="width: 100%; text-align: left; font-size: 10px;">PARTICULARS</td>
                                </tr>';
                        $ROFData = $this->rofModel->where('rateid', $RATESID)->findAll();
                        foreach($ROFData as $rof) {
                            $html .='<tr>
                                        <td style="width: 80%; text-align: left; font-size: 10px;">'. $rof['name'] .'</td>
                                        <td style="width: 20%; text-align: right; font-size: 10px;">'. number_format($rof['otherfees'], 2) .'</td>
                                    </tr>';
                            }
                
                $html .='
                                <tr>
                                        <td style="width: 80%; text-align: right; font-size: 10px;">TOTAL OTHER FEES</td>
                                        <td style="width: 20%; text-align: right; font-size: 10px;">'. $TOTALROFFORMATED .'</td>
                                    </tr>
                                <tr>
                                    <td style="width: 80%; text-align: right; font-size: 10px;">GRAND TOTAL</td>
                                    <td style="width: 20%; text-align: right; font-size: 10px;"><strong>'. $GRANDTOTALFORMATED .'</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <br>
            <br>
            ';

            $html .= '<table style="width: 100%;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="width: 70%; text-align: left; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 70%; text-align: left;"><p style="font-size: 10px;">SIGNATURE OVER STUDENTS PRINTED NAME</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; vertical-align: top;">
                        <table  style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center;"><p style="font-size: 12px;">REGISTRAR</p></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <br>
                        <table  style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center;"><p style="font-size: 12px;">CASHIER</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
            <br>';
        
        $html .='
            <table>
                <tbody>
                    <tr>
                        <td style="text-align: center;">
                            <p style="font-size: 6px;">THIS IS NOT OFFICIAL UNLESS SIGNED BY THE REGISTRAR</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        ';
        
        // Output PDF to browser
        $pdf->writeHTML($html, true, false, false, false, '');
        $pdf->Output(strtoupper($studresult->fullname).'.pdf', 'D');
        
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