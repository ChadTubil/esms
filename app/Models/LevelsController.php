<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\DepartmentsModel;
use App\Models\LevelsModel;
class LevelsController extends BaseController
{
    public $usersModel;
    public $deptModel;
    public $levelModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->deptModel = new DepartmentsModel();
        $this->levelModel = new LevelsModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | School Levels',
            'page_heading' => 'SCHOOL LEVELS! ',
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
        $data['leveldata'] = $this->levelModel->where('levelisdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'levels' => [
                    'rules' => 'required|is_unique[levels.level]',
                    'errors' => [
                        'required' => 'Level is required.',
                        'is_unique' => 'This level is already exists.'
                    ],
                ],
                'department' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Department is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $leveldata = [
                    'level' => $this->request->getVar('levels'),
                    'leveldeptid' => $this->request->getVar('department'),
                    'levelisdel' => '0',
                ];
                $this->levelModel->save($leveldata);
                session()->setTempdata('addsuccess', 'Level is added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('levelsview', $data);
    }
    public function deleteLevel($id=null){
        $data = [
            'levelisdel' => '1',
        ];

        $this->levelModel->where('levelid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Level is deleted!', 2);
        return redirect()->to(base_url()."levels");
    }
    public function updateLevel($id=null) {
        if($this->request->is('post')) {
            $data = [
                'level' => $this->request->getVar('levels'),
                'leveldeptid' => $this->request->getVar('department'),
            ];

            $this->levelModel->where('levelid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."levels");
        }
    }
}
