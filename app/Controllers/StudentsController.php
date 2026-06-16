<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\StudentsModel;
use App\Models\COLStudentsModel;

class StudentsController extends BaseController
{
    public $usersModel;
    public $studentsModel;
    public $colstudentsModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->studentsModel = new StudentsModel();
        $this->colstudentsModel = new COLStudentsModel();
        $this->session = session();
    }
    public function index() {
        $data = [
            'page_title' => 'Holy Cross College | Students',
            'page_heading' => 'STUDENTS! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        // $StudentsCondition = array('studisdel' => 0);
        // $students = $this->studentsModel->where($StudentsCondition)->findAll();
        // $colStudents = $this->colstudentsModel->where('studisdel', 0)->findAll();
        // $data['studentdata'] = array_merge($students, $colStudents);

        if($this->request->is('post')){
            $searchStudent = $this->request->getVar('searchstud');

            if($searchStudent == ''){
                $StudentsCondition = array('studisdel' => 0);
                // $students = $this->studentsModel->where($StudentsCondition)->findAll();
                // $colStudents = $this->colstudentsModel->where('studisdel', 0)->findAll();
                // $data['resultStudent'] = array_merge($students, $colStudents);
                $data['resultStudent'] = $this->colstudentsModel->where($StudentsCondition)->findAll();
                return view('studentsviewsearchresult', $data);
            }
            else{
                $StudentsCondition = array('studisdel' => 0);
                // $students = $this->studentsModel->where($StudentsCondition)
                // ->like('studentno', $searchStudent)
                // ->orLike('studln', $searchStudent)
                // ->orLike('studfn', $searchStudent)
                // ->orLike('studfullname', $searchStudent)
                // ->findAll();
                // $colStudents = $this->colstudentsModel->where('studisdel', 0)
                // ->like('studentno', $searchStudent)
                // ->orLike('studln', $searchStudent)
                // ->orLike('studfn', $searchStudent)
                // ->orLike('studfullname', $searchStudent)
                // ->findAll();
                // $data['resultStudent'] = array_merge($students, $colStudents);
                $data['resultStudent'] = $this->colstudentsModel->where($StudentsCondition)
                ->like('studentno', $searchStudent)
                ->orLike('studln', $searchStudent)
                ->orLike('studfn', $searchStudent)
                ->orLike('studfullname', $searchStudent)
                ->findAll();
                return view('studentsviewsearchresult', $data);
            }
        }

        return view('studentsview', $data);
    }
    public function activateStudent($id=null) {
        $data = [
            'studstatus' => '1',
        ];

        $this->colstudentsModel->where('studid', $id)->update($id, $data);
        session()->setTempdata('activatesuccess', 'Account is activated!', 2);
        return redirect()->to(base_url()."students");
    }
    public function activateStudentM($id=null) {
        $data = [
            'studstatus' => '2',
        ];

        $this->colstudentsModel->where('studid', $id)->update($id, $data);
        session()->setTempdata('activatesuccess', 'Account is activated!', 2);
        return redirect()->to(base_url()."students");
    }
    public function activateStudentF($id=null) {
        $data = [
            'studstatus' => '3',
        ];

        $this->colstudentsModel->where('studid', $id)->update($id, $data);
        session()->setTempdata('activatesuccess', 'Account is activated!', 2);
        return redirect()->to(base_url()."students");
    }
    public function deactivateStudent($id=null) {
        $data = [
            'studstatus' => '0',
        ];

        $this->colstudentsModel->where('studid', $id)->update($id, $data);
        session()->setTempdata('activatesuccess', 'Account is deactivated!', 2);
        return redirect()->to(base_url()."students");
    }
    public function resetpasswordStudent($id=null) {

        $data = [
            'upassword' => '123456',
        ];

        $this->usersModel
        ->set('upassword', 123456)
        ->where('uaccountid', $id)
        ->update();
        session()->setTempdata('activatesuccess', 'Password has been reset!', 2);

        return redirect()->to(base_url()."students");
    }
    public function deleteStudent($id=null) {
        $data = [
            'studisdel' => '1',
        ];

        $this->colstudentsModel->where('studid', $id)->update($id, $data);
        session()->setTempdata('activatesuccess', 'Student is deleted!', 2);
        return redirect()->to(base_url()."students");
    }
    public function studentInfo($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | Students Information',
            'page_heading' => 'STUDENTS INFORMATION',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $StudentsCondition = array('studid' => $id);
        $data['studentdata'] = $this->colstudentsModel->where($StudentsCondition)->findAll();

        return view('studentsinfo', $data);
    }
    public function studentInfoUpdate($id=null) {
        if($this->request->is('post')) {
            $LN = $this->request->getVar('lname');
            $FN = $this->request->getVar('fname');
            $MN = $this->request->getVar('mname');
            $EXT = $this->request->getVar('extname');
            $FULL = $LN.', '.$FN.' '.$EXT.' '.$MN;
            $data = [
                'studln' => $LN,
                'studfn' => $FN,
                'studmn' => $MN,
                'studextension' => $EXT,
                'studfullname' => $FULL,
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
                'studcreatedat' => $this->request->getVar('section'),
            ];

            $this->colstudentsModel->where('studid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."students");
        }
    }
    public function createaccount($id=null) {
        $checkStudentUserAccount = $this->usersModel->where('uaccountid', $id)->where('uisdel', '0')->findAll();
        if(empty($checkStudentUserAccount)){
            $data = [
                'uaccountid' => $id,
                'username' => $id,
                'upassword' => '123456',
                'ustudent' => '1'
            ];
            $this->usersModel->save($data);
            session()->setTempdata('updatesuccess', 'Student Credentials Created Successfully!', 2);
            return redirect()->to(base_url()."students");
        } else {
            session()->setTempdata('updatesuccess', 'Student Credentials already exist!', 2);
            return redirect()->to(base_url()."students");
        }
        
    }
}
