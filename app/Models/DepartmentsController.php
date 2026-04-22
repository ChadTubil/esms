<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\DepartmentsModel;
class DepartmentsController extends BaseController
{
    public $usersModel;
    public $deptModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->deptModel = new DepartmentsModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | School Departments',
            'page_heading' => 'SCHOOL DEPARTMENTS! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['deptdata'] = $this->deptModel->where('deptisdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'dcode' => [
                    'rules' => 'required|is_unique[semester.semester]',
                    'errors' => [
                        'required' => 'Department code is required.',
                        'is_unique' => 'This department code is already exists.'
                    ],
                ],
                'department' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Department is required.',
                        'is_unique' => 'This department is already exists.'
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $deptdata = [
                    'deptname' => $this->request->getVar('department'),
                    'deptcode' => $this->request->getVar('dcode'),
                    'deptisdel' => '0',
                ];
                $this->deptModel->save($deptdata);
                session()->setTempdata('addsuccess', 'Department is added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('departmentsview', $data);
    }
    public function deleteDept($id=null){
        $data = [
            'deptisdel' => '1',
        ];

        $this->deptModel->where('deptid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Department is deleted!', 2);
        return redirect()->to(base_url()."departments");
    }
    public function updateDept($id=null) {
        if($this->request->is('post')){
            $data = [
                'deptname' => $this->request->getVar('department'),
                    'deptcode' => $this->request->getVar('dcode'),
            ];

            $this->deptModel->where('deptid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."departments");
        }
    }
}
