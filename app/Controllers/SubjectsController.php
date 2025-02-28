<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\SubjectsModel;
class SubjectsController extends BaseController
{
    public $usersModel;
    public $subjectsModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->subjectsModel = new SubjectsModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | College Subjects',
            'page_heading' => 'COLLEGE SUBJECTS! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['subjectsdata'] = $this->subjectsModel->where('subisdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'subject' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Subject is required.',
                    ],
                ],
                'subjectcode' => [
                    'rules' => 'required|is_unique[subjects.subcode]',
                    'errors' => [
                        'required' => 'Subject code is required.',
                        'is_unique' => 'This subject code is already exists.'
                    ],
                ],
                'subjectunits' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Subject units is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $subjectsdata = [
                    'subject' => $this->request->getVar('subject'),
                    'subcode' => $this->request->getVar('subjectcode'),
                    'subunits' => $this->request->getVar('subjectunits'),
                    'substatus' => '0',
                    'subisdel' => '0',
                ];
                $this->subjectsModel->save($subjectsdata);
                session()->setTempdata('addsuccess','Subject is added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('subjectsview', $data);
    }
    public function deleteSubject($id=null) {
        $data = [
            'subisdel' => '1',
        ];

        $this->subjectsModel->where('subid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Subject is deleted!', 2);
        return redirect()->to(base_url()."subjects");
    }
    public function updateSubject($id=null) {
        if($this->request->is('post')) {
            $data = [
                'subject' => $this->request->getVar('subject'),
                'subcode' => $this->request->getVar('subjectcode'),
                'subunits' => $this->request->getVar('subjectunits'),
            ];

            $this->subjectsModel->where('subid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."subjects");
        }
    }
}
