<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\SYModel;
use App\Models\CoursesModel;
use App\Models\SubjectsModel;
use App\Models\CurriculumsModel;
use App\Models\CurriculumDataModel;
use App\Models\SectionsModel;
use App\Models\RegStudentsModel;
use App\Models\PaymentTransactionsModel;
use App\Models\EnrollmentHistoryCOLModel;
use App\Models\COLStudentsModel;
use App\Models\COLPermanentRecordModel;
use App\Models\COLSchoolRecordModel;
use App\Models\COLFamilyBackgroundModel;
use App\Models\AdditionalInfoCOLModel;
use App\Models\COLAssessmentModel;
use App\Models\StudentSubjectsModel;
use App\Models\RatesModel;
use App\Models\RateOtherFeesModel;
use App\Models\RateDuesModel;
use App\Models\StudentAccountsModel;
use TCPDF;
class COLDepartmentController extends BaseController
{
    public $usersModel;
    public $syModel;
    public $coursesModel;
    public $subjectsModel;
    public $curriculumModel;
    public $curriculumDataModel;
    public $sectionsModel;
    public $regStudentsModel;
    public $paymentTransactionsModel;
    public $enrollmentHistoryCOLModel;
    public $colStudentsModel;
    public $colPermanentRecordModel;
    public $colSchoolRecordModel;
    public $colFamilyBackgroundModel;
    public $additionalInfoCOLModel;
    public $colAssessmentModel;
    public $studentSubjectsModel;
    public $ratesModel;
    public $rateOtherFeesModel;
    public $rateDuesModel;
    public $studentAccountsModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->syModel = new SYModel();
        $this->coursesModel = new CoursesModel();
        $this->subjectsModel = new SubjectsModel();
        $this->curriculumModel = new CurriculumsModel();
        $this->curriculumDataModel = new CurriculumDataModel();
        $this->regStudentsModel = new RegStudentsModel();
        $this->paymentTransactionsModel = new PaymentTransactionsModel();
        $this->enrollmentHistoryCOLModel = new EnrollmentHistoryCOLModel();
        $this->colStudentsModel = new COLStudentsModel();
        $this->colPermanentRecordModel = new COLPermanentRecordModel();
        $this->colSchoolRecordModel = new COLSchoolRecordModel();
        $this->colFamilyBackgroundModel = new COLFamilyBackgroundModel();
        $this->sectionsModel = new SectionsModel();
        $this->additionalInfoCOLModel = new AdditionalInfoCOLModel();
        $this->colAssessmentModel = new COLAssessmentModel();
        $this->studentSubjectsModel = new StudentSubjectsModel();
        $this->ratesModel = new RatesModel();
        $this->rateOtherFeesModel = new RateOtherFeesModel();
        $this->rateDuesModel = new RateDuesModel();
        $this->studentAccountsModel = new StudentAccountsModel();
        $this->session = session();
    }
    public function course(){
        $data = [
            'page_title' => 'Holy Cross College | College Course Management',
            'page_heading' => 'COLLEGE COURSE MANAGEMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['coursedata'] = $this->coursesModel->where('isdel', '0')->findAll();

        if($this->request->is('post')) {
            $rules = [
                'code' => [
                    'rules' => 'required|is_unique[courses.code]',
                    'errors' => [
                        'required' => 'Code is required.',
                        'is_unique' => 'This code is already exists.'
                    ],
                ],
                'course' => [
                    'rules' => 'required|is_unique[courses.name]',
                    'errors' => [
                        'required' => 'Course is required.',
                        'is_unique' => 'This course is already exists.'
                    ],
                ],
            ];
            if($this->validate($rules)){
                $coursesdata = [
                    'code' => $this->request->getVar('code'),
                    'name' => $this->request->getVar('course'),
                ];
                $this->coursesModel->save($coursesdata);
                session()->setTempdata('addsuccess','Course added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('college/coursesview', $data);
    }
    public function deletecourse($id=null) {
        $cludata = [
            'isdel' => '1',
        ];

        $this->coursesModel->where('courid', $id)->update($id, $cludata);
        session()->setTempdata('deletesuccess', 'Course is deleted!', 2);
        return redirect()->to(base_url()."col-course");
    }
    public function updatecourse($id=null) {
        if($this->request->is('post')) {
            $data = [
                'code' => $this->request->getVar('code'),
                'name' => $this->request->getVar('course'),
            ];

            $this->coursesModel->where('courid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."col-course");
        }
    }
    public function subjects(){
        $data = [
            'page_title' => 'Holy Cross College | College Subjects Management',
            'page_heading' => 'COLLEGE SUBJECTS MANAGEMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['subjectsdata'] = $this->subjectsModel->where('isdel', '0')->findAll();

        if($this->request->is('post')) {
            $rules = [
                'subject' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Subject is required.',
                    ],
                ],
                'subcode' => [
                    'rules' => 'required|is_unique[subjects.subcode]',
                    'errors' => [
                        'required' => 'Subject code is required.',
                        'is_unique' => 'This subject code is already exists.'
                    ],
                ],
                'lechours' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Lecture hours is required.',
                    ],
                ],
                'lecunits' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Lecture units is required.',
                    ],
                ],
                'labunits' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Laboratory units is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                $major = $this->request->getVar('major');
                if($major == ''){
                    $MAJOR = 0;
                }else{
                    $MAJOR = 1;
                }
                $subjectdata = [
                    'subject' => $this->request->getVar('subject'),
                    'subcode' => $this->request->getVar('subcode'),
                    'lechours' => $this->request->getVar('lechours'),
                    'labhours' => $this->request->getVar('labhours'),
                    'hours' => $this->request->getVar('lechours') + $this->request->getVar('labhours'),
                    'lecunits' => $this->request->getVar('lecunits'),
                    'labunits' => $this->request->getVar('labunits'),
                    'units' => $this->request->getVar('lecunits') + $this->request->getVar('labunits'),
                    'major' => $MAJOR,
                    'prerequisite' => $this->request->getVar('prerequisite'),
                ];
                $this->subjectsModel->save($subjectdata);
                session()->setTempdata('addsuccess','Subject added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('college/subjectsview', $data);
    }
    public function deletesubjects($id=null) {
        $cludata = [
            'isdel' => '1',
        ];

        $this->subjectsModel->where('subid', $id)->update($id, $cludata);
        session()->setTempdata('deletesuccess', 'Subject is deleted!', 2);
        return redirect()->to(base_url()."col-subjects");
    }
    public function updatesubjects($id=null) {
        if($this->request->is('post')) {
            $major = $this->request->getVar('major');
            if($major == ''){
                $MAJOR = 0;
            }else{
                $MAJOR = 1;
            }
            $data = [
                'subject' => $this->request->getVar('subject'),
                'subcode' => $this->request->getVar('subcode'),
                'lechours' => $this->request->getVar('lechours'),
                'labhours' => $this->request->getVar('labhours'),
                'hours' => $this->request->getVar('lechours') + $this->request->getVar('labhours'),
                'lecunits' => $this->request->getVar('lecunits'),
                'labunits' => $this->request->getVar('labunits'),
                'units' => $this->request->getVar('lecunits') + $this->request->getVar('labunits'),
                'major' => $MAJOR,
                'prerequisite' => $this->request->getVar('prerequisite'),
            ];

            $this->subjectsModel->where('subid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."col-subjects");
        }
    }
    public function curriculum(){
        $data = [
            'page_title' => 'Holy Cross College | College Curriculum Management',
            'page_heading' => 'COLLEGE CURRICULUM MANAGEMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['sydata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['coursedata'] = $this->coursesModel->where('isdel', '0')->findAll();
        $data['curriculumdata'] = $this->curriculumModel
        ->select('curriculum.*, courses.*')
        ->join('courses', 'courses.courid = curriculum.course')
        ->where('curriculum.isdel', '0')->findAll();
        

        if($this->request->is('post')) {
            $rules = [
                'course' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Course is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                $curridata = [
                    'course' => $this->request->getVar('course'),
                    'sy' => $this->request->getVar('sy'),
                ];
                $this->curriculumModel->save($curridata);
                session()->setTempdata('addsuccess','Curriculum added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('college/curriculumview', $data);
    }
    public function deletecurriculum($id=null) {
        $cludata = [
            'isdel' => '1',
        ];

        $this->curriculumModel->where('currid', $id)->update($id, $cludata);
        session()->setTempdata('deletesuccess', 'Curriculum is deleted!', 2);
        return redirect()->to(base_url()."col-curriculum");
    }
    public function updatecurriculum($id=null) {
        if($this->request->is('post')) {
            $data = [
                'course' => $this->request->getVar('course'),
                'sy' => $this->request->getVar('sy'),
            ];

            $this->curriculumModel->where('currid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."col-curriculum");
        }
    }
    public function setupcurriculum($id=null){
        $data = [
            'page_title' => 'Holy Cross College | College Curriculum Setup',
            'page_heading' => 'COLLEGE CURRICULUM SETUP! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['sydata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['coursedata'] = $this->coursesModel->where('isdel', '0')->findAll();
        $data['subjectsdata'] = $this->subjectsModel->where('isdel', '0')->findAll();
        $data['curriculumdata'] = $this->curriculumModel
        ->select('curriculum.*, courses.*')
        ->join('courses', 'courses.courid = curriculum.course')
        ->where('currid', $id)->findAll();
        $data['cddata'] = $this->curriculumDataModel->where('curriculumid', $id)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'subject' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Subject is required.',
                    ],
                ],
                'level' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Level is required.',
                    ],
                ],
                'sem' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Semester is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                $subjectid = $this->request->getVar('subject');
                $FINDSUBJECT = $this->subjectsModel->where('subid', $subjectid)->findAll();
                foreach($FINDSUBJECT as $FINDSUB){
                    $PRERE = $FINDSUB['prerequisite'];
                }
                $data = [
                    'curriculumid' => $id,
                    'subid' => $this->request->getVar('subject'),
                    'level' => $this->request->getVar('level'),
                    'sem' => $this->request->getVar('sem'),
                ];
                $this->curriculumDataModel->save($data);
                session()->setTempdata('addsuccess','Subject added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('college/curriculumsetupview', $data);
    }
    public function sections() {
        $data = [
            'page_title' => 'Holy Cross College | College Sections Setup',
            'page_heading' => 'COLLEGE SECTIONS SETUP! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['sydata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['coursedata'] = $this->coursesModel->where('isdel', '0')->findAll();
        $data['sectiondata'] = $this->sectionsModel
        ->select('sections.*, courses.*')
        ->join('courses', 'courses.courid = sections.course')
        ->where('sections.isdel', '0')->findAll();

        if($this->request->is('post')) {
            $rules = [
                'section' => [
                    'rules' => 'required|is_unique[sections.section]',
                    'errors' => [
                        'required' => 'Section is required.',
                        'is_unique' => 'This section is already exists.'
                    ],
                ],
                'sy' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'School year is required.',
                    ],
                ],
                'course' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Course is required.',
                    ],
                ],
                'level' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Level is required.',
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
                $sectiondata = [
                    'section' => $this->request->getVar('section'),
                    'sy' => $this->request->getVar('sy'),
                    'level' => $this->request->getVar('level'),
                    'sem' => $this->request->getVar('semester'),
                    'course' => $this->request->getVar('course'),
                ];
                $this->sectionsModel->save($sectiondata);
                session()->setTempdata('success', 'Section is added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('college/sectionsview', $data);
    }
    public function deletesections($id=null) {
        $data = [
            'isdel' => '1',
        ];

        $this->sectionsModel->where('secid', $id)->update($id, $data);
        session()->setTempdata('success', 'Section is deleted!', 2);
        return redirect()->to(base_url()."col-sections");
    }
    public function updatesections($id=null) {
        if($this->request->is('post')) {
            $sectiondata = [
                'section' => $this->request->getVar('section'),
                'sy' => $this->request->getVar('sy'),
                'level' => $this->request->getVar('level'),
                'sem' => $this->request->getVar('semester'),
                'course' => $this->request->getVar('course'),
            ];

            $this->sectionsModel->where('secid', $id)->update($id, $sectiondata);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."col-sections");
        }
    }
    public function registrationselect(){
        $data = [
            'page_title' => 'Holy Cross College | College Registration - New Stundents',
            'page_heading' => 'COLLEGE REGISTRATION - OLD STUDENTS!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        return view('college/registrationselectview', $data);
    }
    public function oldstudentselect(){
        $data = [
            'page_title' => 'Holy Cross College | College Registration - Old Students',
            'page_heading' => 'COLLEGE REGISTRATION - OLD STUDENTS!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $colStudentsInfo = $this->colStudentsModel
        ->select('students_col.*, enrollmenthistory_col.*')
        ->join('enrollmenthistory_col', 'enrollmenthistory_col.studid = students_col.studid')
        ->where('students_col.studentno', '')
        ->where('enrollmenthistory_col.sy', '')
        ->where('enrollmenthistory_col.level', '')
        ->where('enrollmenthistory_col.sem', '')
        ->where('enrollmenthistory_col.course', '')
        ->where('enrollmenthistory_col.isdel', '')
        ->findAll();
        $registeredstudentsinfo = $this->regStudentsModel
        ->select('regstudents.*')
        ->where('NOT EXISTS (SELECT 1 FROM enrollmenthistory_col 
            WHERE enrollmenthistory_col.studfullname = regstudents.studfullname 
            AND enrollmenthistory_col.isdel = 0)', NULL, FALSE)
        ->where('studstatus', 'COL')
        ->findAll();
        $data['registeredstudents'] = array_merge($colStudentsInfo, $registeredstudentsinfo);

        return view('college/oldselectview', $data);
    }
    public function oldstudentprocess(){
        if($this->request->is('post')) {
            $studfullname = $this->request->getVar('fullname');
            $studno = $this->request->getVar('studnumber');

            $CHECKSTUDSHSTABLE = $this->colStudentsModel
            ->where('studfullname', $studfullname)->findAll();

            if(empty($CHECKSTUDSHSTABLE)){
                $CHECKREGTABLE = $this->regStudentsModel->where('studfullname', $studfullname)->findAll();
                foreach($CHECKREGTABLE as $CRT){
                    $STUDLN = $CRT['studln'];
                    $STUDFN = $CRT['studfn'];
                    $STUDMN = $CRT['studmn'];
                    $STUDEXT = $CRT['studextension'];
                    $STUDFULLNAME = $CRT['studfullname'];
                    $STUDBIRTHDAY = $CRT['studbirthday'];
                    $STUDAGE = $CRT['studage'];
                    $STUDGENDER = $CRT['studgender'];
                    $STUDBARANGAY = $CRT['studstbarangay'];
                    $STUDCITY = $CRT['studcity'];
                    $STUDPROVINCE = $CRT['studprovince'];
                    $STUDCONTACT = $CRT['studcontact'];
                    $STUDICITIZENSHIP = $CRT['studcitizenship'];
                    $STUDRELIGION = $CRT['studreligion'];
                    $STUDEMAIL = $CRT['studemail'];
                    $STUDBIRTHPLACE = $CRT['studbirthplace'];
                }
                $shsstuddata = [
                    'studentno' => $studno,
                    'studln' => $STUDLN,
                    'studfn' => $STUDFN,
                    'studmn' => $STUDMN,
                    'studextension' => $STUDEXT,
                    'studfullname' => $STUDFULLNAME,
                    'studbirthday' => $STUDBIRTHDAY,
                    'studage' => $STUDAGE,
                    'studgender' => $STUDGENDER,
                    'studstbarangay' => $STUDBARANGAY,
                    'studcity' => $STUDCITY,
                    'studprovince' => $STUDPROVINCE,
                    'studcontact' => $STUDCONTACT,
                    'studcitizenship' => $STUDICITIZENSHIP,
                    'studreligion' => $STUDRELIGION,
                    'studemail' => $STUDEMAIL,
                    'studbirthplace' => $STUDBIRTHPLACE,
                ];
                $this->colStudentsModel->save($shsstuddata);
                $registeredstudentpr = $this->colStudentsModel->where('studfullname', $STUDFULLNAME)->findAll();
                foreach($registeredstudentpr as $rsp){
                    $STUDID = $rsp['studid'];
                }
                $this->colPermanentRecordModel->where('studfullname', $STUDFULLNAME)->set(['studid' => $STUDID])->update();
                $ehdata = [
                    'studid' => $STUDID,
                    'studfullname' => $STUDFULLNAME,
                    'date' => date('Y-m-d'),
                    'status' => 'Registered',
                ];
                $this->enrollmentHistoryCOLModel->save($ehdata);
                return redirect()->to(base_url()."col-admission");
            } else {
                $this->colStudentsModel->where('studfullname', $studfullname)->set(['studentno' => $studno])->update();
                return redirect()->to(base_url()."col-admission");
            }
        }
    }
    public function registeredstudent(){
        $data = [
            'page_title' => 'Holy Cross College | College Registered Students',
            'page_heading' => 'COLLEGE REGISTERED STUDENTS!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['registeredstudents'] = $this->regStudentsModel
        ->select('regstudents.*')
        ->join('enrollmenthistory_col', 'enrollmenthistory_col.studfullname = regstudents.studfullname AND enrollmenthistory_col.isdel = 0', 'left')
        ->where('enrollmenthistory_col.studfullname IS NULL') // Only those NOT in enrollment history
        ->where('regstudents.studstatus', 'COL') // Only SHS students
        ->groupBy('regstudents.studfullname') // Group by student fullname to avoid duplicates
        ->findAll();

        $data['paymenttransactionsData'] = $this->paymentTransactionsModel
        ->where('isdel', 0)->findAll();


        return view('college/registeredstudentview', $data);
    }
    public function registeredstudentProcess($id=null){
        $registeredstudent = $this->regStudentsModel->where('studid', $id)->findAll();
        foreach($registeredstudent as $rs){
            $STUDLN = $rs['studln'];
            $STUDFN = $rs['studfn'];
            $STUDMN = $rs['studmn'];
            $STUDEXT = $rs['studextension'];
            $STUDFULLNAME = $rs['studfullname'];
            $STUDBIRTHDAY = $rs['studbirthday'];
            $STUDAGE = $rs['studage'];
            $STUDGENDER = $rs['studgender'];
            $STUDBARANGAY = $rs['studstbarangay'];
            $STUDCITY = $rs['studcity'];
            $STUDPROVINCE = $rs['studprovince'];
            $STUDCONTACT = $rs['studcontact'];
            $STUDICITIZENSHIP = $rs['studcitizenship'];
            $STUDRELIGION = $rs['studreligion'];
            $STUDEMAIL = $rs['studemail'];
            $STUDBIRTHPLACE = $rs['studbirthplace'];
        }
        $shsstuddata = [
            'studln' => $STUDLN,
            'studfn' => $STUDFN,
            'studmn' => $STUDMN,
            'studextension' => $STUDEXT,
            'studfullname' => $STUDFULLNAME,
            'studbirthday' => $STUDBIRTHDAY,
            'studage' => $STUDAGE,
            'studgender' => $STUDGENDER,
            'studstbarangay' => $STUDBARANGAY,
            'studcity' => $STUDCITY,
            'studprovince' => $STUDPROVINCE,
            'studcontact' => $STUDCONTACT,
            'studcitizenship' => $STUDICITIZENSHIP,
            'studreligion' => $STUDRELIGION,
            'studemail' => $STUDEMAIL,
            'studbirthplace' => $STUDBIRTHPLACE,
        ];
        $this->colStudentsModel->save($shsstuddata);
        $registeredstudentpr = $this->colStudentsModel->where('studfullname', $STUDFULLNAME)->findAll();
        foreach($registeredstudentpr as $rsp){
            $STUDID = $rsp['studid'];
        }
        $this->colPermanentRecordModel->where('studfullname', $STUDFULLNAME)->set(['studid' => $STUDID])->update();
        $ehdata = [
            'studid' => $STUDID,
            'studfullname' => $STUDFULLNAME,
            'date' => date('Y-m-d'),
            'status' => 'Registered',
        ];
        $this->enrollmentHistoryCOLModel->save($ehdata);
        return redirect()->to(base_url()."col-admission");
    }
    public function admission(){
        $data = [
            'page_title' => 'Holy Cross College | College Admission',
            'page_heading' => 'COLLEGE ADMISSION!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['enrollmenthistoryshsdata'] = $this->enrollmentHistoryCOLModel
        ->select('enrollmenthistory_col.*, students_col.*')
        ->join('students_col', 'students_col.studid = enrollmenthistory_col.studid')
        ->where('enrollmenthistory_col.status', 'Registered')->where('enrollmenthistory_col.isdel', 0)->findAll();

        return view('college/admissionview', $data);
    }
    public function admissionProcess($id=null){
        $data = [
            'page_title' => 'Holy Cross College | College Admission Process',
            'page_heading' => 'COLLEGE ADMISSION PROCESS!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['studentsshsdata'] = $this->colStudentsModel
        ->select('students_col.*, permanentrecord_col.*')
        ->join('permanentrecord_col', 'permanentrecord_col.studid = students_col.studid', 'left')
        ->where('students_col.studid', $id)->findAll();

        $data['schoolyear'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['coursedata'] = $this->coursesModel->where('isdel', 0)->findAll();

        if($this->request->is('post')){
            // SHS SCHOOL RECORD 
            $schoolrecorddata = [
                'studid' => $id,
                'sy' => $this->request->getVar('sy'),
                'level' => $this->request->getVar('level'),
                'sem' => $this->request->getVar('sem'),
                'course' => $this->request->getVar('course'),
            ];
            $this->colSchoolRecordModel->save($schoolrecorddata);
            // SHS FAMILY BACKGROUND 
            $fbdata = [
                'studid' => $id,
                'nfather' => $this->request->getVar('fname'),
                'fmobile' => $this->request->getVar('fcontact'),
                'fwork' => $this->request->getVar('fwork'),
                'femail' => $this->request->getVar('femail'),
                'foffice' => $this->request->getVar('foffice'),
                'nmother' => $this->request->getVar('mname'),
                'mmobile' => $this->request->getVar('mcontact'),
                'mwork' => $this->request->getVar('mwork'),
                'memail' => $this->request->getVar('memail'),
                'moffice' => $this->request->getVar('moffice'),
            ];
            $this->colFamilyBackgroundModel->save($fbdata);

            // ADDITIONAL INFO
            $addinfodata = [
                'studid' => $id,
                'fdateofbirth' => $this->request->getVar('fdateofbirth'),
                'fplaceofbirth' => $this->request->getVar('fplaceofbirth'),
                'faddress' => $this->request->getVar('faddress'),
                'feduc' => $this->request->getVar('feduc'),
                'flanguage' => $this->request->getVar('flanguage'),
                'mdateofbirth' => $this->request->getVar('mdateofbirth'),
                'mplaceofbirth' => $this->request->getVar('mplaceofbirth'),
                'maddress' => $this->request->getVar('maddress'),
                'meducation' => $this->request->getVar('meducation'),
                'mlanguage' => $this->request->getVar('mlanguage'),
                'pstatus' => $this->request->getVar('pstatus'),
                'nameg' => $this->request->getVar('nameg'),
                'contactg' => $this->request->getVar('contactg'),
                'gaddress' => $this->request->getVar('gaddress'),
                'contactperson' => $this->request->getVar('contactperson'),
                'personcontactno' => $this->request->getVar('personcontactno'),
                'siblingname' => $this->request->getVar('siblingname'),
                'siblingwork' => $this->request->getVar('siblingwork'),
                'siblingage' => $this->request->getVar('siblingage'),
                'interest' => $this->request->getVar('interest'),
                'talents' => $this->request->getVar('talents'),
                'hobbies' => $this->request->getVar('hobbies'),
                'goals' => $this->request->getVar('goals'),
                'characteristics' => $this->request->getVar('characteristics'),
                'fears' => $this->request->getVar('fears'),
                'disabilities' => $this->request->getVar('disabilities'),
                'chronic_illnesses' => $this->request->getVar('chronic_illnesses'),
                'medicine' => $this->request->getVar('medicine'),
                'vitamins' => $this->request->getVar('vitamins'),
                'recent_accidents' => $this->request->getVar('recent_accidents'),
                'experience_accidents' => $this->request->getVar('experience_accidents'),
                'recent_surgical' => $this->request->getVar('recent_surgical'),
                'experience_surgical' => $this->request->getVar('experience_surgical'),
                'vaccines' => $this->request->getVar('vaccines'),
                'con_psy' => $this->request->getVar('con_psy'),
                'con_psy_date' => $this->request->getVar('con_psy_date'),
                'con_psy_sessions' => $this->request->getVar('con_psy_sessions'),
                'con_psy_diagnosis' => $this->request->getVar('con_psy_diagnosis'),
                'con_regpsy' => $this->request->getVar('con_regpsy'),
                'con_regpsy_date' => $this->request->getVar('con_regpsy_date'),
                'con_regpsy_sessions' => $this->request->getVar('con_regpsy_sessions'),
                'con_regpsy_diagnosis' => $this->request->getVar('con_regpsy_diagnosis'),
                'con_regguid' => $this->request->getVar('con_regguid'),
                'con_regguid_date' => $this->request->getVar('con_regguid_date'),
                'con_regguid_sessions' => $this->request->getVar('con_regguid_sessions'),
                'con_regguid_diagnosis' => $this->request->getVar('con_regguid_diagnosis'),
                'aisdel' => 0,
            ];
            $this->additionalInfoCOLModel->save($addinfodata);

            // PERMANENT RECORD 
            $PRSHSInfo = $this->colPermanentRecordModel->where('studid', $id)->findAll();
            foreach($PRSHSInfo as $prshs) {
                $PRSHSID = $prshs['prid'];
            }
            $prdata = [
                'eschool' => $this->request->getVar('eschool'),
                'eyeargraduate' => $this->request->getVar('eyeargraduate'),
                'jhschool' => $this->request->getVar('jhschool'),
                'jhyeargraduate' => $this->request->getVar('jhyeargraduate'),
            ];
            $this->colPermanentRecordModel->where('prid', $PRSHSID)->update($PRSHSID, $prdata);
            // ENROLLMENT TEMP DATA UPDATE
            $EHSHSInfo = $this->enrollmentHistoryCOLModel->where('studid', $id)->findAll();
            foreach($EHSHSInfo as $ehshs) {
                $EHSHSID = $ehshs['ehid'];
            }
            $ehshsdata = [
                'sy' => $this->request->getVar('sy'),
                'level' => $this->request->getVar('level'),
                'sem' => $this->request->getVar('sem'),
                'course' => $this->request->getVar('course'),
                'status' => 'Admitted',
            ];
            $this->enrollmentHistoryCOLModel->where('ehid', $EHSHSID)->update($EHSHSID, $ehshsdata);
            session()->setTempdata('success', 'Admission processed successfully!', 2);
            return redirect()->to(base_url()."col-admission");
        }

        return view('college/admissionviewprocess', $data);
    }
    public function admissionProcessCancel($id=null) {
        $ehdata = [
            'isdel' => '1',
            'status' => 'Cancelled',
        ];
        $shsstuddata = [
            'studisdel' => '1',
        ];

        $this->enrollmentHistoryCOLModel->where('ehid', $id)->update($id, $ehdata);
        $this->colStudentsModel->where('studid', $id)->update($id, $shsstuddata);
        session()->setTempdata('deletesuccess', 'Application is deleted!', 2);
        return redirect()->to(base_url()."col-admission");
    }
    public function admissionProcessGenerate($id=null) {
        $year = date('y');
        // print_r($year);
        $laststudentno = $this->colStudentsModel
        ->like('studentno', $year . 'C', 'after')
        ->orderBy('studentno', 'DESC')
        ->get()
        ->getFirstRow();

        if ($laststudentno) {
            $lastNumber = (int)substr($laststudentno->studentno, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = '1';
        }

        $studentNumber = $year . 'C' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        // print_r($studentNumber);
        $data = [
            'studentno' => $studentNumber,
        ];
        $this->colStudentsModel->where('studid', $id)->update($id, $data);
        return redirect()->to(base_url()."col-admission/process/".$id);
    }
    public function advising() {
        $data = [
            'page_title' => 'Holy Cross College | College Advising',
            'page_heading' => 'COLLEGE ADVISING!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['enrollmenthistorycoldata'] = $this->enrollmentHistoryCOLModel
        ->select('enrollmenthistory_col.*, students_col.*, courses.*')
        ->join('students_col', 'students_col.studid = enrollmenthistory_col.studid')
        ->join('courses', 'courses.courid = enrollmenthistory_col.course')
        ->where('enrollmenthistory_col.status', 'Admitted')->where('enrollmenthistory_col.isdel', 0)->findAll();

        return view('college/advisingview', $data);
    }
    public function advisingProcess($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | College Advising',
            'page_heading' => 'COLLEGE ADVISING!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['enrollmenthistorycoldata'] = $this->enrollmentHistoryCOLModel
        ->select('enrollmenthistory_col.*, students_col.*, courses.*')
        ->join('students_col', 'students_col.studid = enrollmenthistory_col.studid')
        ->join('courses', 'courses.courid = enrollmenthistory_col.course')
        ->where('students_col.studid', $id)->findAll();
        foreach($data['enrollmenthistorycoldata'] as $ehs) {
            $COURSE = $ehs['course'];
            $LEVEL = $ehs['level'];
            $SY = $ehs['sy'];
            $SEM = $ehs['sem'];
            $STUDID = $ehs['studid'];
        }

        $data['colcurriculumdata'] = $this->curriculumModel
        ->select('curriculum.*, courses.*')
        ->join('courses', 'courses.courid = curriculum.course')
        ->where('curriculum.course', $COURSE)
        ->where('curriculum.sy', $SY)
        ->findAll();

        $data['colsectiondata'] = $this->sectionsModel
        ->select('sections.*, courses.*')
        ->join('courses', 'courses.courid = sections.course')
        ->where('sections.course', $COURSE)
        ->where('sections.level', $LEVEL)
        ->where('sections.sy', $SY)
        ->where('sections.sem', $SEM)
        ->findAll();

        if($this->request->is('post')) {
            $SELECTEDCURRICULUM = $this->request->getVar('curriculum');
            $SELECTEDSECTION = $this->request->getVar('section');
            $ADVISINGCHECK = $this->colAssessmentModel
            ->where('studid', $STUDID)
            ->where('sy', $SY)
            ->where('level', $LEVEL)
            ->findAll();
            // print_r($ADVISINGCHECK);
            if(!empty($ADVISINGCHECK)) {
                session()->setTempdata('error', 'Student is already assessed!', 2);
                return redirect()->to(current_url());
            }else{
                $shsassessmentdata = [
                    'studid' => $STUDID,
                    'sy' => $SY,
                    'level' => $LEVEL,
                    'sem' => $SEM,
                    'course' => $COURSE,
                    'curriculum' => $SELECTEDCURRICULUM,
                    'section' => $SELECTEDSECTION,
                    'date' => date('Y-m-d'),
                ];
                $this->colAssessmentModel->save($shsassessmentdata);
                $selectedsemester = $this->curriculumDataModel
                ->where('curriculumid', $SELECTEDCURRICULUM)
                ->where('level', $LEVEL)
                ->where('sem', $SEM)
                ->findAll();
                foreach($selectedsemester as $ss){
                    $ssdata = [
                        'studid' => $STUDID,
                        'cdid' => $ss['cdid'],
                    ];

                    $this->studentSubjectsModel->save($ssdata);
                    
                    // print_r($ssdata);
                }
                session()->setTempdata('success', 'Student is processed successfully!', 2);
                    return redirect()->to(current_url());
                
            }
        }
        $data['colassessmentdata'] = $this->colAssessmentModel
        ->select('assessment_col.*, curriculum.*, sections.*, students_col.*, courses.*')
        ->join('curriculum', 'curriculum.currid = assessment_col.curriculum')
        ->join('sections', 'sections.secid = assessment_col.section')
        ->join('students_col', 'students_col.studid = assessment_col.studid')
        ->join('courses', 'courses.courid = assessment_col.course')
        ->where('assessment_col.studid', $STUDID)
        ->where('assessment_col.sy', $SY)
        ->where('assessment_col.level', $LEVEL)
        ->where('assessment_col.sem', $SEM)
        ->findAll();

        // SHS ASSESSED CURRICULUM DATA
        // $data['selectedsemester'] = $this->colAssessmentModel
        // ->select('assessment_col.*, curriculum.*, currdata.*, subjects.*')
        // ->join('curriculum', 'curriculum.currid = assessment_col.curriculum', 'left')
        // ->join('currdata', 'currdata.curriculumid = curriculum.currid', 'left')
        // ->join('subjects', 'subjects.subid = currdata.subid', 'left')
        // ->where('assessment_col.studid', $STUDID)
        // ->where('assessment_col.sy', $SY)
        // ->where('assessment_col.level', $LEVEL)
        // ->where('currdata.sem', $SEM)
        // ->findAll();

        $data['selectedsubjects'] = $this->colAssessmentModel
        ->select('assessment_col.*, student_subjects.*, curriculum.*, currdata.*, subjects.*')
        ->join('curriculum', 'curriculum.currid = assessment_col.curriculum', 'left')
        ->join('currdata', 'currdata.curriculumid = curriculum.currid', 'left')
        ->join('student_subjects', 'student_subjects.cdid = currdata.cdid', 'left')
        ->join('subjects', 'subjects.subid = currdata.subid', 'left')
        ->where('assessment_col.studid', $STUDID)
        ->where('assessment_col.sy', $SY)
        ->where('assessment_col.level', $LEVEL)
        ->where('currdata.sem', $SEM)
        ->where('student_subjects.isdel', 0)
        ->findAll();

        


        // //SHS ASSESSED RATE DATA
        $data['shsratedata'] = $this->ratesModel
        ->where('course', $COURSE)
        ->where('level', $LEVEL)
        ->where('sy', $SY)
        ->where('sem', $SEM)
        ->findAll();
        foreach($data['shsratedata'] as $rates){
            $RATEID = $rates['rateid'];
        }

        $data['shsrofdata'] = $this->rateOtherFeesModel->where('rateid', $RATEID)->findAll();
        $data['shsrddata'] = $this->rateDuesModel->where('rateid', $RATEID)->findAll();

        $data['totalotherfees'] = $this->rateOtherFeesModel->select('
            SUM(rateotherfees.otherfees) as totalrof
            ')->join('rates', 'rates.rateid = rateotherfees.rateid')
            ->where('rates.rateid', $RATEID)
            ->findAll();

        $data['totalminorunits'] = $this->colAssessmentModel
        ->select('SUM(subjects.units) as totalminorunits')
        ->join('curriculum', 'curriculum.currid = assessment_col.curriculum', 'left')
        ->join('currdata', 'currdata.curriculumid = curriculum.currid', 'left')
        ->join('student_subjects', 'student_subjects.cdid = currdata.cdid', 'left')
        ->join('subjects', 'subjects.subid = currdata.subid', 'left')
        ->where('assessment_col.studid', $STUDID)
        ->where('assessment_col.sy', $SY)
        ->where('assessment_col.level', $LEVEL)
        ->where('currdata.sem', $SEM)
        ->where('subjects.major', 0)
        ->where('subjects.subcode !=', "NSTP01")
        ->where('subjects.subcode !=', "NSTP02")
        ->where('student_subjects.isdel', 0)
        ->findAll();
        $data['totalmajorunits'] = $this->colAssessmentModel
        ->select('SUM(subjects.units) as totalmajorunits')
        ->join('curriculum', 'curriculum.currid = assessment_col.curriculum', 'left')
        ->join('currdata', 'currdata.curriculumid = curriculum.currid', 'left')
        ->join('student_subjects', 'student_subjects.cdid = currdata.cdid', 'left')
        ->join('subjects', 'subjects.subid = currdata.subid', 'left')
        ->where('assessment_col.studid', $STUDID)
        ->where('assessment_col.sy', $SY)
        ->where('assessment_col.level', $LEVEL)
        ->where('currdata.sem', $SEM)
        ->where('subjects.major', 1)
        ->where('subjects.subcode !=', "NSTP01")
        ->where('subjects.subcode !=', "NSTP02")
        ->where('student_subjects.isdel', 0)
            ->findAll();
        $data['totalmajorhours'] = $this->colAssessmentModel->select('
            SUM(subjects.hours) as totalmajorhours
            ')->join('curriculum', 'curriculum.currid = assessment_col.curriculum', 'left')
            ->join('currdata', 'currdata.curriculumid = curriculum.currid', 'left')
            ->join('student_subjects', 'student_subjects.cdid = currdata.cdid', 'left')
            ->join('subjects', 'subjects.subid = currdata.subid', 'left')
            ->where('assessment_col.studid', $STUDID)
            ->where('assessment_col.sy', $SY)
            ->where('assessment_col.level', $LEVEL)
            ->where('currdata.sem', $SEM)
            ->where('subjects.major', 1)
            ->where('subjects.subcode !=', "NSTP01")
            ->where('subjects.subcode !=', "NSTP02")
            ->where('student_subjects.isdel', 0)
            ->findAll();
        $data['totalminorhours'] = $this->colAssessmentModel->select('
            SUM(subjects.hours) as totalminorhours
            ')->join('curriculum', 'curriculum.currid = assessment_col.curriculum', 'left')
            ->join('currdata', 'currdata.curriculumid = curriculum.currid', 'left')
            ->join('student_subjects', 'student_subjects.cdid = currdata.cdid', 'left')
            ->join('subjects', 'subjects.subid = currdata.subid', 'left')
            ->where('assessment_col.studid', $STUDID)
            ->where('assessment_col.sy', $SY)
            ->where('assessment_col.level', $LEVEL)
            ->where('currdata.sem', $SEM)
            ->where('subjects.major', 0)
            ->where('subjects.subcode !=', "NSTP01")
            ->where('subjects.subcode !=', "NSTP02")
            ->where('subjects.major', 0)
            ->where('student_subjects.isdel', 0)
            ->findAll();

        return view('college/advisingviewprocess', $data);
    }
    public function advisingDrop($id=null, $studid=null) {

        $this->studentSubjectsModel->where('ssid', $id)->set(['isdel' => 1])->update();
        session()->setTempdata('success', 'Subject is dropped successfully!', 2);
        return redirect()->to(base_url()."col-advising/process/".$studid);
    }
    public function advisingSubmitAccount($id=null) {
        $ASSESSMENTDATACHECKING = $this->colAssessmentModel
        ->select('assessment_col.*, students_col.*, courses.*')
        ->join('students_col', 'students_col.studid = assessment_col.studid')
        ->join('courses', 'courses.courid = assessment_col.course')
        ->where('assessment_col.studid', $id)
        ->findAll();
        foreach($ASSESSMENTDATACHECKING as $adc) {
            $STUDENTNO = $adc['studentno'];
            $ASSESSMENTID = $adc['assid'];
            $SY = $adc['sy'];
            $COURSE = $adc['code'];
            $LEVEL = $adc['level'];
            $SEM = $adc['sem'];
        }

        $studentsaccounts = [
            'studentno' => $STUDENTNO,
            'assessmentid' => $ASSESSMENTID,
            'sy' => $SY,
            'sem' => $SEM,
            'course' => $COURSE,
            'level' => $LEVEL,
            'accountstatus' => 'Active',
            'createddate' => date('Y-m-d'),
        ];
        $FINDEHSHS = $this->enrollmentHistoryCOLModel
        ->where('studid', $id)
        ->where('sy', $SY)
        ->where('level', $LEVEL)
        ->findAll();
        foreach($FINDEHSHS as $findehshs){
            $STUDENTID = $findehshs['studid'];
        }

        $ehshsdata = [
            'status' => 'Assessed',
        ];
        
        $shsassessment = [
            'status' => 'Finalized',
        ];

        $this->colAssessmentModel->where('assid', $ASSESSMENTID)->update($ASSESSMENTID, $shsassessment);
        $this->studentAccountsModel->save($studentsaccounts);
        $this->enrollmentHistoryCOLModel->where('studid', $STUDENTID)->set(['status' => 'Assessed'])->update();
        session()->setTempdata('success', 'Student is assessed successfully!', 2);
        return redirect()->to(base_url()."col-advising");
    }
    public function assessment() {
        $data = [
            'page_title' => 'Holy Cross College | COLLEGE Assessment',
            'page_heading' => 'COLLEGE ASSESSMENT!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['enrollmenthistoryshsdata'] = $this->enrollmentHistoryCOLModel
        ->select('enrollmenthistory_col.*, students_col.*, courses.*')
        ->join('students_col', 'students_col.studid = enrollmenthistory_col.studid')
        ->join('courses', 'courses.courid = enrollmenthistory_col.course')
        ->where('enrollmenthistory_col.status', 'Assessed')->where('enrollmenthistory_col.isdel', 0)->findAll();

        return view('college/assessmentview', $data);
    }
    public function assessmentView($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | College Assessment View',
            'page_heading' => 'COLLEGE ASSESSMENT VIEW!',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['enrollmenthistoryshsdata'] = $this->enrollmentHistoryCOLModel
        ->select('enrollmenthistory_col.*, students_col.*, courses.*')
        ->join('students_col', 'students_col.studid = enrollmenthistory_col.studid')
        ->join('courses', 'courses.courid = enrollmenthistory_col.course')
        ->where('students_col.studid', $id)->findAll();
        foreach($data['enrollmenthistoryshsdata'] as $ehs) {
            $COURSE = $ehs['course'];
            $LEVEL = $ehs['level'];
            $SY = $ehs['sy'];
            $SEM = $ehs['sem'];
            $STUDID = $ehs['studid'];
        }
        $data['colassessmentdata'] = $this->colAssessmentModel
        ->select('assessment_col.*, curriculum.*, sections.*, students_col.*, courses.*')
        ->join('curriculum', 'curriculum.currid = assessment_col.curriculum')
        ->join('sections', 'sections.secid = assessment_col.section')
        ->join('students_col', 'students_col.studid = assessment_col.studid')
        ->join('courses', 'courses.courid = assessment_col.course')
        ->where('assessment_col.studid', $STUDID)
        ->where('assessment_col.sy', $SY)
        ->where('assessment_col.level', $LEVEL)
        ->where('assessment_col.sem', $SEM)
        ->findAll();
        // SHS ASSESSED CURRICULUM DATA
        $data['selectedsubjects'] = $this->colAssessmentModel
        ->select('assessment_col.*, student_subjects.*, curriculum.*, currdata.*, subjects.*')
        ->join('curriculum', 'curriculum.currid = assessment_col.curriculum', 'left')
        ->join('currdata', 'currdata.curriculumid = curriculum.currid', 'left')
        ->join('student_subjects', 'student_subjects.cdid = currdata.cdid', 'left')
        ->join('subjects', 'subjects.subid = currdata.subid', 'left')
        ->where('assessment_col.studid', $STUDID)
        ->where('assessment_col.sy', $SY)
        ->where('assessment_col.level', $LEVEL)
        ->where('currdata.sem', $SEM)
        ->where('student_subjects.isdel', 0)
        ->findAll();

        //SHS ASSESSED RATE DATA
        $data['shsratedata'] = $this->ratesModel
        ->where('course', $COURSE)
        ->where('level', $LEVEL)
        ->where('sy', $SY)
        ->where('sem', $SEM)
        ->findAll();
        foreach($data['shsratedata'] as $rates){
            $RATEID = $rates['rateid'];
        }

        $data['shsrofdata'] = $this->rateOtherFeesModel->where('rateid', $RATEID)->findAll();
        $data['shsrddata'] = $this->rateDuesModel->where('rateid', $RATEID)->findAll();

        $data['totalotherfees'] = $this->rateOtherFeesModel->select('
            SUM(rateotherfees.otherfees) as totalrof
            ')->join('rates', 'rates.rateid = rateotherfees.rateid')
            ->where('rates.rateid', $RATEID)
            ->findAll();

        $data['totalminorunits'] = $this->colAssessmentModel
        ->select('SUM(subjects.units) as totalminorunits')
        ->join('curriculum', 'curriculum.currid = assessment_col.curriculum', 'left')
        ->join('currdata', 'currdata.curriculumid = curriculum.currid', 'left')
        ->join('student_subjects', 'student_subjects.cdid = currdata.cdid', 'left')
        ->join('subjects', 'subjects.subid = currdata.subid', 'left')
        ->where('assessment_col.studid', $STUDID)
        ->where('assessment_col.sy', $SY)
        ->where('assessment_col.level', $LEVEL)
        ->where('currdata.sem', $SEM)
        ->where('subjects.major', 0)
        ->where('subjects.subcode !=', "NSTP01")
        ->where('subjects.subcode !=', "NSTP02")
        ->where('student_subjects.isdel', 0)
        ->findAll();
        $data['totalmajorunits'] = $this->colAssessmentModel
        ->select('SUM(subjects.units) as totalmajorunits')
        ->join('curriculum', 'curriculum.currid = assessment_col.curriculum', 'left')
        ->join('currdata', 'currdata.curriculumid = curriculum.currid', 'left')
        ->join('student_subjects', 'student_subjects.cdid = currdata.cdid', 'left')
        ->join('subjects', 'subjects.subid = currdata.subid', 'left')
        ->where('assessment_col.studid', $STUDID)
        ->where('assessment_col.sy', $SY)
        ->where('assessment_col.level', $LEVEL)
        ->where('currdata.sem', $SEM)
        ->where('subjects.major', 1)
        ->where('subjects.subcode !=', "NSTP01")
        ->where('subjects.subcode !=', "NSTP02")
        ->where('student_subjects.isdel', 0)
            ->findAll();
        $data['totalmajorhours'] = $this->colAssessmentModel->select('
            SUM(subjects.hours) as totalmajorhours
            ')->join('curriculum', 'curriculum.currid = assessment_col.curriculum', 'left')
            ->join('currdata', 'currdata.curriculumid = curriculum.currid', 'left')
            ->join('student_subjects', 'student_subjects.cdid = currdata.cdid', 'left')
            ->join('subjects', 'subjects.subid = currdata.subid', 'left')
            ->where('assessment_col.studid', $STUDID)
            ->where('assessment_col.sy', $SY)
            ->where('assessment_col.level', $LEVEL)
            ->where('currdata.sem', $SEM)
            ->where('subjects.major', 1)
            ->where('subjects.subcode !=', "NSTP01")
            ->where('subjects.subcode !=', "NSTP02")
            ->where('student_subjects.isdel', 0)
            ->findAll();
        $data['totalminorhours'] = $this->colAssessmentModel->select('
            SUM(subjects.hours) as totalminorhours
            ')->join('curriculum', 'curriculum.currid = assessment_col.curriculum', 'left')
            ->join('currdata', 'currdata.curriculumid = curriculum.currid', 'left')
            ->join('student_subjects', 'student_subjects.cdid = currdata.cdid', 'left')
            ->join('subjects', 'subjects.subid = currdata.subid', 'left')
            ->where('assessment_col.studid', $STUDID)
            ->where('assessment_col.sy', $SY)
            ->where('assessment_col.level', $LEVEL)
            ->where('currdata.sem', $SEM)
            ->where('subjects.major', 0)
            ->where('subjects.subcode !=', "NSTP01")
            ->where('subjects.subcode !=', "NSTP02")
            ->where('subjects.major', 0)
            ->where('student_subjects.isdel', 0)
            ->findAll();
        
        return view('college/assessmentviewing', $data);
    }
    public function assessmentPrint($id=null) {
        $pageSize = array(216, 330);
        $pdf = new TCPDF('P', 'mm', $pageSize, true, 'UTF-8', false);
        // Load TCPDF library
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetCreator('Holy Cross College');
        $pdf->SetAuthor('TRS Department');
        $pdf->SetTitle('Assessment of Fees');

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

        $enrollmenthistoryshsdata = $this->enrollmentHistoryCOLModel
        ->select('enrollmenthistory_col.*, students_col.*, courses.*')
        ->join('students_col', 'students_col.studid = enrollmenthistory_col.studid')
        ->join('courses', 'courses.courid = enrollmenthistory_col.course')
        ->where('students_col.studid', $id)->findAll();
        foreach($enrollmenthistoryshsdata as $ehs) {
            $COURSE = $ehs['course'];
            $LEVEL = $ehs['level'];
            $SY = $ehs['sy'];
            $SEM = $ehs['sem'];
            $STUDID = $ehs['studid'];
            $COURSENAME = $ehs['name'];
        }
        $shsassessmentdata = $this->colAssessmentModel
        ->select('assessment_col.*, curriculum.*, sections.*, students_col.*, courses.*')
        ->join('curriculum', 'curriculum.currid = assessment_col.curriculum')
        ->join('sections', 'sections.secid = assessment_col.section')
        ->join('students_col', 'students_col.studid = assessment_col.studid')
        ->join('courses', 'courses.courid = assessment_col.course')
        ->where('assessment_col.studid', $STUDID)
        ->where('assessment_col.sy', $SY)
        ->where('assessment_col.level', $LEVEL)
        ->where('assessment_col.sem', $SEM)
        ->findAll();
        foreach($shsassessmentdata as $sad) {
            $STUDENTNO = $sad['studentno'];
            $STUDFULLNAME = $sad['studfullname'];
            $BARANGAY = $sad['studstbarangay'];
            $MUNICIPALITY = $sad['studcity'];
            $PROVINCE = $sad['studprovince'];
            $ADDRESS = $BARANGAY .' '. $MUNICIPALITY .', '. $PROVINCE;
            $SECTION = $sad['section'];
        }
        
        // SHS ASSESSED CURRICULUM DATA
        $firstsemester = $this->colAssessmentModel
        ->select('assessment_col.*, student_subjects.*, curriculum.*, currdata.*, subjects.*')
        ->join('curriculum', 'curriculum.currid = assessment_col.curriculum', 'left')
        ->join('currdata', 'currdata.curriculumid = curriculum.currid', 'left')
        ->join('student_subjects', 'student_subjects.cdid = currdata.cdid', 'left')
        ->join('subjects', 'subjects.subid = currdata.subid', 'left')
        ->where('assessment_col.studid', $STUDID)
        ->where('assessment_col.sy', $SY)
        ->where('assessment_col.level', $LEVEL)
        ->where('currdata.sem', $SEM)
        ->where('student_subjects.isdel', 0)
        ->findAll();

        //SHS ASSESSED RATE DATA
        $shsratedata = $this->ratesModel
        ->where('course', $COURSE)
        ->where('level', $LEVEL)
        ->where('sy', $SY)
        ->where('sem', $SEM)
        ->findAll();
        foreach($shsratedata as $rates){
            $RATEID = $rates['rateid'];
            $RATESID = $rates['rateid'];
            $RATEMAJOR = $rates['major'];
            $RATEMINOR = $rates['minor'];
            $RATENSTP1 = $rates['nstp01'];
            $RATENSTP2 = $rates['nstp02'];
            if($RATENSTP2 == '0.00'){
                $NSTP = $RATENSTP1;
            }else{
                $NSTP = $RATENSTP2;
            }
        }
        

        $shsrofdata = $this->rateOtherFeesModel->where('rateid', $RATEID)->findAll();
        $shsrddata = $this->rateDuesModel->where('rateid', $RATEID)->findAll();

        $dtotalotherfees = $this->rateOtherFeesModel->select('
            SUM(rateotherfees.otherfees) as totalrof
            ')->join('rates', 'rates.rateid = rateotherfees.rateid')
            ->where('rates.rateid', $RATEID)
            ->findAll();
        foreach($dtotalotherfees as $dtof){
            $TOTALOTHERFEES = $dtof['totalrof'];
        }

        $totalminorunits = $this->colAssessmentModel
        ->select('SUM(subjects.units) as totalminorunits')
        ->join('curriculum', 'curriculum.currid = assessment_col.curriculum', 'left')
        ->join('currdata', 'currdata.curriculumid = curriculum.currid', 'left')
        ->join('student_subjects', 'student_subjects.cdid = currdata.cdid', 'left')
        ->join('subjects', 'subjects.subid = currdata.subid', 'left')
        ->where('assessment_col.studid', $STUDID)
        ->where('assessment_col.sy', $SY)
        ->where('assessment_col.level', $LEVEL)
        ->where('currdata.sem', $SEM)
        ->where('subjects.major', 0)
        ->where('subjects.subcode !=', "NSTP01")
        ->where('subjects.subcode !=', "NSTP02")
        ->where('student_subjects.isdel', 0)
        ->findAll();
        foreach($totalminorunits as $tmnu){
            $TOTALMINORUNITS = $tmnu['totalminorunits'];
        }
        $totalmajorunits = $this->colAssessmentModel
        ->select('SUM(subjects.units) as totalmajorunits')
        ->join('curriculum', 'curriculum.currid = assessment_col.curriculum', 'left')
        ->join('currdata', 'currdata.curriculumid = curriculum.currid', 'left')
        ->join('student_subjects', 'student_subjects.cdid = currdata.cdid', 'left')
        ->join('subjects', 'subjects.subid = currdata.subid', 'left')
        ->where('assessment_col.studid', $STUDID)
        ->where('assessment_col.sy', $SY)
        ->where('assessment_col.level', $LEVEL)
        ->where('currdata.sem', $SEM)
        ->where('subjects.major', 1)
        ->where('subjects.subcode !=', "NSTP01")
        ->where('subjects.subcode !=', "NSTP02")
        ->where('student_subjects.isdel', 0)
        ->findAll();
        foreach($totalmajorunits as $tmju){
            $TOTALMAJORUNITS = $tmju['totalmajorunits'];
        }
        $TOTALUNITS = $TOTALMAJORUNITS + $TOTALMINORUNITS;

        $totalmajorhours = $this->colAssessmentModel->select('
            SUM(subjects.hours) as totalmajorhours
            ')->join('curriculum', 'curriculum.currid = assessment_col.curriculum', 'left')
            ->join('currdata', 'currdata.curriculumid = curriculum.currid', 'left')
            ->join('student_subjects', 'student_subjects.cdid = currdata.cdid', 'left')
            ->join('subjects', 'subjects.subid = currdata.subid', 'left')
            ->where('assessment_col.studid', $STUDID)
            ->where('assessment_col.sy', $SY)
            ->where('assessment_col.level', $LEVEL)
            ->where('currdata.sem', $SEM)
            ->where('subjects.major', 1)
            ->where('subjects.subcode !=', "NSTP01")
            ->where('subjects.subcode !=', "NSTP02")
            ->where('student_subjects.isdel', 0)
            ->findAll();
        foreach($totalmajorhours as $tmh){
            $TOTALMAJORHOURS = $tmh['totalmajorhours'];
        }
        $totalminorhours = $this->colAssessmentModel->select('
            SUM(subjects.hours) as totalminorhours
            ')->join('curriculum', 'curriculum.currid = assessment_col.curriculum', 'left')
            ->join('currdata', 'currdata.curriculumid = curriculum.currid', 'left')
            ->join('student_subjects', 'student_subjects.cdid = currdata.cdid', 'left')
            ->join('subjects', 'subjects.subid = currdata.subid', 'left')
            ->where('assessment_col.studid', $STUDID)
            ->where('assessment_col.sy', $SY)
            ->where('assessment_col.level', $LEVEL)
            ->where('currdata.sem', $SEM)
            ->where('subjects.major', 0)
            ->where('subjects.subcode !=', "NSTP01")
            ->where('subjects.subcode !=', "NSTP02")
            ->where('subjects.major', 0)
            ->where('student_subjects.isdel', 0)
            ->findAll();
        foreach($totalminorhours as $tmih){
            $TOTALMINORHOURS = $tmih['totalminorhours'];
        }
        $TOTALHOURS = $TOTALMAJORHOURS + $TOTALMINORHOURS;

        //MAJOR COMPUTATION
        $MAJORAMOUNT = $RATEMAJOR * $TOTALMAJORHOURS;
        //MINOR COMPUTATION
        $MINORAMOUNT = $RATEMINOR * $TOTALMINORHOURS;
        //TOTAL TUITION FEE
        $TOTALTUITIONFEE = $MAJORAMOUNT + $MINORAMOUNT + $NSTP;

        //GRAND TOTAL TUITION FEE
                        $GRANDTOTAL = $TOTALTUITIONFEE + $TOTALOTHERFEES;
                        $GRANDTOTALFORMATED = number_format($GRANDTOTAL, 2);

                        $DUEDATE = $this->rateDuesModel->where('rateid', $RATESID)->findAll();
                        $COUNTDUEDATE = $this->rateDuesModel->where('rateid', $RATESID)->countAllResults();
                        $DUEAMOUNT = $GRANDTOTAL / $COUNTDUEDATE;
                        $DUEAMOUNTFORMATTED = number_format($DUEAMOUNT,2);

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
                    <td style="width: 60%;"></td>
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
                    <td style="width: 65%;">STUDENT No.: <strong>'. $STUDENTNO .' </strong></td>
                    <td>SCHOOL YEAR: <strong>'. $SY .'</strong></td>
                </tr>
                <tr>
                    <td>STUDENT: <strong>'. strtoupper($STUDFULLNAME) .'</strong></td>
                    <td>LEVEL: <strong>'. $LEVEL .'</strong></td>
                </tr>
                <tr>
                    <td>COURSE: <strong>'. strtoupper($COURSENAME) .'</strong></td>
                    <td>SECTION: <strong>'. $SECTION .'</strong></td>
                </tr>
                <tr>
                    <td>ADDRESS: <strong>'. strtoupper($ADDRESS) .'</strong></td>
                    
                </tr>
            </table><br><br>

            <table border="1" style="width: 100%; font-size: 10px;">
                <tr>
                    <td style="text-align: center;"><strong>FIRST SEMESTER</strong></td>
                </tr>
                <thead>
                    <tr>
                        <th style="width: 10%;text-align: center;">CODE</th>
                        <th style="width: 50%;text-align: center;">SUBJECT</th>
                        <th style="width: 7%;text-align: center;">UNIT</th>
                        <th style="width: 7%;text-align: center;">HOUR</th>
                        <th style="width: 26%;text-align: center;">SCHEDULE</th>
                    </tr>
                </thead>
                <tbody>
        ';
        foreach($firstsemester as $subd){
            $SUBCODE = $subd['subcode'];
            $SUBJECT = $subd['subject'];
            $UNIT = $subd['units'];
            $UNITFORMATED =  number_format($UNIT, 2);
            $HOUR = $subd['hours'];
            $HOURFORMATED =  number_format($HOUR, 2);

            $html .= '<tr>
                    <td style="width: 10%; text-align: center;">'.$SUBCODE.'</td>
                    <td style="width: 50%; text-align: left">'.$SUBJECT.' </td>
                    <td style="width: 7%; text-align: center;">'.$UNITFORMATED.'</td>
                    <td style="width: 7%; text-align: center;">'.$HOURFORMATED.'</td>
                    <td style="width: 26%; text-align: center;">TBA</td>
                </tr>';
        }
        $html .='
                    <tr>
                        <td style="width: 10%; text-align: right;"></td>
                        <td style="width: 50%; text-align: center"><strong>TOTAL</strong></td>
                        <td style="width: 7%; text-align: center;"><strong>'.$TOTALUNITS.'</strong></td>
                        <td style="width: 7%; text-align: center;"><strong>'.$TOTALHOURS.'</strong></td>
                        <td style="width: 26%; text-align: center;"></td>
                    </tr>
                </tbody>
            </table>';
        $html .= '
            <br><br>
            <table style="width: 100%;">
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
                                    <td style="width: 12%; text-align: right;">'. $TOTALMAJORUNITS .'</td>
                                    <td style="width: 12%; text-align: right;">'. $TOTALMAJORHOURS .'</td>
                                    <td style="width: 14%; text-align: right;">'. number_format($RATEMAJOR, 2) .'</td>
                                    <td style="width: 18%; text-align: right;">'. number_format($MAJORAMOUNT,2) .'</td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; text-align: left;">Regular Subjects</td>
                                    <td style="width: 14%; text-align: left;">Minor</td>
                                    <td style="width: 12%; text-align: right;">'. $TOTALMINORUNITS .'</td>
                                    <td style="width: 12%; text-align: right;">'. $TOTALMINORHOURS .'</td>
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
                        <p style="font-size: 11px">I promise to pay my tuition and other fees based on the installment schedule below:</p>
                        <table border="1" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="width: 70%; text-align: left;">Due Date</td>
                                    <td style="width: 30%; text-align: center;">Amount</td>
                                </tr>';
                        
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
                        $ROFData = $this->rateOtherFeesModel->where('rateid', $RATESID)->findAll();
                        foreach($ROFData as $rof) {
                            $html .='<tr>
                                        <td style="width: 80%; text-align: left; font-size: 10px;">'. $rof['name'] .'</td>
                                        <td style="width: 20%; text-align: right; font-size: 10px;">'. number_format($rof['otherfees'], 2) .'</td>
                                    </tr>';
                            }
                $html .='
                                <tr>
                                        <td style="width: 80%; text-align: right; font-size: 10px;">TOTAL OTHER FEES</td>
                                        <td style="width: 20%; text-align: right; font-size: 10px;">'. $TOTALOTHERFEES .'</td>
                                </tr>
                                <tr>
                                    <td style="width: 80%; text-align: right; font-size: 10px;">GRAND TOTAL</td>
                                    <td style="width: 20%; text-align: right; font-size: 10px;"><strong>'. $GRANDTOTALFORMATED .'</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table><br><br><br><br>';
        $html .= '<table style="width: 100%;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <table style="width: 100%;">
                            <tbody>
                            <br><br><br><br><br><br><br>
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
                            <br><br><br>
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
                        <table  style="width: 100%;">
                            <tbody>
                            <br><br><br>
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
            </table>';
        
        
        $html .='<table>
                <tbody>
                    <tr>
                    <br><br><br>
                        <td style="text-align: center;">
                            <p style="font-size: 9px;">THIS IS NOT OFFICIAL UNLESS SIGNED BY THE REGISTRAR</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        ';


        $pdf->writeHTML($html, true, false, false, false, '');
        $filename = strtoupper($STUDFULLNAME).'.pdf';
        $pdfContent = $pdf->Output($filename, 'S');
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody($pdfContent);
    }
    public function assessmentApproved($id=null) {
        $ehshsdata = [
            'status' => 'Payment',
        ];
        $this->enrollmentHistoryCOLModel->where('ehid', $id)->update($id, $ehshsdata);
        session()->setTempdata('success', 'Student is approved!', 2);
        return redirect()->to(base_url()."col-assessment");
    }
}