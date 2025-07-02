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
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['subjectsdata'] = $this->subjectsModel->where('isdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'subject' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Subject is required.',
                    ],
                ],
                'subcode' => [
                    'rules' => 'required|is_unique[subjects.subcode]',
                    'errors' => [
                        'required' => 'Subject code is required.',
                        'is_unique' => 'This subject code is already exists.'
                    ],
                ],
                'lechours' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Lecture hours is required.',
                    ],
                ],
                'lecunits' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Lecture units is required.',
                    ],
                ],
                'labunits' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Laboratory units is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $major = $this->request->getVar('major');
                if($major == ''){
                    $MAJOR = 0;
                }else{
                    $MAJOR = 1;
                }
                $data = [
                    'subject' => $this->request->getVar('subject'),
                    'subcode' => $this->request->getVar('subcode'),
                    'lechours' => $this->request->getVar('lechours'),
                    'labhours' => $this->request->getVar('labhours'),
                    'hours' => $this->request->getVar('lechours') + $this->request->getVar('labhours'),
                    'lecunits' => $this->request->getVar('lecunits'),
                    'labunits' => $this->request->getVar('labunits'),
                    'units' => $this->request->getVar('lecunits') + $this->request->getVar('labunits'),
                    'major' => $MAJOR,
                    'prerequisite' => $this->request->getVar('prerequisite'),
                    'status' => 0,
                    'isdel' => 0,
                ];
                $this->subjectsModel->save($data);
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
            'isdel' => '1',
        ];

        $this->subjectsModel->where('subid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Subject is deleted!', 2);
        return redirect()->to(base_url()."subjects");
    }
    public function updateSubject($id=null) {
        if($this->request->is('post')) {
            $major = $this->request->getVar('major');
            if($major == ''){
                $MAJOR = 0;
            }else{
                $MAJOR = 1;
            }
            $data = [
                'subject' => $this->request->getVar('subject'),
                'subcode' => $this->request->getVar('subcode'),
                'lechours' => $this->request->getVar('lechours'),
                'labhours' => $this->request->getVar('labhours'),
                'hours' => $this->request->getVar('lechours') + $this->request->getVar('labhours'),
                'lecunits' => $this->request->getVar('lecunits'),
                'labunits' => $this->request->getVar('labunits'),
                'units' => $this->request->getVar('lecunits') + $this->request->getVar('labunits'),
                'major' => $MAJOR,
                'prerequisite' => $this->request->getVar('prerequisite'),
            ];

            $this->subjectsModel->where('subid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."subjects");
        }
    }
}
