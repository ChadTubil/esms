<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\SemesterModel;
use App\Models\StudentsModel;
use App\Models\EmployeesModel;
use App\Models\EnrollmentTempDataModel;
class ProfileController extends BaseController
{
    public $usersModel;
    public $semModel;
    public $studentModel;
    public $employeesModel;
    public $etdModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->semModel = new SemesterModel();
        $this->studentModel = new StudentsModel();
        $this->employeesModel = new EmployeesModel();
        $this->etdModel = new EnrollmentTempDataModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Profile',
            'page_heading' => 'PROFILE! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['studdata'] = $this->studentModel->findAll();
        $userinfo = $this->usersModel->where('uid', $uid)->findAll();
        if($userinfo != '') {
            foreach($userinfo as $uinfo) {
                $useraccountid = $uinfo['uaccountid'];
                $userstudent = $uinfo['ustudent'];
                $useradmin = $uinfo['uadmin'];
            }
            if($userstudent == '1') {
                // STUDENT
                $data['profiledata'] = $this->studentModel->where('studentno', $useraccountid)->findAll();
            }
            else if($useradmin == '1') {
                // EMPLOYEE
                $data['profiledata'] = $this->employeesModel->where('empnum', $useraccountid)->findAll();
            }
        }
        $data['studdata'] = $this->studentModel->where('studentno', $useraccountid)->findAll();
        foreach($data['studdata'] as $sd) {
            $studid = $sd['studid'];
        }
        if($userstudent == '1') {
            $data['etddata'] = $this->etdModel->where('studno', $studid)->orderBy('etdid', 'DESC')->LIMIT(1)->findAll();
        } else {
            
        }
        return view('profileview', $data);
    }
    public function changepassword($id=null){
        if($this->request->is('post')) {
            $data = [
                'upassword' => $this->request->getVar('newpass'),
            ];

            $this->usersModel->where('uid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Change password successful!', 2);
            return redirect()->to(base_url()."profile");
        }
    }
    public function updateAccount($id=null){
        if($this->request->is('post')) {
            $LN = $this->request->getVar('lastname');
            $FN = $this->request->getVar('firstname');
            $MN = $this->request->getVar('middlename');
            $EXT = $this->request->getVar('ext');
            $FULL = $LN.', '.$FN.' '.$EXT.' '.$MN;
            $data = [
                'studln' => $LN,
                'studfn' => $FN,
                'studmn' => $MN,
                'studextension' => $EXT,
                'studstbarangay' => $this->request->getVar('brgy'),
                'studcity' => $this->request->getVar('city'),
                'studprovince' => $this->request->getVar('prov'),
                'studfullname' => $FULL,
                'studcontact' => $this->request->getVar('contact'),
                'studemail' => $this->request->getVar('email'),
            ];

            $this->studentModel->where('studid', $id)->update($id, $data);
            session()->setTempdata('updateaccountsuccess', 'Update successful!', 2);
            return redirect()->to(base_url()."profile");
        }
    }
}
