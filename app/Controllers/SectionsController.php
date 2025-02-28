<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\SectionsModel;
use App\Models\LevelsModel;
use App\Models\SYModel;
use App\Models\SemesterModel;
use App\Models\CoursesModel;
class SectionsController extends BaseController
{
    public $usersModel;
    public $sectionsModel;
    public $levelModel;
    public $syModel;
    public $semModel;
    public $courseModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->sectionsModel = new SectionsModel();
        $this->levelModel = new LevelsModel();
        $this->syModel = new SYModel();
        $this->semModel = new SemesterModel();
        $this->courseModel = new CoursesModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Sections',
            'page_heading' => 'SECTIONS! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['sectiondata'] = $this->sectionsModel->where('secisdel', 0)->findAll();
        $data['coursedata'] = $this->courseModel->where('courisdel', 0)->findAll();
        $levelCondition = array('levelisdel' => 0, 'leveldeptid' => 4);
        $data['leveldata'] = $this->levelModel->where($levelCondition)->findAll();
        $data['schoolyeardata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semesterdata'] = $this->semModel->where('semisdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'section' => [
                    'rules' => 'required|is_unique[sections.section]',
                    'errors' => [
                        'required' => 'Section is required.',
                        'is_unique' => 'This section is already exists.'
                    ],
                ],
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
                'course' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Course is required.',
                    ],
                ],
                'level' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'College level is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $sectiondata = [
                    'section' => $this->request->getVar('section'),
                    'seclevelid' => $this->request->getVar('level'),
                    'secsyid' => $this->request->getVar('schoolyear'),
                    'secsemid' => $this->request->getVar('semester'),
                    'seccourid' => $this->request->getVar('course'),
                    'secstatus' => '0',
                    'secisdel' => '0',
                ];
                $this->sectionsModel->save($sectiondata);
                session()->setTempdata('addsuccess', 'Section is added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('sectionsview', $data);
    }
    public function deleteSection($id=null){
        $data = [
            'secisdel' => '1',
        ];

        $this->sectionsModel->where('secid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Section is deleted!', 2);
        return redirect()->to(base_url()."sections");
    }
    public function updateSection($id=null) {
        if($this->request->is('post')) {
            $data = [
                'section' => $this->request->getVar('section'),
                'seclevelid' => $this->request->getVar('level'),
                'secsyid' => $this->request->getVar('schoolyear'),
                'secsemid' => $this->request->getVar('semester'),
                'seccourid' => $this->request->getVar('course'),
            ];

            $this->sectionsModel->where('secid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."sections");
        }
    }
}
