<?php

namespace App\Controllers;
use App\Models\UsersModel;
class LoginController extends BaseController
{
    public $session;
    public $usersModel;
    public function __construct()
    {
        helper('form');
        $this->session = session();
        $this->usersModel = new UsersModel();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Student Portal',
        ];
        if($this->request->getMethod() == 'post')
        {
            $rules = [
                'studentno' => [
                    'rules' => 'required|min_length[4]|max_length[16]',
                    'errors' => [
                        'required' => 'Student no. is required.',
                        'min_length' => 'Student no. must be atleast 4 characters.',
                        'max_length' => 'Student no. is only up to 16 characters only.'
                    ],
                ],
                'pass' => [
                    'rules' => 'required|min_length[6]|max_length[16]',
                    'errors' => [
                        'required' => 'Password is required.',
                        'min_length' => 'Password must be atleast 6 characters.',
                        'max_length' => 'Password is only up to 16 characters only.'
                    ],
                ],
            ];
            if($this->validate($rules))
            {
                $student = $this->request->getVar('studentno');
                $password = $this->request->getVar('pass');

                $userdata = $this->usersModel->verifyUser($student);
                print_r($userdata);
                // if($userdata != ''){
                //     if($password == $userdata['upassword']){
                //         if($userdata['ustatus'] == '0'){
                //             if($userdata['ustudent'] == '1'){
                //                 $this->session->set('logged_user', $userdata['uid']);
                //                 return redirect()->to(base_url().'collegestudents');
                //             }
                //             // $loginInfo = [];
                //             $this->session->set('logged_user', $userdata['uid']);
                //             return redirect()->to(base_url().'dashboard');
                //         }else{
                //             $this->session->setTempdata('error', 'Please contact administrator', 3);
                //             return redirect()->to(current_url());
                //         }
                //     }else{
                //         $this->session->setTempdata('error', 'Sorry! Wrong password', 3);
                //         return redirect()->to(current_url());
                //     }
                // }else{
                //     $this->session->setTempdata('error','Sorry! User does not exists', 3);
                //     return redirect()->to(current_url());
                // }
            }
            else{
                $data['validation'] = $this->validator;
            }
        }
        return view('loginview', $data);
    }

    public function loginStudent($id=null)
    {
        $data = [
            'page_title' => 'Holy Cross College | Student Portal',
        ];
        $findStudent = $this->usersModel->where('uaccountid', $id)->findAll();
        foreach($findStudent as $findS){
            $studPass = $findS['upassword'];
        }

        $student = $id;
        $password = $studPass;

        $userdata = $this->loginModel->verifyUser($student);
        // print_r($userdata);
        if($userdata != '')
        {
            if($password == $userdata['upassword']){
                if($userdata['ustatus'] == '0')
                {
                    if($userdata['ustudent'] == '1'){
                        

                        $this->session->set('logged_user', $userdata['uid']);
                        return redirect()->to(base_url().'collegestudents');
                    }
                    // $loginInfo = [];
                    $this->session->set('logged_user', $userdata['uid']);
                    return redirect()->to(base_url().'dashboard');
                }
                else
                {
                    $this->session->setTempdata('error', 'Please contact administrator', 3);
                    return redirect()->to(current_url());
                }
            }
            else
            {
                $this->session->setTempdata('error', 'Sorry! Wrong password', 3);
                return redirect()->to(current_url());
            }
        }
        else
        {
                $this->session->setTempdata('error','Sorry! User does not exists', 3);
                return redirect()->to(current_url());
        }
        return view('loginview', $data);
    }
}
