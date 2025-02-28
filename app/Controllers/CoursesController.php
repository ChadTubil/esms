<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\CoursesModel;
class CoursesController extends BaseController
{
    public $usersModel;
    public $coursesModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->coursesModel = new CoursesModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Courses',
            'page_heading' => 'COURSES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['coursedata'] = $this->coursesModel->where('courisdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'coursecode' => [
                    'rules' => 'required|is_unique[courses.courcode]',
                    'errors' => [
                        'required' => 'Course code is required.',
                        'is_unique' => 'This course code is already exists.'
                    ],
                ],
                'course' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Course description is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $coursedata = [
                    'courcode' => $this->request->getVar('coursecode'),
                    'course' => $this->request->getVar('course'),
                    'courisdel' => '0',
                ];
                $this->coursesModel->save($coursedata);
                session()->setTempdata('addsuccess','Course added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('coursesview', $data);
    }
    public function deleteCourse($id=null) {
        $data = [
            'courisdel' => '1',
        ];

        $this->coursesModel->where('courid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Course is deleted!', 2);
        return redirect()->to(base_url()."courses");
    }
    public function updateCourse($id=null) {
        if($this->request->is('post'))
        {
            $data = [
                'courcode' => $this->request->getVar('coursecode'),
                'course' => $this->request->getVar('course'),
            ];

            $this->coursesModel->where('courid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."courses");
        }
    }
}
