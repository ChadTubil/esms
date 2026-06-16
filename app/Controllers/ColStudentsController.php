<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\StudentsModel;
use App\Models\SYModel;
use App\Models\SemesterModel;
use App\Models\ImportedGradesModel;
use App\Models\COLStudentsModel;
use App\Models\StudentSubjectsModel;
class ColStudentsController extends BaseController
{
    public $usersModel;
    public $studentModel;
    public $syModel;
    public $semModel;
    public $colstudentsModel;
    public $subjectSubjectsModel;
    public $session;
    public $importedgradesModel;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->studentModel = new StudentsModel();
        $this->syModel = new SYModel();
        $this->semModel = new SemesterModel();
        $this->importedgradesModel = new ImportedGradesModel();
        $this->colstudentsModel = new COLStudentsModel();
        $this->subjectSubjectsModel = new StudentSubjectsModel();
        $this->session = session();
    }
    public function index() {
        $data = [
            'page_title' => 'Holy Cross College | Student Grades',
            'page_heading' => 'GRADES ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $usersinfo = $this->usersModel->where('uid', $uid)->findAll();
        foreach($usersinfo as $uinfo){
            $useraccountid = $uinfo['uaccountid'];
        }
        $data['accountinfo'] = $this->studentModel->where('studentno', $useraccountid)->findAll();
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
                return redirect()->to(base_url().'collegestudentsgradesview');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('collegestudentview', $data);
    }
    public function collegestudentdashboard() {
        $data = [
            'page_title' => 'Holy Cross College | Student Portal',
            'page_heading' => 'Student Portal ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $usersinfo = $this->usersModel->where('uid', $uid)->findAll();
        foreach($usersinfo as $uinfo){
            $useraccountid = $uinfo['uaccountid'];
        }
        $data['accountinfo'] = $this->colstudentsModel->where('studentno', $useraccountid)->findAll();

        return view('collegestudentsdashboardview', $data);
    }
    public function collegestudentgradesview() {
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
        foreach($usersinfo as $uinfo) {
            $useraccountid = $uinfo['uaccountid'];
        }
        $data['accountinfo'] = $this->colstudentsModel->where('studentno', $useraccountid)->findAll();
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
                // return redirect()->to(base_url().'collegestudentsgradesview');

                if($sy == '2022-2023' || $sy == '2023-2024' || $sy == '2024-2025'){
                    if($sem == '1st Semester' || $sem == '2nd Semester' || $sem == 'Summer'){
                        return redirect()->to(base_url().'collegestudentsgradesview');
                    }
                }else if ($sy == '2025-2026'){
                    if($sem == '1st Semester' || $sem == '2nd Semester'){
                        return redirect()->to(base_url().'collegestudentsgradesview');

                    }else{
                        return redirect()->to(base_url().'collegestudentsgradesviewnew');
                    }
                }else{
                    return redirect()->to(base_url().'collegestudentsgradesviewnew');
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }

        $importedGradeCondition = array('sy' => $syid, 'sem' => $semid, 'studentno' => $useraccountid);
        $data['importedGradeData'] = $this->importedgradesModel->where($importedGradeCondition)->findAll();
        
        return view('collegestudentsgradesview', $data);
    }
    public function collegestudentgradesviewnew() {
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
        foreach($usersinfo as $uinfo) {
            $useraccountid = $uinfo['uaccountid'];
        }
        $data['accountinfo'] = $this->colstudentsModel->where('studentno', $useraccountid)->findAll();
        foreach($data['accountinfo'] as $colstuddata){
            $STUDID = $colstuddata['studid'];
        }
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
                // return redirect()->to(base_url().'collegestudentsgradesview');

                if($sy == '2022-2023' || $sy == '2023-2024' || $sy == '2024-2025'){
                    if($sem == '1st Semester' || $sem == '2nd Semester' || $sem == 'Summer'){
                        return redirect()->to(base_url().'collegestudentsgradesview');
                    }
                }else if ($sy == '2025-2026'){
                    if($sem == '1st Semester' || $sem == '2nd Semester'){
                        return redirect()->to(base_url().'collegestudentsgradesview');

                    }else{
                        return redirect()->to(base_url().'collegestudentsgradesviewnew');
                    }
                }else{
                    return redirect()->to(base_url().'collegestudentsgradesviewnew');
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }

        $importedGradeCondition = array('student_subjects.sy' => $syid, 'student_subjects.sem' => $semid, 'student_subjects.studid' => $STUDID);
        $data['importedGradeData'] = $this->subjectSubjectsModel
        ->select('student_subjects.*, subjects.subcode, subjects.subject')
        ->join('currdata', 'currdata.cdid = student_subjects.cdid')
        ->join('subjects', 'subjects.subid = currdata.subid')
        ->where($importedGradeCondition)->findAll();
        
        return view('collegestudentsgradesviewnew', $data);
    }
}
