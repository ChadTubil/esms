<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\EnrollmentTempDataModel;
class DashboardController extends BaseController
{
    public $usersModel;
    public $etdModel;
    public $session;
    public function __construct() {
        $this->usersModel = new UsersModel();
        $this->etdModel = new EnrollmentTempDataModel();
        helper('form');
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Dashboard',
            'page_heading' => 'Hello! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['etdnewstudent'] = $this->etdModel->where('isdel', '0')->where('level', '1st Year')->countAllResults(); //COUNT NEW STUDENTS
        $data['etdoldstudent'] = $this->etdModel->where('isdel', '0')->where('level !=', '1st Year')->where('level !=', '')->countAllResults(); //COUNT OLD STUDENTS
        $data['etdregisteredstudent'] = $this->etdModel
            ->where('isdel', '0')
            ->where('status', 'Registered')
            ->orWhere('status', 'Admitted')
            ->countAllResults(); //COUNT REGISTERED STUDENTS
        $data['etdadmittedstudent'] = $this->etdModel->where('isdel', '0')->where('status', 'Admitted')->countAllResults(); //COUNT ADMITTED STUDENTS

        // SCITE
        $data['bsit1st'] = $this->etdModel->where('isdel', '0')->where('level', '1st Year')->where('course', '1')->countAllResults();
        $data['bsit2nd'] = $this->etdModel->where('isdel', '0')->where('level', '2nd Year')->where('course', '1')->countAllResults();
        $data['bsit3rd'] = $this->etdModel->where('isdel', '0')->where('level', '3rd Year')->where('course', '1')->countAllResults();
        $data['bsit4th'] = $this->etdModel->where('isdel', '0')->where('level', '4th Year')->where('course', '1')->countAllResults();
        $data['BSITTOTAL'] = $data['bsit1st'] + $data['bsit2nd'] + $data['bsit3rd'] + $data['bsit4th']; //TOTAL BSIT STUDENTS

        $data['total1st'] = $this->etdModel
        ->where('isdel', '0')
        ->where('level', '1st Year')
        ->where('course', '1')
        ->countAllResults(); //TOTAL 1ST YEAR STUDENTS
        $data['total2nd'] = $this->etdModel->where('isdel', '0')->where('level', '2nd Year')->countAllResults(); //TOTAL 2ND YEAR STUDENTS
        $data['total3rd'] = $this->etdModel->where('isdel', '0')->where('level', '3rd Year')->countAllResults(); //TOTAL 3RD YEAR STUDENTS
        $data['total4th'] = $this->etdModel->where('isdel', '0')->where('level', '4th Year')->countAllResults(); //TOTAL 4TH YEAR STUDENTS
        
        return view('dashboardview', $data);
    }
    public function logout() 
    {
        session()->remove('logged_user');
        session()->destroy();
        return redirect()->to(base_url());
    }
}
