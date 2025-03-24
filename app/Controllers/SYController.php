<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\SYModel;
class SYController extends BaseController
{
    public $usersModel;
    public $syModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->syModel = new SYModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | School Year',
            'page_heading' => 'SCHOOL YEAR! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['sydata'] = $this->syModel->where('syisdel', 0)->findAll();

        if($this->request->is('post')){
            $rules = [
                'schoolyear' => [
                    'rules' => 'required|is_unique[sy.syname]',
                    'errors' => [
                        'required' => 'School year is required.',
                        'is_unique' => 'This school year is already exists.'
                    ],
                ],
            ];
            if($this->validate($rules)){
                $sydata = [
                    'syname' => $this->request->getVar('schoolyear'),
                    'systatus' => '0',
                    'syisdel' => '0',
                ];
                $this->syModel->save($sydata);
                session()->setTempdata('addsuccess','School year added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('syview', $data);
    }
    public function deleteSY($id=null) {
        $data = [
            'syisdel' => '1',
        ];

        $this->syModel->where('syid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'School year is deleted!', 2);
        return redirect()->to(base_url()."schoolyear");
    }
    public function endSY($id=null) {
        $data = [
            'systatus' => '1',
        ];

        $this->syModel->where('syid', $id)->update($id, $data);
        session()->setTempdata('endedsuccess', 'School year ended!', 2);
        return redirect()->to(base_url()."schoolyear");
    }
    public function updateSY($id=null) {
        if($this->request->is('post')) {
            $data = [
                'syname' => $this->request->getVar('schoolyear'),
            ];

            $this->syModel->where('syid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."schoolyear");
        }
    }
}
