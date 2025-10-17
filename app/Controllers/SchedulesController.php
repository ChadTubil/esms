<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\SchedulesModel;
use App\Models\SubjectsModel;
use App\Models\EmployeesModel;
use App\Models\RoomsModel;
use App\Models\CoursesModel;
use App\Models\SectionsModel;
class SchedulesController extends BaseController
{
    public $usersModel;
    public $schedModel;
    public $subjModel;
    public $empModel;
    public $roomsModel;
    public $coursesModel;
    public $sectionsModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->schedModel = new SchedulesModel();
        $this->subjModel = new SubjectsModel();
        $this->empModel = new EmployeesModel();
        $this->roomsModel = new RoomsModel();
        $this->coursesModel = new CoursesModel();
        $this->sectionsModel = new SectionsModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Schedules',
            'page_heading' => 'SCHEDULES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['scheduledata'] = $this->schedModel->where('schedisdel', 0)->findAll();
        $data['subjectsdata'] = $this->subjModel->where('isdel', 0)->paginate(10);
        $employeeCondition = array('empisdel' => 0,);
        $data['employeesdata'] = $this->empModel->where($employeeCondition)->findAll();
        $data['roomsdata'] = $this->roomsModel->where('roomisdel', 0)->findAll();
        $data['coursedata'] = $this->coursesModel->where('courisdel', 0)->findAll();
        $data['sectiondata'] = $this->sectionsModel->where('secisdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'course' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Course is required.',
                    ],
                ],
                'section' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Section is required.',
                    ],
                ],
                'subject' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Subject is required.',
                    ],
                ],
                'maxstudent' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Max student count is required.',
                    ],
                ],
                'day' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Day is required.',
                    ],
                ],
                'timein' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Time in is required.',
                    ],
                ],
                'timeout' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Time out is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $scheddata = [
                    'schedcourid' => $this->request->getVar('course'),
                    'schedsubid' => $this->request->getVar('subject'),
                    'schedsecid' => $this->request->getVar('section'),
                    'schedday' => $this->request->getVar('day'),
                    'schedroom' => $this->request->getVar('room'),
                    'schedteacher' => $this->request->getVar('teacher'),
                    'schedtimeF' => $this->request->getVar('timein'),
                    'schedtimeT' => $this->request->getVar('timeout'),
                    'schedmaxstudent' => $this->request->getVar('maxstudent'),
                    'schedtimeF2' => $this->request->getVar('timein2'),
                    'schedtimeT2' => $this->request->getVar('timeout2'),
                    'schedday2' => $this->request->getVar('day2'),
                    'schedstatus' => '0',
                    'schedisdel' => '0',
                ];
                $this->schedModel->save($scheddata);
                session()->setTempdata('addsuccess', 'Schedule is added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('schedulesview', $data);
    }
    public function deleteSchedule($id=null){
        $data = [
            'schedisdel' => '1',
        ];

        $this->schedModel->where('schedid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Schedule is deleted!', 2);
        return redirect()->to(base_url()."schedules");
    }
    public function updateSched($id=null) {
        if($this->request->is('post')) {
            $data = [
                'schedcourid' => $this->request->getVar('course'),
                'schedsubid' => $this->request->getVar('subject'),
                'schedsecid' => $this->request->getVar('section'),
                'schedday' => $this->request->getVar('day'),
                'schedroom' => $this->request->getVar('room'),
                'schedteacher' => $this->request->getVar('teacher'),
                'schedtimeF' => $this->request->getVar('timein'),
                'schedtimeT' => $this->request->getVar('timeout'),
                'schedmaxstudent' => $this->request->getVar('maxstudent'),
                'schedtimeF2' => $this->request->getVar('timein2'),
                'schedtimeT2' => $this->request->getVar('timeout2'),
                'schedday2' => $this->request->getVar('day2'),
            ];

            $this->schedModel->where('schedid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."schedules");
        }
    }
}
