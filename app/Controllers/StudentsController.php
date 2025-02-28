<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\StudentsModel;
class StudentsController extends BaseController
{
    public $usersModel;
    public $studentsModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->studentsModel = new StudentsModel();
        $this->session = session();
    }
    public function index()
    {
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
        $StudentsCondition = array('studisdel' => 0);
        $data['studentdata'] = $this->studentsModel->where($StudentsCondition)->findAll();

        if($this->request->is('post')){
            $searchStudent = $this->request->getVar('searchstud');

            if($searchStudent == ''){
                $StudentsCondition = array('studisdel' => 0);
                $data['resultStudent'] = $this->studentsModel->where($StudentsCondition)->findAll();
                return view('studentsviewsearchresult', $data);
            }
            else{
                $StudentsCondition = array('studisdel' => 0);
                $data['resultStudent'] = $this->studentsModel->where($StudentsCondition)
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

        $this->studentsModel->where('studid', $id)->update($id, $data);
        session()->setTempdata('activatesuccess', 'Account is activated!', 2);
        return redirect()->to(base_url()."students");
    }
    public function activateStudentM($id=null) {
        $data = [
            'studstatus' => '2',
        ];

        $this->studentsModel->where('studid', $id)->update($id, $data);
        session()->setTempdata('activatesuccess', 'Account is activated!', 2);
        return redirect()->to(base_url()."students");
    }
    public function activateStudentF($id=null) {
        $data = [
            'studstatus' => '3',
        ];

        $this->studentsModel->where('studid', $id)->update($id, $data);
        session()->setTempdata('activatesuccess', 'Account is activated!', 2);
        return redirect()->to(base_url()."students");
    }
    public function deactivateStudent($id=null) {
        $data = [
            'studstatus' => '0',
        ];

        $this->studentsModel->where('studid', $id)->update($id, $data);
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

        $this->studentsModel->where('studid', $id)->update($id, $data);
        session()->setTempdata('activatesuccess', 'Student is deleted!', 2);
        return redirect()->to(base_url()."students");
    }
}
