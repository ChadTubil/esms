<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\EmployeesModel;
class EmployeesController extends BaseController
{
    public $usersModel;
    public $empModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->empModel = new EmployeesModel();
        $this->session = session();
    }
    public function index() {
        $data = [
            'page_title' => 'Holy Cross College | Employees',
            'page_heading' => 'EMPLOYEES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $employeeCondition = array('empisdel' => 0, 'empid !=' => 1);
        $data['employeesdata'] = $this->empModel->where($employeeCondition)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'employeenum' => [
                    'rules' => 'required|is_unique[employees.empnum]',
                    'errors' => [
                        'required' => 'Employee number is required.',
                        'is_unique' => 'This employee number is already exists.'
                    ],
                ],
                'lastname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Last name is required.',
                    ],
                ],
                'firstname' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'First name is required.',
                    ],
                ],
                'hiringdate' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Hiring date is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $employeedata = [
                    $ln = $this->request->getVar('lastname'),
                    $ex = $this->request->getVar('extension'),
                    $fn = $this->request->getVar('firstname'),
                    $mn = $this->request->getVar('middlename'),
                    'empnum' => $this->request->getVar('employeenum'),
                    'empfn' => $this->request->getVar('firstname'),
                    'empmn' => $this->request->getVar('middlename'),
                    'empln' => $this->request->getVar('lastname'),
                    'empextension' => $this->request->getVar('extension'),
                    'empfullname' => $ln.', '.$fn.' '.$ex.' '.$mn,
                    'emphiringdate' => $this->request->getVar('hiringdate'),
                    'empresignationdate' => '0',
                    'empposition' => $this->request->getVar('position'),
                    'empstatus' => $this->request->getVar('employeestatus'),
                    'empisdel' => '0',
                ];
                $this->empModel->save($employeedata);
                session()->setTempdata('addsuccess', 'Employee is added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('employeesview', $data);
    }
    public function deleteEmployee($id=null) {
        $data = [
            'empisdel' => '1',
        ];

        $this->empModel->where('empid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Employee is deleted!', 2);
        return redirect()->to(base_url()."employees");
    }
    public function updateEmployee($id=null) {
        if($this->request->is('post')) {
            $data = [
                $ln = $this->request->getVar('lastname'),
                $ex = $this->request->getVar('extension'),
                $fn = $this->request->getVar('firstname'),
                $mn = $this->request->getVar('middlename'),
                'empnum' => $this->request->getVar('employeenum'),
                'empfn' => $this->request->getVar('firstname'),
                'empmn' => $this->request->getVar('middlename'),
                'empln' => $this->request->getVar('lastname'),
                'empextension' => $this->request->getVar('extension'),
                'empfullname' => $ln.', '.$fn.' '.$ex.' '.$mn,
                'emphiringdate' => $this->request->getVar('hiringdate'),
                'empposition' => $this->request->getVar('position'),
                'empstatus' => $this->request->getVar('employeestatus'),
            ];

            $this->empModel->where('empid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."employees");
        }
    }
}
