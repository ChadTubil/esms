<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\CurriculumsModel;
use App\Models\CoursesModel;
use App\Models\SYModel;
use App\Models\SubjectsModel;
use App\Models\LevelsModel;
use App\Models\SemesterModel;
use App\Models\CurriculumDataModel;
class CurriculumController extends BaseController
{
    public $usersModel;
    public $curriculumModel;
    public $courseModel;
    public $syModel;
    public $subjectModel;
    public $levelModel;
    public $semModel;
    public $cdModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->curriculumModel = new CurriculumsModel();
        $this->courseModel = new CoursesModel();
        $this->syModel = new SYModel();
        $this->subjectModel = new SubjectsModel();
        $this->levelModel = new LevelsModel();
        $this->semModel = new SemesterModel();
        $this->cdModel = new CurriculumDataModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Curriculums',
            'page_heading' => 'CURRICULUMS! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['curriculumdata'] = $this->curriculumModel->where('isdel', 0)->findAll();
        $data['coursedata'] = $this->courseModel->where('courisdel', 0)->findAll();
        $data['sydata'] = $this->syModel->where('syisdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'course' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Program is required.',
                    ],
                ],
                'sy' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'School year is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                $data = [
                    'course' => $this->request->getVar('course'),
                    'sy' => $this->request->getVar('sy'),
                    'status' => '0',
                    'isdel' => '0',
                ];
                $this->curriculumModel->save($data);
                session()->setTempdata('addsuccess','Curriculum added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('curriculumview', $data);
    }
    public function deleteCurriculum($id=null) {
        $data = [
            'isdel' => '1',
        ];

        $this->curriculumModel->where('currid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Curriculum is deleted!', 2);
        return redirect()->to(base_url()."curriculum");
    }
    public function updateCurriculum($id=null) {
        if($this->request->is('post')) {
            $data = [
                'course' => $this->request->getVar('course'),
                'sy' => $this->request->getVar('sy'),
            ];

            $this->curriculumModel->where('currid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."curriculum");
        }
    }
    public function curriculumsetup($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | Curriculums',
            'page_heading' => 'CURRICULUMS! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['curriculumdata'] = $this->curriculumModel->where('currid', $id)->findAll();
        $data['subjectdata'] = $this->subjectModel->where('isdel', 0)->findAll();
        $data['leveldata'] = $this->levelModel->where('levelisdel', 0)->findAll();
        $data['semdata'] = $this->semModel->where('semisdel', 0)->findAll();
        $data['cddata'] = $this->cdModel->where('curriculumid', $id)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'subject' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Subject is required.',
                    ],
                ],
                'level' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Level is required.',
                    ],
                ],
                'sem' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Semester is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                $subjectid = $this->request->getVar('subject');
                $FINDSUBJECT = $this->subjectModel->where('subid', $subjectid)->findAll();
                foreach($FINDSUBJECT as $FINDSUB){
                    $PRERE = $FINDSUB['prerequisite'];
                }

                $data = [
                    'curriculumid' => $id,
                    'subjectsid' => $this->request->getVar('subject'),
                    'level' => $this->request->getVar('level'),
                    'sem' => $this->request->getVar('sem'),
                    'prerequisite' => $PRERE,
                ];
                $this->cdModel->save($data);
                session()->setTempdata('addsuccess','Subject added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('curriculumsetup', $data);
    }
}
