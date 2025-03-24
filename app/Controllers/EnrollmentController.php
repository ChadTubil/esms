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
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Register Student',
            'page_heading' => 'REGISTER STUDENT! ',
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
            ];
            if($this->validate($rules)) {
                $L = $this->request->getVar('lname');
                $F = $this->request->getVar('fname');
                $MN = $this->request->getVar('mname');
                $EXT = $this->request->getVar('extname');
                $FULLNAME = $L.', '.$F.' '.$MN.' '.$EXT;
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
                session()->setTempdata('addsuccess','Student added successfully', 3);
                return redirect()->to(current_url());
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

        $data['admission'] = $this->studentsModel->where('studentno', '')
        ->where('studisdel', 0)
        ->where('studssrid', 0)
        ->findAll();

        $data['schoolyear'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semester'] = $this->semModel->where('semisdel', 0)->findAll();
        $data['level'] = $this->levelsModel->where('levelisdel', 0)->findAll();
        $data['course'] = $this->coursesModel->where('courisdel', 0)->findAll();

        return view('admissionview', $data);
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
            foreach($findAdmission as $fA) {
                $AdmissionID = $fA['ssrid'];
            }

            $studdata = [
                'studssrid' => $AdmissionID,
                'studentno' => $this->request->getVar('studnum'),
            ];
            $this->studentsModel->where('studid', $id)->update($id, $studdata);
            session()->setTempdata('updatesuccess', 'Admission Process Successful!', 2);
            return redirect()->to(base_url()."admission");
        }
    }
    public function assessment() {
        $data = [
            'page_title' => 'Holy Cross College | Assessment',
            'page_heading' => 'ASSESSMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['schoolyear'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semester'] = $this->semModel->where('semisdel', 0)->findAll();
        $data['level'] = $this->levelsModel->where('levelisdel', 0)->findAll();
        $data['course'] = $this->coursesModel->where('courisdel', 0)->findAll();

        if($this->request->getMethod() == 'post'){
            $searchStudent = $this->request->getVar('searchstud');

            if($searchStudent == ''){
                $StudentsCondition = array('studisdel' => 0);
                $data['resultStudent'] = $this->studentsModel->where($StudentsCondition)->findAll();
                return view('assessmentviewresult', $data);
            }
            else{
                $StudentsCondition = array('studisdel' => 0);
                $data['resultStudent'] = $this->studentsModel->where($StudentsCondition)
                ->like('studentno', $searchStudent)
                ->orLike('studln', $searchStudent)
                ->orLike('studfn', $searchStudent)
                ->orLike('studfullname', $searchStudent)
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
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['schoolyear'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semester'] = $this->semModel->where('semisdel', 0)->findAll();
        $data['level'] = $this->levelsModel->where('levelisdel', 0)->findAll();
        $data['course'] = $this->coursesModel->where('courisdel', 0)->findAll();

        $data['students'] = $this->studentsModel->where('studid', $id)->findAll();
        $data['schoolrecord'] = $this->srModel->where('srstudid', $id)->findAll();

        $data['assessment'] = $this->assModel->where('asstudentno', $id)->findAll();


        
        return view('assessmentviewprocess', $data);
    }
    public function assessmentProcess2($id=null) {
        if($this->request->getMethod() == 'post')
        {
            $SY = $this->request->getVar('sy');
            $SEM = $this->request->getVar('sem');
            $COURSE = $this->request->getVar('course');
            $LEVEL = $this->request->getVar('yl');

            $assessmentinfo = $this->assModel->where('asstudentno', $id)
            ->where('assy', $SY)->where('assem', $SEM)->where('asscourse', $COURSE)
            ->where('asslevel', $LEVEL)->findAll();

            if(empty($assessmentinfo)){
                $assessmentdata = [
                    'asstudentno' => $id,
                    'assy' => $SY,
                    'assem' => $SEM,
                    'asscourse' => $COURSE,
                    'asslevel' => $LEVEL,
                ];
                $this->assModel->save($assessmentdata);
                session()->setTempdata('processsuccess', 'Assessment Process Successful!', 2);
                return redirect()->to(base_url()."assessment/process/".$id);
            }
            else{
                session()->setTempdata('processnotsuccess', 'The assessment is already exists.!', 2);
                return redirect()->to(base_url()."assessment/process/".$id);
            }
        }
    }
}
