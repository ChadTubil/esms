<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\RatesModel;
use App\Models\SYModel;
use App\Models\SemesterModel;
use App\Models\CoursesModel;
use App\Models\LevelsModel;
class AccountingController extends BaseController
{
    public $usersModel;
    public $ratesModel;
    public $syModel;
    public $semModel;
    public $coursesModel;
    public $levelsModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->ratesModel = new RatesModel();
        $this->syModel = new SYModel();
        $this->semModel = new SemesterModel();
        $this->coursesModel = new CoursesModel();
        $this->levelsModel = new LevelsModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | College Rates',
            'page_heading' => 'COLLEGE RATES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['ratesdata'] = $this->ratesModel->findAll();
        $data['sydata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semdata'] = $this->semModel->where('semisdel', 0)->findAll();
        $data['coursedata'] = $this->coursesModel->where('courisdel', 0)->findAll();
        $data['leveldata'] = $this->levelsModel->where('levelisdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'sy' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'School year is required.',
                    ],
                ],
                'sem' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Semester is required.',
                    ],
                ],
                'program' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Program is required.',
                    ],
                ],
                'year' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Level is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                $data = [
                    'sy' => $this->request->getVar('sy'),
                    'sem' => $this->request->getVar('sem'),
                    'course' => $this->request->getVar('program'),
                    'year' => $this->request->getVar('year'),
                ];
                $this->ratesModel->save($data);
                session()->setTempdata('addsuccess','Rate added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('rates', $data);
    }
    public function ratesSetup($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | College Rates',
            'page_heading' => 'COLLEGE RATES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['ratesdata'] = $this->ratesModel->where('rateid', $id)->findAll();

        if($this->request->is('post')) {
            $data = [
                'major' => $this->request->getVar('major'),
                'minor' => $this->request->getVar('minor'),
                'nstp01' => $this->request->getVar('nstp01'),
                'nstp02' => $this->request->getVar('nstp02'),
                'registrationfee' => $this->request->getVar('registrationfee'),
                'library' => $this->request->getVar('library'),
                'laboratory' => $this->request->getVar('laboratory'),
                'athletics' => $this->request->getVar('athletics'),
                'medical' => $this->request->getVar('medical'),
                'guidance' => $this->request->getVar('guidance'),
                'schoolorgan' => $this->request->getVar('schoolorgan'),
                'id' => $this->request->getVar('id'),
                'av' => $this->request->getVar('av'),
                'prisaa' => $this->request->getVar('prisaa'),
                'internetfee' => $this->request->getVar('internetfee'),
                'studenthb' => $this->request->getVar('studenthb'),
                'insurance' => $this->request->getVar('insurance'),
                'rso' => $this->request->getVar('rso'),
                'cultural' => $this->request->getVar('cultural'),
                'studentcouncil' => $this->request->getVar('studentcouncil'),
                'learningsystem' => $this->request->getVar('learningsystem'),
                'due1' => $this->request->getVar('due1'),
                'due2' => $this->request->getVar('due2'),
                'due3' => $this->request->getVar('due3'),
                'due4' => $this->request->getVar('due4'),
            ];
            $this->ratesModel->where('rateid', $id)->update($id, $data);
            session()->setTempdata('addsuccess','Save successfully', 3);
            return redirect()->to(current_url());
        }

        return view('ratessetup', $data);
    }
}
