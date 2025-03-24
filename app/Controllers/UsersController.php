<?php

namespace App\Controllers;
use App\Models\UsersModel;
class UsersController extends BaseController
{
    public $usersModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | User Management',
            'page_heading' => 'USER MANAGEMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['usersinfo'] = $this->usersModel->where('uisdel !=', 1)
        ->where('ustudent', 0)
        ->findAll();

        if($this->request->is('post')) {
            $rules = [
                'account' => [
                    'rules' => 'required|is_unique[users.uaccountid]',
                    'errors' => [
                        'required' => 'Account number is required.',
                        'is_unique' => 'This account number is already exists.'
                    ],
                ],
                'username' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Account number is required.',
                    ],
                ],
                'password' => [
                    'rules' => 'required|min_length[6]|max_length[16]',
                    'errors' => [
                        'required' => 'Password is required.',
                        'min_length' => 'Password must be atleast 6 characters.',
                        'max_length' => 'Password is only up to 16 characters only.'
                    ],
                ]
            ];
            if($this->validate($rules)) {
                $admin = $this->request->getVar('cadmin');
                $registrar = $this->request->getVar('cregistrar');
                $pc = $this->request->getVar('cpc');
                if($admin == ''){
                    $ADMIN = 0;
                }else{
                    $ADMIN = 1;
                }
                if($registrar == ''){
                    $REGISTRAR = 0;
                }else{
                    $REGISTRAR = 1;
                }
                if($pc == ''){
                    $PC = 0;
                }else{
                    $PC = 1;
                }
                
                $udata = [
                    'uaccountid' => $this->request->getVar('account'),
                    'username' => $this->request->getVar('username'),
                    'upassword' => $this->request->getVar('password'),
                    'uadmin' => $ADMIN,
                    'uregistrar' => $REGISTRAR,
                    'uprogramchair' => $PC,
                    'ustatus' => '0',
                    'uisdel' => '0',
                ];
                $this->usersModel->save($udata);
                session()->setTempdata('addsuccess','User added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('usersview', $data);
    }
    public function updateUsers($id=null) {
        if($this->request->is('post')) {
            $admin = $this->request->getVar('cadmin');
            $registrar = $this->request->getVar('cregistrar');
            $pc = $this->request->getVar('cpc');
            if($admin == '') {
                $ADMIN = 0;
            } else {
                $ADMIN = 1;
            }
            if($registrar == '') {
                $REGISTRAR = 0;
            } else {
                $REGISTRAR = 1;
            }
            if($pc == ''){
                $PC = 0;
            } else {
                $PC = 1;
            }
            
            $udata = [
                'uaccountid' => $this->request->getVar('account'),
                'username' => $this->request->getVar('username'),
                'upassword' => $this->request->getVar('password'),
                'uadmin' => $ADMIN,
                'uregistrar' => $REGISTRAR,
                'uprogramchair' => $PC,
                'ustatus' => '0',
                'uisdel' => '0',
            ];

            $this->usersModel->where('uid', $id)->update($id, $udata);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."users");
        }
    }
    public function enableUsers($id=null) {
        $data = [
            'ustatus' => '0',
        ];

        $this->usersModel->where('uid', $id)->update($id, $data);
        session()->setTempdata('endedsuccess', 'User account enabled!', 2);
        return redirect()->to(base_url()."users");
    }
    public function disableUsers($id=null) {
        $data = [
            'ustatus' => '1',
        ];

        $this->usersModel->where('uid', $id)->update($id, $data);
        session()->setTempdata('endedsuccess', 'User account disabled!', 2);
        return redirect()->to(base_url()."users");
    }
    public function deleteUsers($id=null) {
        $data = [
            'uisdel' => '1',
        ];

        $this->usersModel->where('uid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'User is deleted!', 2);
        return redirect()->to(base_url()."users");
    }
    public function studman() {
        $data = [
            'page_title' => 'Holy Cross College | Student Management',
            'page_heading' => 'STUDENT MANAGEMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['studentman'] = $this->usersModel->where('uisdel !=', 1)
        ->where('ustudent', 1)
        ->findAll();

        if($this->request->is('post')) {
            $rules = [
                'account' => [
                    'rules' => 'required|is_unique[users.uaccountid]',
                    'errors' => [
                        'required' => 'Account number is required.',
                        'is_unique' => 'This account number is already exists.'
                    ],
                ],
                'username' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Account number is required.',
                    ],
                ],
                'password' => [
                    'rules' => 'required|min_length[6]|max_length[16]',
                    'errors' => [
                        'required' => 'Password is required.',
                        'min_length' => 'Password must be atleast 6 characters.',
                        'max_length' => 'Password is only up to 16 characters only.'
                    ],
                ]
            ];
            if($this->validate($rules)) {
                $udata = [
                    'uaccountid' => $this->request->getVar('account'),
                    'username' => $this->request->getVar('username'),
                    'upassword' => $this->request->getVar('password'),
                    'ustudent' => '1',
                    'ustatus' => '0',
                    'uisdel' => '0',
                ];
                $this->usersModel->save($udata);
                session()->setTempdata('addsuccess','Student added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('studentmanagementview', $data);
    }
    public function studmanDelete($id=null) {
        $data = [
            'uisdel' => '1',
        ];

        $this->usersModel->where('uid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Student Account is deleted!', 2);
        return redirect()->to(base_url()."studentmanagement");
    }
    public function studmanUpdate($id=null) {
        if($this->request->is('post')) {
            $udata = [
                'uaccountid' => $this->request->getVar('account'),
                'username' => $this->request->getVar('username'),
                'upassword' => $this->request->getVar('password'),
            ];

            $this->usersModel->where('uid', $id)->update($id, $udata);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."studentmanagement");
        }
    }
    public function studmanEnable($id=null) {
        $data = [
            'ustatus' => '0',
        ];

        $this->usersModel->where('uid', $id)->update($id, $data);
        session()->setTempdata('endedsuccess', 'Student account enabled!', 2);
        return redirect()->to(base_url()."studentmanagement");
    }
    public function studmanDisable($id=null) {
        $data = [
            'ustatus' => '1',
        ];

        $this->usersModel->where('uid', $id)->update($id, $data);
        session()->setTempdata('endedsuccess', 'Student account disabled!', 2);
        return redirect()->to(base_url()."studentmanagement");
    }
}
