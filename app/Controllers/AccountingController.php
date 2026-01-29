<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\RatesModel;
use App\Models\SYModel;
use App\Models\SemesterModel;
use App\Models\CoursesModel;
use App\Models\LevelsModel;
use App\Models\RateDuesModel;
use App\Models\RateOtherFeesModel;
use App\Models\chartofAccountsModel;
class AccountingController extends BaseController
{
    public $usersModel;
    public $ratesModel;
    public $syModel;
    public $semModel;
    public $coursesModel;
    public $levelsModel;
    public $rdModel;
    public $rofModel;
    public $coaModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->ratesModel = new RatesModel();
        $this->syModel = new SYModel();
        $this->semModel = new SemesterModel();
        $this->coursesModel = new CoursesModel();
        $this->levelsModel = new LevelsModel();
        $this->rdModel = new RateDuesModel();
        $this->rofModel = new RateOtherFeesModel();
        $this->coaModel = new ChartofAccountsModel();
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
        $data['rddata'] = $this->rdModel->where('rateid', $id)->findAll();
        $data['rofdata'] = $this->rofModel->where('rateid', $id)->findAll();

        if($this->request->is('post')) {
            $data = [
                'major' => $this->request->getVar('major'),
                'minor' => $this->request->getVar('minor'),
                'nstp01' => $this->request->getVar('nstp01'),
                'nstp02' => $this->request->getVar('nstp02'),
            ];
            $this->ratesModel->where('rateid', $id)->update($id, $data);
            session()->setTempdata('addsuccess','Save successfully', 3);
            return redirect()->to(current_url());
        }

        return view('ratessetup', $data);
    }
    public function ratedues($id=null) {
        if($this->request->is('post')) {
            $numberofdues = $this->rdModel->where('rateid', $id)->countAllResults();
            $newcount = $numberofdues + 1;
            // print_r($newcount);
            $data = [
                'rateid' => $id,
                'name' => "Due Date ".$newcount,
                'due' => $this->request->getVar('due'),
            ];

            $this->rdModel->save($data);
            return redirect()->to(base_url()."rates/setup/".$id);
        }
    }
    public function rateduesupdate($id=null) {
        if($this->request->is('post')) {
            $data = [
                'due' => $this->request->getVar('due'),
            ];

            $this->rdModel->where('rdid', $id)->update($id, $data);
            return redirect()->to(base_url()."rates/setup/".$id);
        }
    }
    public function raterof($id=null) {
        if($this->request->is('post')) {
            $data = [
                'rateid' => $id,
                'name' => $this->request->getVar('ratename'),
                'otherfees' => $this->request->getVar('otherfees'),
            ];

            $this->rofModel->save($data);
            return redirect()->to(base_url()."rates/setup/".$id);
        }
    }
    public function raterofupdate($id=null) {
        if($this->request->is('post')) {
            $data = [
                'name' => $this->request->getVar('name'),
                'otherfees' => $this->request->getVar('otherfee'),
            ];

            $this->rofModel->where('rofid', $id)->update($id, $data);
            return redirect()->to(base_url()."rates/setup/".$id);
        }
    }
    public function chartofAccounts() {
        $data = [
            'page_title' => 'Holy Cross College | Chart Of Accounts',
            'page_heading' => 'CHART OF ACCOUNTS! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['coadata'] = $this->coaModel->where('isdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'code' => [
                    'rules' => 'required|is_unique[chartofaccounts.accountcode]',
                    'errors' => [
                        'required' => 'Account code is required.',
                        'is_unique' => 'This account code is already exists.'
                    ],
                ],
                'name' => [
                    'rules' => 'required|is_unique[chartofaccounts.accountname]',
                    'errors' => [
                        'required' => 'Account name is required.',
                        'is_unique' => 'This account name is already exists.'
                    ],
                ],
                'type' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Account type is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                $coadata = [
                    'accountcode' => $this->request->getVar('code'),
                    'accountname' => $this->request->getVar('name'),
                    'accounttype' => $this->request->getVar('type'),
                    'parentaccountid' => $this->request->getVar('parentaccount'),
                    'description' => $this->request->getVar('description'),
                    'isdel' => 0,
                ];
                $this->coaModel->save($coadata);
                session()->setTempdata('addsuccess','Account added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('accounting/chartsofaccountsview', $data);
    }
    public function deleteCOA($id=null) {
        $data = [
            'isdel' => '1',
        ];
        $this->coaModel->where('accountid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Account is deleted!', 2);
        return redirect()->to(base_url()."chartofaccounts");
    }
    public function updateCOA($id=null) {
        if($this->request->is('post')) {
            $data = [
                'accountcode' => $this->request->getVar('code'),
                'accountname' => $this->request->getVar('name'),
                'accounttype' => $this->request->getVar('type'),
                'parentaccountid' => $this->request->getVar('parentaccount'),
                'description' => $this->request->getVar('description'),
            ];

            $this->coaModel->where('accountid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."chartofaccounts");
        }
    }
}
