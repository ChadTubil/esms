<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\EmployeesModel;
use App\Models\RatesModel;
use App\Models\SYModel;
use App\Models\SemesterModel;
use App\Models\CoursesModel;
use App\Models\LevelsModel;
use App\Models\RateDuesModel;
use App\Models\RateOtherFeesModel;
use App\Models\ChartofAccountsModel;
use App\Models\FeeStructureModel;
use App\Models\StudentsModel;
use App\Models\StudentAccountsModel;
use App\Models\StudentAccountAssessmentModel;
use App\Models\PaymentTransactionsModel;
use App\Models\PaymentAllocationModel;
use App\Models\ClustersModel;
use App\Models\SHSRatesModel;
use App\Models\SHSRateDuesModel;
use App\Models\SHSRateOtherFeesModel;
use App\Models\SHSStudentsModel;
use App\Models\StudentsLedgerModel;
use App\Models\DiscountsModel;
use TCPDF;
use NumberFormatter; // Add this line
class AccountingController extends BaseController
{
    public $usersModel;
    public $empModel;
    public $ratesModel;
    public $syModel;
    public $semModel;
    public $coursesModel;
    public $levelsModel;
    public $rdModel;
    public $rofModel;
    public $coaModel;
    public $feeStructureModel;
    public $studentsModel;
    public $studentAccountsModel;
    public $studentAccountsAssessmentModel;
    public $paymentransactionsModel;
    public $paymentAllocationModel;
    public $clustersModel;
    public $shsRatesModel;
    public $shsRateDuesModel;
    public $shsRateOtherFeesModel;
    public $shsStudentsModel;
    public $studentsLedgerModel;
    public $discountsModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->empModel = new EmployeesModel();
        $this->ratesModel = new RatesModel();
        $this->syModel = new SYModel();
        $this->semModel = new SemesterModel();
        $this->coursesModel = new CoursesModel();
        $this->levelsModel = new LevelsModel();
        $this->rdModel = new RateDuesModel();
        $this->rofModel = new RateOtherFeesModel();
        $this->coaModel = new ChartofAccountsModel();
        $this->feeStructureModel = new FeeStructureModel();
        $this->studentsModel = new StudentsModel();
        $this->studentAccountsModel = new StudentAccountsModel();
        $this->studentAccountsAssessmentModel = new StudentAccountAssessmentModel();
        $this->paymentransactionsModel = new PaymentTransactionsModel();
        $this->paymentAllocationModel = new PaymentAllocationModel();
        $this->clustersModel = new ClustersModel();
        $this->shsRatesModel = new SHSRatesModel();
        $this->shsRateDuesModel = new SHSRateDuesModel();
        $this->shsRateOtherFeesModel = new SHSRateOtherFeesModel();
        $this->shsStudentsModel = new SHSStudentsModel();
        $this->studentsLedgerModel = new StudentsLedgerModel();
        $this->discountsModel = new DiscountsModel();
        $this->session = session();
    }
    public function index() {
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
    public function shsRates() {
        $data = [
            'page_title' => 'Holy Cross College | SHS Rates',
            'page_heading' => 'SHS RATES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['sydata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['clusterdata'] = $this->clustersModel->where('isdel', '0')->findAll();
        $data['shsratesdata'] = $this->shsRatesModel
        ->select('rates_shs.*, clusters.*')
        ->join('clusters', 'rates_shs.cluster = clusters.cluid')
        ->where('rates_shs.isdel', '0')->findAll();

        if($this->request->is('post')) {
            $rules = [
                'sy' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'School year is required.',
                    ],
                ],
                'level' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Level is required.',
                    ],
                ],
                'cluster' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Cluster is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                $data = [
                    'sy' => $this->request->getVar('sy'),
                    'level' => $this->request->getVar('level'),
                    'cluster' => $this->request->getVar('cluster'),
                ];
                $this->shsRatesModel->save($data);
                session()->setTempdata('success','Rate added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('accounting/shs-rates', $data);
    }
    public function shsratesSetup($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | SHS Rates Setup',
            'page_heading' => 'SHS RATES SETUP! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['shsratesdata'] = $this->shsRatesModel
        ->select('rates_shs.*, clusters.*')
        ->join('clusters', 'rates_shs.cluster = clusters.cluid')
        ->where('rates_shs.rateid', $id)->findAll();

        $data['shsrddata'] = $this->shsRateDuesModel->where('rateid', $id)->findAll();
        $data['shsrofdata'] = $this->shsRateOtherFeesModel->where('rateid', $id)->findAll();

        if($this->request->is('post')) {
            $data = [
                'tf' => $this->request->getVar('tf'),
            ];
            $this->shsRatesModel->where('rateid', $id)->update($id, $data);
            session()->setTempdata('addsuccess','Save successfully', 3);
            return redirect()->to(current_url());
        }

        return view('accounting/shs-ratessetup', $data);
    }
    public function shsratesDues($id=null) {
        if($this->request->is('post')) {
            $numberofdues = $this->shsRateDuesModel->where('rateid', $id)->countAllResults();
            $newcount = $numberofdues + 1;
            // print_r($newcount);
            $data = [
                'rateid' => $id,
                'name' => "Due Date ".$newcount,
                'due' => $this->request->getVar('due'),
            ];

            $this->shsRateDuesModel->save($data);
            return redirect()->to(base_url()."shs-rates/setup/".$id);
        }
    }
    public function shsratesRof($id=null) {
        if($this->request->is('post')) {
            $data = [
                'rateid' => $id,
                'name' => $this->request->getVar('ratename'),
                'otherfees' => $this->request->getVar('otherfees'),
            ];

            $this->shsRateOtherFeesModel->save($data);
            return redirect()->to(base_url()."shs-rates/setup/".$id);
        }
    }
    public function shsratesDuesUpdate($id=null) {
        $LocateRateID = $this->shsRateDuesModel->where('rdid', $id)->findAll();
        foreach($LocateRateID as $rateid) {
            $rateID = $rateid['rateid'];
        }
        if($this->request->is('post')) {
            $data = [
                'due' => $this->request->getVar('due'),
            ];

            $this->shsRateDuesModel->where('rdid', $id)->update($id, $data);
            return redirect()->to(base_url()."shs-rates/setup/".$rateID);
        }
    }
    public function shsratesRofUpdate($id=null) {
        $LocateRateID = $this->shsRateOtherFeesModel->where('rofid', $id)->findAll();
        foreach($LocateRateID as $rateid) {
            $rateID = $rateid['rateid'];
        }
        if($this->request->is('post')) {
            $data = [
                'name' => $this->request->getVar('name'),
                'otherfees' => $this->request->getVar('otherfee'),
            ];

            $this->shsRateOtherFeesModel->where('rofid', $id)->update($id, $data);
            return redirect()->to(base_url()."shs-rates/setup/".$rateID);
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
                return redirect()->to(base_url('chartofaccounts'));
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
    public function feeStructure() {
        $data = [
            'page_title' => 'Holy Cross College | Fee Structure',
            'page_heading' => 'FEE STRUCTURE MANAGEMENT',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['sydata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['semdata'] = $this->semModel->where('semisdel', 0)->findAll();
        // $data['coursedata'] = $this->coursesModel->where('courisdel', 0)->findAll();
        $data['coadata'] = $this->coaModel->where('isdel', 0)->findAll();

        $Clusterdata = $this->clustersModel->where('isdel', '0')->findAll();
        $Coursedata = $this->coursesModel->where('courisdel', 0)->findAll();
        $data['coursedata'] = array_merge($Coursedata, $Clusterdata);

        $data['feestructuredata'] = $this->feeStructureModel->where('isdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'code' => [
                    'rules' => 'required|is_unique[feestructure.feecode]',
                    'errors' => [
                        'required' => 'Fee code is required.',
                        'is_unique' => 'This fee code is already exists.'
                    ],
                ],
                'name' => [
                    'rules' => 'required|is_unique[feestructure.feename]',
                    'errors' => [
                        'required' => 'Account name is required.',
                        'is_unique' => 'This account name is already exists.'
                    ],
                ],
                'coa' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Chart of Account is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                $feedata = [
                    'feecode' => $this->request->getVar('code'),
                    'feename' => $this->request->getVar('name'),
                    'feedescription' => $this->request->getVar('description'),
                    'amount' => $this->request->getVar('amount'),
                    'accountid' => $this->request->getVar('coa'),
                    'course' => $this->request->getVar('course'),
                    'sy' => $this->request->getVar('sy'),
                    'semester' => $this->request->getVar('sem'),
                    'ismandatory' => $this->request->getVar('mandatory'),
                    'createdate' => date('Y-m-d'),
                    'isdel' => 0,
                ];
                $this->feeStructureModel->save($feedata);
                session()->setTempdata('addsuccess','Fee added successfully', 3);
                return redirect()->to(base_url('feestructure'));
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('accounting/feestructureview', $data);
    }
    public function deleteFEE($id=null) {
        $data = [
            'isdel' => '1',
        ];

        $this->feeStructureModel->where('feeid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Fee is deleted!', 2);
        return redirect()->to(base_url()."feestructure");
    }
    public function updateFEE($id=null) {
        if($this->request->is('post')) {
            $data = [
                'feecode' => $this->request->getVar('code'),
                'feename' => $this->request->getVar('name'),
                'feedescription' => $this->request->getVar('description'),
                'amount' => $this->request->getVar('amount'),
                'accountid' => $this->request->getVar('coa'),
                'course' => $this->request->getVar('course'),
                'sy' => $this->request->getVar('sy'),
                'semester' => $this->request->getVar('sem'),
                'ismandatory' => $this->request->getVar('mandatory'),
                'createdate' => date('Y-m-d'),
                'isdel' => 0,
            ];

            $this->feeStructureModel->where('feeid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."feestructure");
        }
    }
    public function discount(){
        $data = [
            'page_title' => 'Holy Cross College | Discount Management',
            'page_heading' => 'DISCOUNT MANAGEMENT',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['discountdata'] = $this->discountsModel->where('isdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'discountname' => [
                    'rules' => 'required|is_unique[discount.discountname]',
                    'errors' => [
                        'required' => 'Discount name is required.',
                        'is_unique' => 'This discount name is already exists.'
                    ],
                ],
            ];
            if($this->validate($rules)){
                $discountdata = [
                    'discounttype' => $this->request->getVar('discounttype'),
                    'discountname' => $this->request->getVar('discountname'),
                    'discountpercentage' => $this->request->getVar('percentage'),
                    'discountamount' => $this->request->getVar('amount'),
                    'feetype' => $this->request->getVar('feetype'),
                    'startdate' => $this->request->getVar('startdate'),
                    'enddate' => $this->request->getVar('enddate'),
                    'terms' => $this->request->getVar('terms'),
                    'status' => 'Active',
                    'createddate' => date('Y-m-d'),
                ];
                $this->discountsModel->save($discountdata);
                session()->setTempdata('success','Discount added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('accounting/discountview', $data);
    }
    public function updatediscount($id=null){
        if($this->request->is('post')) {
            $discountdata = [
                'discounttype' => $this->request->getVar('discounttype'),
                'discountname' => $this->request->getVar('discountname'),
                'discountpercentage' => $this->request->getVar('percentage'),
                'discountamount' => $this->request->getVar('amount'),
                'feetype' => $this->request->getVar('feetype'),
                'startdate' => $this->request->getVar('startdate'),
                'enddate' => $this->request->getVar('enddate'),
                'terms' => $this->request->getVar('terms'),
            ];

            $this->discountsModel->where('discountid', $id)->update($id, $discountdata);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."discount");
        }
    }
    public function deletediscount($id=null) {
        $discountdata = [
            'isdel' => '1',
        ];

        $this->discountsModel->where('discountid', $id)->update($id, $discountdata);
        session()->setTempdata('updatesuccess', 'Delete Successful!', 2);
        return redirect()->to(base_url()."discount");
    }
    public function activediscount($id=null) {
        $discountdata = [
            'status' => 'Active',
        ];

        $this->discountsModel->where('discountid', $id)->update($id, $discountdata);
        session()->setTempdata('updatesuccess', 'Delete Successful!', 2);
        return redirect()->to(base_url()."discount");
    }
    public function expireddiscount($id=null) {
        $discountdata = [
            'status' => 'Expired',
        ];

        $this->discountsModel->where('discountid', $id)->update($id, $discountdata);
        session()->setTempdata('updatesuccess', 'Delete Successful!', 2);
        return redirect()->to(base_url()."discount");
    }
    public function studentAccounts() {
        $data = [
            'page_title' => 'Holy Cross College | Student Accounts',
            'page_heading' => 'STUDENT ACCOUNTS MANAGEMENT',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $StudentsCondition = array('studisdel' => 0);

        $data['studentdata'] = $this->studentsModel->where($StudentsCondition)->findAll();

        if($this->request->is('post')){
            $searchStudent = $this->request->getVar('searchstud');

            if($searchStudent == ''){
                $students = $this->studentsModel->where('studisdel', 0)->findAll();
                $shsStudents = $this->shsStudentsModel->where('studisdel', 0)->findAll();
                $resultStudent = array_merge($students, $shsStudents);
                foreach($resultStudent as $key => $student) {
                    $accountCount = $this->studentAccountsModel
                        ->where('studentno', $student['studentno'])
                        ->where('isdel', 0)
                        ->countAllResults();
                    $resultStudent[$key]['account_count'] = $accountCount;
                }
                $data['resultStudent'] = $resultStudent;
                return view('accounting/studentaccountssearchresultview', $data);

            }
            else{
                $students = $this->studentsModel
                ->like('studentno', $searchStudent)
                ->orLike('studln', $searchStudent)
                ->orLike('studfn', $searchStudent)
                ->orLike('studfullname', $searchStudent)
                ->where('studisdel', 0)->findAll();
                $shsStudents = $this->shsStudentsModel
                ->like('studentno', $searchStudent)
                ->orLike('studln', $searchStudent)
                ->orLike('studfn', $searchStudent)
                ->orLike('studfullname', $searchStudent)
                ->where('studisdel', 0)->findAll();
                $resultStudent = array_merge($students, $shsStudents);

                // Add account count for each student
                foreach($resultStudent as $key => $student) {
                    $accountCount = $this->studentAccountsModel
                        ->where('studentno', $student['studentno'])
                        ->where('isdel', 0)
                        ->countAllResults();
                    $resultStudent[$key]['account_count'] = $accountCount;
                }
                
                $data['resultStudent'] = $resultStudent;
                return view('accounting/studentaccountssearchresultview', $data);
            }
        }

        return view('accounting/studentaccountssearchview', $data);
    }
    public function viewStudentAccounts($id=null){
        $data = [
            'page_title' => 'Holy Cross College | Student Accounts',
            'page_heading' => 'STUDENT ACCOUNTS MANAGEMENT',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        // $data['studentdata'] = $this->studentsModel->where('studentno', $id)->findAll();
        $students = $this->studentsModel->where('studentno', $id)->findAll();
        $shsStudents = $this->shsStudentsModel->where('studentno', $id)->findAll();
        $data['studentdata'] = array_merge($students, $shsStudents);
        
        $data['studentaccountsdata'] = $this->studentAccountsModel->where('studentno', $id)->where('isdel', 0)->findAll();

        return view('accounting/studentaccountsview', $data);
    }
    public function viewStudentAccountsDetails($studentno=null, $studentaccountno=null) {
        $data = [
            'page_title' => 'Holy Cross College | Student Accounts',
            'page_heading' => 'STUDENT ACCOUNTS MANAGEMENT',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        // $data['studentdata'] = $this->studentsModel->where('studentno', $studentno)->findAll();
        $students = $this->studentsModel->where('studentno', $studentno)->findAll();
        $shsStudents = $this->shsStudentsModel->where('studentno', $studentno)->findAll();
        $data['studentdata'] = array_merge($students, $shsStudents);
        foreach($data['studentdata'] as $allstd){
            $STUDENTFULLNAME = $allstd['studfullname'];
            $STUDENTNO = $allstd['studentno'];

        }
        $data['studaccdataforpayment'] = $this->studentAccountsModel->findAll();
        $data['studentaccountsdata'] = $this->studentAccountsModel->where('studentno', $studentno)->where('isdel', 0)->findAll();
        $data['studentaccountsassessmentdata'] = $this->studentAccountsAssessmentModel->where('said', $studentaccountno)->where('isdel', 0)->findAll();
        $data['coadata'] = $this->coaModel->where('isdel', 0)->findAll();

        $data['allfeestructuredata'] = $this->feeStructureModel
            ->where('isdel', 0)
            ->findAll();

        $assessments = $this->studentAccountsAssessmentModel
            ->where('said', $studentaccountno)
            ->where('isdel', 0)
            ->findAll();
            
        foreach($assessments as $key => $assessment) {
            // Get fee details from feestructure table
            $feeDetails = $this->feeStructureModel
                ->where('feeid', $assessment['feeid'])
                ->where('isdel', 0)
                ->first();
            
            if($feeDetails) {
                $assessments[$key]['feecode'] = $feeDetails['feecode'];
                $assessments[$key]['feename'] = $feeDetails['feename'];
                $assessments[$key]['accountid'] = $feeDetails['accountid'];
            } else {
                $assessments[$key]['feecode'] = 'N/A';
                $assessments[$key]['feename'] = 'Unknown Fee';
                $assessments[$key]['accountid'] = 'N/A';
            }
        }
        
        $data['studentaccountsassessmentdata'] = $assessments;
        // GET TOTAL ASSESSMENT, TOTAL PAYMENTS, TOTAL BALANCE, TOTAL DISCOUNTS
        $data['studacctotalassessment'] = $this->studentAccountsModel
        ->select('studentsaccounts.*, SUM(studentassessment.discountamount) as totaldiscounts')
        ->join('studentassessment', 'studentsaccounts.said = studentassessment.said')
        ->where('studentassessment.said', $studentaccountno)->findAll();
        // PAYMENT TRANSACTIONS HISTORY FOR ALLOCATION
        $data['paymenttransactiondata'] = $this->paymentransactionsModel
        ->where('paymenttransactions.studfullname', $STUDENTFULLNAME)
        ->where('paymenttransactions.paymentstatus', 'Paid')
        ->orWhere('paymenttransactions.studfullname', $STUDENTNO)
        ->findAll();
        // PAYMENT TRANSACTIONS HISTORY
        $data['paymenthistorydata'] = $this->paymentransactionsModel
        ->where('paymenttransactions.studfullname', $STUDENTFULLNAME)
        ->orWhere('paymenttransactions.studfullname', $STUDENTNO)
        ->where('paymenttransactions.paymentstatus', 'Paid')
        ->findAll();
        // DISCOUNT DATA
        $discountall = $this->discountsModel->where('isdel', '0')->where('studentno', '')->findAll();
        $discountstudent = $this->discountsModel->where('studentno', $STUDENTNO)->findAll();
        $data['discountdata'] = array_merge($discountall, $discountstudent);
        
        return view('accounting/studentaccountassessmentview', $data);
    }
    public function viewStudentAccountsDetailsAdd(){
        $uid = session()->get('logged_user');
        $userdata = $this->usersModel->where('uid', $uid)->findAll();
        foreach($userdata as $userd){
            $USERACCOUNTID = $userd['uaccountid'];
        }
        $empdata = $this->empModel->where('empnum', $USERACCOUNTID)->findAll();
        foreach($empdata as $empd){
            $FULLNAME = $empd['empfullname'];
        }
        if($this->request->is('post')) {
            $studentno = $this->request->getVar('studentno');
            $studentaccountno = $this->request->getVar('accountno');
            $feeid = $this->request->getVar('selectedfeeid');
            $checkExisting = $this->studentAccountsAssessmentModel
                ->where('said', $studentaccountno)
                ->where('feeid', $feeid)
                ->where('isdel', 0)
                ->first();
            if($checkExisting) {
                session()->setTempdata('message','This fee is already added to the assessment.', 3);
                return redirect()->to(base_url()."student-accounts/view/details/".$studentno."/".$studentaccountno);
            } else {
                $FEES = $this->feeStructureModel->where('feeid', $feeid)->findAll();
                $STUDENTACCOUNT = $this->studentAccountsModel->where('said', $studentaccountno)->findAll();
                foreach($STUDENTACCOUNT as $account) {
                    $TOTALASSESSMENT = $account['totalassessment'];
                    $TOTALBALANCE = $account['totalbalance'];
                }
                foreach($FEES as $fee) {
                    $amount = $fee['amount'];
                    $discount = $fee['discount'] ?? 0;
                    $FEENAME = $fee['feename'];
                }
                $data = [
                    'said' => $studentaccountno,
                    'studentno' => $studentno,
                    'feeid' => $this->request->getVar('selectedfeeid'),
                    'amount' => $amount,
                    'discountamount' => $discount,
                    'netamount' => $amount,
                    'balance' => $amount,
                    'createddate' => date('Y-m-d'),
                    'assessmentdate' => date('Y-m-d'),
                    'isdel' => 0,
                ];
                $studAccData = [
                    'totalassessment' => $TOTALASSESSMENT + $amount,
                    'totalbalance' => $TOTALBALANCE + $amount,
                    'updateddate' => date('Y-m-d'),
                ];
                $studentLedgerData = [
                    'studentno' => $studentno,
                    'said' => $studentaccountno,
                    'transactiondate' => date('Y-m-d'),
                    'transactiontype' => 'Assessment',
                    'description' => $FEENAME,
                    'credit' => $amount,
                    'createddate' => date('Y-m-d'),
                    'createdby' => $FULLNAME,

                ];
                $this->studentAccountsAssessmentModel->save($data);
                $this->studentAccountsModel->where('said', $studentaccountno)->set($studAccData)->update();
                $this->studentsLedgerModel->save($studentLedgerData);
                session()->setTempdata('message','Fee added successfully', 3);
                return redirect()->to(base_url()."student-accounts/view/details/".$studentno."/".$studentaccountno);
            }
            
        }
    }
    public function viewStudentAccountsAllocate($paymenttransid=null, $studaccountassessid=null){
        $uid = session()->get('logged_user');
        $userdata = $this->usersModel->where('uid', $uid)->findAll();
        foreach($userdata as $userd){
            $USERACCOUNTID = $userd['uaccountid'];
        }
        $empdata = $this->empModel->where('empnum', $USERACCOUNTID)->findAll();
        foreach($empdata as $empd){
            $FULLNAME = $empd['empfullname'];
        }

        $PAYMENTTRANSACTIONDATA = $this->paymentransactionsModel
        ->where('paymentid', $paymenttransid)->findAll();
        foreach($PAYMENTTRANSACTIONDATA as $PTD) {
            $AMOUNTPAID = $PTD['amountpaid'];
            
        }
        $STUDENTACCOUNTASSESSMENTDATA = $this->studentAccountsAssessmentModel
        ->select('studentassessment.*, feestructure.*, studentsaccounts.*')
        ->join('feestructure', 'feestructure.feeid = studentassessment.feeid')
        ->join('studentsaccounts', 'studentsaccounts.said = studentassessment.said')
        ->where('sadid', $studaccountassessid)->findAll();

        foreach($STUDENTACCOUNTASSESSMENTDATA as $SAAD) {
            $SAID = $SAAD['said'];
            $STUDNO = $SAAD['studentno'];
            $TOTALPAIDAMOUNT = $SAAD['paidamount'];
            $TOTALPAYMENTS = $SAAD['totalpayments'];
            $TOTALBALANCE = $SAAD['totalbalance'];
            $FEENAME = $SAAD['feename'];
        }

        $allocatedata = [
            'paymentid' => $paymenttransid,
            'sadid' => $studaccountassessid,
            'amountallocated' => $AMOUNTPAID,
            'allocateddate' => date('Y-m-d'),
            'allocatedby' => $FULLNAME,

        ];
        $paymenttransdata = [
            'paymentstatus' => 'Allocated',
        ];

        $studentaccassessdata = [
            'paidamount' => $TOTALPAIDAMOUNT +$AMOUNTPAID,
            'balance' => $TOTALBALANCE - $AMOUNTPAID,
        ];

        $studentaccountsdata = [
            'totalpayments' => $TOTALPAYMENTS + $AMOUNTPAID,
            'totalbalance' => $TOTALBALANCE - $AMOUNTPAID,
            'updateddate' => date('Y-m-d'),
        ];

        $studentLedgerData = [
            'studentno' => $STUDNO,
            'said' => $SAID,
            'transactiondate' => date('Y-m-d'),
            'transactiontype' => 'Payment',
            'description' => $FEENAME,
            'debit' => $AMOUNTPAID,
            'createddate' => date('Y-m-d'),
            'createdby' => $FULLNAME,
        ];

        $this->paymentAllocationModel->save($allocatedata);
        $this->paymentransactionsModel->where('paymentid', $paymenttransid)->update($paymenttransid, $paymenttransdata);
        $this->studentAccountsAssessmentModel->where('sadid', $studaccountassessid)->update($studaccountassessid, $studentaccassessdata);
        $this->studentAccountsModel->where('said', $SAID)->update($SAID, $studentaccountsdata);
        $this->studentsLedgerModel->save($studentLedgerData);
        session()->setTempdata('message','Fee added successfully', 3);
        return redirect()->to(base_url()."student-accounts/view/details/".$STUDNO."/".$SAID);
    }
    public function viewStudentAccountsAddDiscount($discountid=null, $studaccountassessid=null){
        $uid = session()->get('logged_user');
        $userdata = $this->usersModel->where('uid', $uid)->findAll();
        foreach($userdata as $userd){
            $USERACCOUNTID = $userd['uaccountid'];
        }
        $empdata = $this->empModel->where('empnum', $USERACCOUNTID)->findAll();
        foreach($empdata as $empd){
            $FULLNAME = $empd['empfullname'];
        }

        $STUDENTACCOUNTASSESSMENTDATA = $this->studentAccountsAssessmentModel
        ->select('studentassessment.*, studentsaccounts.*')
        ->join('studentsaccounts', 'studentsaccounts.said = studentassessment.said')
        ->where('studentassessment.sadid', $studaccountassessid)->findAll();
        foreach($STUDENTACCOUNTASSESSMENTDATA as $SAAD) {
            $SAID = $SAAD['said'];
            $STUDENTNO = $SAAD['studentno'];
            $TOTALPAYMENTS = $SAAD['totalpayments'];
            $TOTALBALANCE = $SAAD['totalbalance'];
            $ASSESSMENTAMOUNT = $SAAD['amount'];
            $ASSESSMENTNETAMOUNT = $SAAD['netamount'];
            $ASSESSMENTDISCOUNT = $SAAD['discountamount'];
            $TOTALASSESSMENTPAIDAMOUNT = $SAAD['paidamount'];
            $TOTALASSESSMENTBALANCE = $SAAD['balance'];
        }

        $DISCOUNTDATA = $this->discountsModel->where('discountid', $discountid)->findAll();
        foreach($DISCOUNTDATA as $dd) {
            $DISCOUNTPERCENTAGE = $dd['discountpercentage'];
            $DISCOUNTAMOUNT = $dd['discountamount'];
            if($DISCOUNTAMOUNT == '0.00'){
                $DISCOUNT = '0.'.$DISCOUNTPERCENTAGE;
            }else{
                $DISCOUNT = $DISCOUNTAMOUNT;
            }
        }
        
        $studentaccountdata = [
            'totalpayments' => $TOTALPAYMENTS + $DISCOUNT,
            'totalbalance' => $TOTALBALANCE - $DISCOUNT,
            'updateddate' => date('Y-m-d'),
        ];

        $studentaccassdata = [
            'discountamount' => $ASSESSMENTDISCOUNT + $DISCOUNT,
            'netamount' => $ASSESSMENTAMOUNT - $DISCOUNT,
            'paidamount' => $TOTALASSESSMENTPAIDAMOUNT + $DISCOUNT,
            'balance' => $TOTALASSESSMENTBALANCE - $DISCOUNT,
            'updateddate' => date('Y-m-d'),
        ];

        $studentLedgerData = [
            'studentno' => $STUDENTNO,
            'said' => $SAID,
            'transactiondate' => date('Y-m-d'),
            'transactiontype' => 'Discount',
            'description' => $dd['discountname'],
            'debit' => $DISCOUNT,
            'createddate' => date('Y-m-d'),
            'createdby' => $FULLNAME,
        ];

        $this->studentAccountsModel->where('said', $SAID)->update($SAID, $studentaccountdata);
        $this->studentAccountsAssessmentModel->where('sadid', $studaccountassessid)->update($studaccountassessid, $studentaccassdata);
        $this->studentsLedgerModel->save($studentLedgerData);
        session()->setTempdata('message','Discount added successfully', 3);
        return redirect()->to(base_url()."student-accounts/view/details/".$STUDENTNO."/".$SAID);
    }
    public function viewStudentAccountsDetailsPayment($studentno=null, $studentaccountno=null){
        $uid = session()->get('logged_user');
        $userdata = $this->usersModel->where('uid', $uid)->findAll();
        foreach($userdata as $userd){
            $USERACCOUNTID = $userd['uaccountid'];
        }
        $empdata = $this->empModel->where('empnum', $USERACCOUNTID)->findAll();
        foreach($empdata as $empd){
            $FULLNAME = $empd['empfullname'];
        }
        if($this->request->is('post')) {
            $paymenttransactionsdata = [
                'studentno' => $this->request->getVar('studentno'),
                'studfullname' => $this->request->getVar('studentname'),
                'paymentmethod' => $this->request->getVar('paymentmethod'),
                'paymentdate' => $this->request->getVar('paymentdate'),
                'paymenttime' => $this->request->getVar('paymenttime'),
                'amountpaid' => $this->request->getVar('amountpaid'),
                'checknumber' => $this->request->getVar('checknumber'),
                'checkdate' => $this->request->getVar('checkdate'),
                'bankname' => $this->request->getVar('bankname'),
                'particulars' => $this->request->getVar('particulars'),
                'ornumber' => $this->request->getVar('ornumber'),
                'receivedby' => $FULLNAME,
                'paymentstatus' => "Paid",
                'createddate' => date('Y-m-d'),
                'isdel' => 0,
            ];
            // print_r($paymenttransactionsdata);
            $this->paymentransactionsModel->save($paymenttransactionsdata);
            
            session()->setTempdata('paymentmessage','Payment added successfully', 3);
            return redirect()->to(base_url()."student-accounts/view/details/".$studentno."/".$studentaccountno);
        }    
    }
    public function receiptPrint($id=null){
        $pageSize = array(140, 175);
        $pdf = new TCPDF('P', 'mm', $pageSize, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
    
        $pdf->SetCreator('TRS Department');
        $pdf->SetAuthor('Cashier Officec');
        $pdf->SetTitle('Online Registration Receipt');

        // set margins
        $pdf->SetMargins(0,0,0,0);
        
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 10);

        $uid = session()->get('logged_user');
        $userdata = $this->usersModel->where('uid', $uid)->findAll();
        foreach($userdata as $userd){
            $USERACCOUNTID = $userd['uaccountid'];
        }
        $empdata = $this->empModel->where('empnum', $USERACCOUNTID)->findAll();
        foreach($empdata as $empd){
            $FULLNAME = $empd['empfullname'];
        }
        $paymenttransactiondata = $this->paymentransactionsModel->where('paymentid', $id)->findAll();
        foreach($paymenttransactiondata as $ptdata){
            $PAYMENTREFERENCE = $ptdata['paymentreference'];
            $PAYMENTNAME = $ptdata['studfullname'];
            $PAYMENTDATE = $ptdata['paymentdate'];
            $PAYMENTAMOUNT = $ptdata['amountpaid'];
            $PAYMENTPARTICULARS = $ptdata['particulars'];
        }
        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        $PAYMENTAMOUNT_IN_WORDS = $formatter->format($PAYMENTAMOUNT);
        $html = '
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <table>
                <tr>
                    <td style="width: 70%;"></td>
                    <td style="width: 30%;">'.date('F j, Y', strtotime($PAYMENTDATE)).'</td>
                </tr>
            </table>
            <br>
            <br>
            <table>
                <tr>
                    <td style="width: 40%;"></td>
                    <td style="width: 60%;">'.$PAYMENTNAME.'</td>
                </tr>
                <tr>
                    <td style="width: 40%;"></td>
                    <td style="width: 60%;">'.$PAYMENTREFERENCE.'</td>
                </tr>
            </table>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <table>
                <tr>
                    <td style="width: 15%;"></td>
                    <td style="width: 65%;">Fees<br>Misc</td>
                    <td style="width: 20%;">'.$PAYMENTAMOUNT.'</td>
                </tr>
            </table>
            <br>
            <br>
            <br>
            <br>
            <br>
            <table>
                <tr>
                    <td style="width: 8%;"></td>
                    <td style="width: 92%;">'.strtoupper($PAYMENTAMOUNT_IN_WORDS).' PESOS ONLY</td>
                </tr>
            </table>
            <br>
            <table>
                <tr>
                    <td style="width: 80%;"></td>
                    <td style="width: 20%;">'.$PAYMENTAMOUNT.'</td>
                </tr>
            </table>
            <br>
            <table>
                <tr>
                    <td style="width: 8%;"></td>
                    <td style="width: 52%;">'.$PAYMENTPARTICULARS.'</td>
                    <td style="width: 40%;"></td>
                </tr>
            </table>
            <br>
            <br>
            <br>
            <table>
                <tr>
                    <td style="width: 80%;"></td>
                    <td style="width: 20%;">'.$PAYMENTAMOUNT.'</td>
                </tr>
            </table>
            <br>
            <table>
                <tr>
                    <td style="width: 10%;"></td>
                    <td style="width: 50%;">'.$FULLNAME.'</td>
                    <td style="width: 40%;"></td>
                </tr>
            </table>
        ';
        
        // Output PDF to browser
        $pdf->writeHTML($html, true, false, false, false, '');
        // Get PDF content as string
        $pdfContent = $pdf->Output('document.pdf', 'S');
        
        // Return as PDF response
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="hello_world.pdf"')
            ->setBody($pdfContent);
    }
}