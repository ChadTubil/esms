<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\SemesterModel;
class SemesterController extends BaseController
{
    public $usersModel;
    public $semModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->semModel = new SemesterModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Semester',
            'page_heading' => 'SEMESTER! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['semdata'] = $this->semModel->where('semisdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'semester' => [
                    'rules' => 'required|is_unique[semester.semester]',
                    'errors' => [
                        'required' => 'Semester is required.',
                        'is_unique' => 'This semester is already exists.'
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $semdata = [
                    'semester' => $this->request->getVar('semester'),
                    'semstatus' => '0',
                    'semisdel' => '0',
                ];
                $this->semModel->save($semdata);
                session()->setTempdata('addsuccess', 'Semester added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('semesterview', $data);
    }
    public function deleteSem($id=null){
        $data = [
            'semisdel' => '1',
        ];

        $this->semModel->where('semid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Semester deleted!', 2);
        return redirect()->to(base_url()."semester");
    }
    public function updateSem($id=null) {
        if($this->request->is('post'))
        {
            $data = [
                'semester' => $this->request->getVar('semester'),
            ];

            $this->semModel->where('semid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."semester");
        }
    }
    public function disableSem($id=null) {
        $data = [
            'semstatus' => '1',
        ];

        $this->semModel->where('semid', $id)->update($id, $data);
        session()->setTempdata('endedsuccess', 'Semester Disabled!', 2);
        return redirect()->to(base_url()."semester");
    }
    public function enableSem($id=null) {
        $data = [
            'semstatus' => '0',
        ];

        $this->semModel->where('semid', $id)->update($id, $data);
        session()->setTempdata('endedsuccess', 'Semester Enabled!', 2);
        return redirect()->to(base_url()."semester");
    }
}
