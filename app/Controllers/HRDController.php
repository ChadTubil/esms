<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\FARModel;
use App\Models\EmployeesModel;
use App\Models\SYModel;
use App\Models\SemesterModel;
class HRDController extends BaseController
{
    public $usersModel;
    public $farModel;
    public $empModel;
    public $syModel;
    public $semModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->farModel = new FARModel();
        $this->empModel = new EmployeesModel();
        $this->syModel = new SYModel();
        $this->semModel = new SemesterModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | FPA Reports',
            'page_heading' => 'FACULTY PERFORMANCE APPRAISAL! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        if($this->request->is('post')){
            $searchFaculty = $this->request->getVar('searchfaculty');
            if($searchFaculty == ''){
                $FacultyCondition = array('empposition' => 'PART TIME', 'empposition' => 'TEACHING STAFF', 'empid !=' => 1);
                $data['resultfaculty'] = $this->empModel->where($FacultyCondition)->findAll();
                return view('fpareportsresultview', $data);
            }else{
                $data['resultfaculty'] = $this->empModel
                    ->like('empnum', $searchFaculty)
                    ->orLike('empfullname', $searchFaculty)->findAll();
                    return view('fpareportsresultview', $data);
            }
        }
        return view('fpareportsview.php', $data);
    }
    public function facultyView($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | FPA Reports',
            'page_heading' => 'FACULTY PERFORMANCE APPRAISAL! ',
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

        $data['facultyinfo'] = $this->empModel->where('empid', $id)->findAll();

        $data['schoolyeardata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semesterdata'] = $this->semModel->where('semisdel', 0)->findAll();

        if($this->request->is('post'))
        {
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
            if($this->validate($rules))
            {
                $sy = $this->request->getVar('schoolyear');
                $sem = $this->request->getVar('semester');
                $this->session->set('selected_sy', $sy);
                $this->session->set('selected_sem', $sem);
                return redirect()->to(base_url().'hrd-fpareportsfaculty-performance/'.$id);
            }
            else
            {
                $data['validation'] = $this->validator;
            }
        }

        return view('fpareportfacultyview', $data);
    }
    public function facultyResult($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | FPA Reports',
            'page_heading' => 'FACULTY PERFORMANCE APPRAISAL! ',
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

        $data['facultyinfo'] = $this->empModel->where('empid', $id)->findAll();

        $syid = session()->get('selected_sy');
        $semid = session()->get('selected_sem');
        $data['selectedsy'] = $this->syModel->where('syname', $syid)->findAll();
        $data['selectedsem'] = $this->semModel->where('semester', $semid)->findAll();

        $data['schoolyeardata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semesterdata'] = $this->semModel->where('semisdel', 0)->findAll();

        $employeeinfo = $this->empModel->where('empid', $id)->findAll();
        foreach($employeeinfo as $ed){
            $asd = $ed['empfullname'];
        
        
        }
        // FAR STUDENTS
        $data['farstudents'] = $this->farModel
        ->where('farevaluator', 1)
        ->where('farname', $asd)
        ->where('farsy', $syid)
        ->where('farsem', $semid)
        ->findAll();

        if($this->request->is('post'))
        {
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
            if($this->validate($rules))
            {
                $sy = $this->request->getVar('schoolyear');
                $sem = $this->request->getVar('semester');
                $this->session->set('selected_sy', $sy);
                $this->session->set('selected_sem', $sem);
                return redirect()->to(base_url().'hrd-fpareportsfaculty-view/'.$id);
            }
            else
            {
                $data['validation'] = $this->validator;
            }
        }

        return view('fpareportfacultyperformance', $data);
    }
}
