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
use App\Models\SchoolLedgerModel;
use App\Models\IBEDLevelModel;
use App\Models\IBEDRatesModel;
use App\Models\IBEDRateDuesModel;
use App\Models\IBEDRateOtherFeesModel;
use App\Models\IBEDStudentsModel;
use App\Models\COLStudentsModel;
use App\Models\BooksModel;
use App\Models\BooksAssessment;
use App\Models\StudentOtherBillsModel;
use App\Models\UniformsModel;
use App\Models\UniformsAssessmentModel;

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
    public $schoolLedgerModel;
    public $ibedlevelModel;
    public $ibedRatesModel;
    public $ibedRateDuesModel;
    public $ibedRateOtherFeesModel;
    public $ibedStudentsModel;
    public $colStudentsModel;
    public $booksModel;
    public $booksAssessmentModel;
    public $studentOtherBillsModel;
    public $uniformsModel;
    public $uniformsAssessmentModel;

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
        $this->schoolLedgerModel = new SchoolLedgerModel();
        $this->ibedlevelModel = new IBEDLevelModel();
        $this->ibedRatesModel = new IBEDRatesModel();
        $this->ibedRateDuesModel = new IBEDRateDuesModel();
        $this->ibedRateOtherFeesModel = new IBEDRateOtherFeesModel();
        $this->ibedStudentsModel = new IBEDStudentsModel();
        $this->colStudentsModel = new COLStudentsModel();
        $this->booksModel = new BooksModel();
        $this->booksAssessmentModel = new BooksAssessment();
        $this->studentOtherBillsModel = new StudentOtherBillsModel();
        $this->uniformsModel = new UniformsModel();
        $this->uniformsAssessmentModel = new UniformsAssessmentModel();

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
        $data['coursedata'] = $this->coursesModel->where('isdel', '0')->findAll();
        
        $data['ratesdata'] = $this->ratesModel
        ->select('rates.*, courses.*')
        ->join('courses', 'rates.course = courses.courid')
        ->where('rates.isdel', '0')->findAll();

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
                'course' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Course is required.',
                    ],
                ],
                'yearlevel' => [
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
                    'course' => $this->request->getVar('course'),
                    'year' => $this->request->getVar('yearlevel'),
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
        $data['ratesdata'] = $this->ratesModel
        ->select('rates.*, courses.*')
        ->join('courses', 'rates.course = courses.courid')->where('rateid', $id)->findAll();
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
        $LocateRateID = $this->rdModel->where('rdid', $id)->findAll();
        foreach($LocateRateID as $rateid) {
            $rateID = $rateid['rateid'];
        }
        if($this->request->is('post')) {
            $data = [
                'due' => $this->request->getVar('due'),
            ];

            $this->rdModel->where('rdid', $id)->update($id, $data);
            return redirect()->to(base_url()."rates/setup/".$rateID);
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
        $LocateRateID = $this->rofModel->where('rofid', $id)->findAll();
        foreach($LocateRateID as $rateid) {
            $rateID = $rateid['rateid'];
        }
        if($this->request->is('post')) {
            $data = [
                'name' => $this->request->getVar('name'),
                'otherfees' => $this->request->getVar('otherfee'),
            ];

            $this->rofModel->where('rofid', $id)->update($id, $data);
            return redirect()->to(base_url()."rates/setup/".$rateID);
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
    public function ibedRates() {
        $data = [
            'page_title' => 'Holy Cross College | IBED Rates',
            'page_heading' => 'IBED RATES! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['sydata'] = $this->syModel->where('syisdel', 0)->findAll();
        $data['levelsdata'] = $this->ibedlevelModel->where('isdel', '0')->findAll();
        $data['ibedratesdata'] = $this->ibedRatesModel
        ->select('rates_ibed.*, levels_ibed.*')
        ->join('levels_ibed', 'rates_ibed.level = levels_ibed.levelid')
        ->where('rates_ibed.isdel', '0')->findAll();

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
            ];
            if($this->validate($rules)){
                $data = [
                    'sy' => $this->request->getVar('sy'),
                    'level' => $this->request->getVar('level'),
                ];
                $this->ibedRatesModel->save($data);
                session()->setTempdata('success','Rate added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('accounting/ibed-rates', $data);
    }
    public function ibedratesSetup($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | IBED Rates Setup',
            'page_heading' => 'IBED RATES SETUP! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['ibedratesdata'] = $this->ibedRatesModel
        ->select('rates_ibed.*, levels_ibed.*')
        ->join('levels_ibed', 'rates_ibed.level = levels_ibed.levelid')
        ->where('rates_ibed.rateid', $id)->findAll();

        $data['ibedrddata'] = $this->ibedRateDuesModel->where('rateid', $id)->findAll();
        $data['ibedrofdata'] = $this->ibedRateOtherFeesModel->where('rateid', $id)->findAll();

        if($this->request->is('post')) {
            $data = [
                'tf' => $this->request->getVar('tf'),
            ];
            $this->ibedRatesModel->where('rateid', $id)->update($id, $data);
            session()->setTempdata('addsuccess','Save successfully', 3);
            return redirect()->to(current_url());
        }

        return view('accounting/ibed-ratessetup', $data);
    }
    public function ibedratesDues($id=null) {
        if($this->request->is('post')) {
            $numberofdues = $this->ibedRateDuesModel->where('rateid', $id)->countAllResults();
            $newcount = $numberofdues + 1;
            // print_r($newcount);
            $data = [
                'rateid' => $id,
                'name' => "Due Date ".$newcount,
                'due' => $this->request->getVar('due'),
            ];

            $this->ibedRateDuesModel->save($data);
            return redirect()->to(base_url()."ibed-rates/setup/".$id);
        }
    }
    public function ibedratesRof($id=null) {
        if($this->request->is('post')) {
            $data = [
                'rateid' => $id,
                'name' => $this->request->getVar('ratename'),
                'otherfees' => $this->request->getVar('otherfees'),
            ];

            $this->ibedRateOtherFeesModel->save($data);
            return redirect()->to(base_url()."ibed-rates/setup/".$id);
        }
    }
    public function ibedratesDuesUpdate($id=null) {
        $LocateRateID = $this->ibedRateDuesModel->where('rdid', $id)->findAll();
        foreach($LocateRateID as $rateid) {
            $rateID = $rateid['rateid'];
        }
        if($this->request->is('post')) {
            $data = [
                'due' => $this->request->getVar('due'),
            ];

            $this->ibedRateDuesModel->where('rdid', $id)->update($id, $data);
            return redirect()->to(base_url()."ibed-rates/setup/".$rateID);
        }
    }
    public function ibedratesRofUpdate($id=null) {
        $LocateRateID = $this->ibedRateOtherFeesModel->where('rofid', $id)->findAll();
        foreach($LocateRateID as $rateid) {
            $rateID = $rateid['rateid'];
        }
        if($this->request->is('post')) {
            $data = [
                'name' => $this->request->getVar('name'),
                'otherfees' => $this->request->getVar('otherfee'),
            ];

            $this->ibedRateOtherFeesModel->where('rofid', $id)->update($id, $data);
            return redirect()->to(base_url()."ibed-rates/setup/".$rateID);
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
        $Coursedata = $this->coursesModel->where('isdel', 0)->findAll();
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
                    'toaccountid' => $this->request->getVar('tocoa'),
                    'course' => $this->request->getVar('course'),
                    'sy' => $this->request->getVar('sy'),
                    'semester' => $this->request->getVar('sem'),
                    'ismandatory' => $this->request->getVar('mandatory'),
                    'istf' => $this->request->getVar('tfis'),
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
                'toaccountid' => $this->request->getVar('tocoa'),
                'course' => $this->request->getVar('course'),
                'sy' => $this->request->getVar('sy'),
                'semester' => $this->request->getVar('sem'),
                'ismandatory' => $this->request->getVar('mandatory'),
                'istf' => $this->request->getVar('tfis'),
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
                // $students = $this->studentsModel->where('studisdel', 0)->findAll();
                $colStudents = $this->colStudentsModel->where('studisdel', 0)->findAll();
                $shsStudents = $this->shsStudentsModel->where('studisdel', 0)->findAll();
                $ibedStudents = $this->ibedStudentsModel->where('studisdel', 0)->findAll();
                $resultStudent = array_merge($colStudents, $shsStudents, $ibedStudents);
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
                // $students = $this->studentsModel
                // ->like('studentno', $searchStudent)
                // ->orLike('studln', $searchStudent)
                // ->orLike('studfn', $searchStudent)
                // ->orLike('studfullname', $searchStudent)
                // ->where('studisdel', 0)->findAll();
                $shsStudents = $this->shsStudentsModel
                ->like('studentno', $searchStudent)
                ->orLike('studln', $searchStudent)
                ->orLike('studfn', $searchStudent)
                ->orLike('studfullname', $searchStudent)
                ->where('studisdel', 0)->findAll();
                $colStudents = $this->colStudentsModel
                ->like('studentno', $searchStudent)
                ->orLike('studln', $searchStudent)
                ->orLike('studfn', $searchStudent)
                ->orLike('studfullname', $searchStudent)
                ->where('studisdel', 0)->findAll();
                $ibedStudents = $this->ibedStudentsModel
                ->like('studentno', $searchStudent)
                ->orLike('studln', $searchStudent)
                ->orLike('studfn', $searchStudent)
                ->orLike('studfullname', $searchStudent)
                ->where('studisdel', 0)->findAll();
                $resultStudent = array_merge($colStudents, $shsStudents, $ibedStudents);

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
        // $students = $this->studentsModel->where('studentno', $id)->findAll();
        $shsStudents = $this->shsStudentsModel->where('studentno', $id)->findAll();
        $ibedStudents = $this->ibedStudentsModel->where('studentno', $id)->findAll();
        $colStudents = $this->colStudentsModel->where('studentno', $id)->findAll();
        $data['studentdata'] = array_merge($colStudents, $shsStudents, $ibedStudents);

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
        // $students = $this->studentsModel->where('studentno', $studentno)->findAll();
        $shsStudents = $this->shsStudentsModel->where('studentno', $studentno)->findAll();
        $ibedStudents = $this->ibedStudentsModel->where('studentno', $studentno)->findAll();
        $colStudents = $this->colStudentsModel->where('studentno', $studentno)->findAll();
        $data['studentdata'] = array_merge($colStudents, $shsStudents, $ibedStudents);
        foreach($data['studentdata'] as $allstd){
            $STUDENTFULLNAME = $allstd['studfullname'];
            $STUDENTNO = $allstd['studentno'];

        }
        $data['studaccdataforpayment'] = $this->studentAccountsModel->findAll();
        
        $data['findingnemo'] = $this->studentAccountsModel
        ->select('studentsaccounts.*, assessment_col.*')
        ->join('assessment_col', 'assessment_col.assid = studentsaccounts.assessmentid', 'left')
        ->where('studentno', $studentno)->findAll();
        
        $data['studentaccountsdata'] = $this->studentAccountsModel->where('studentno', $studentno)->where('isdel', 0)->findAll();
        $data['studentaccountsassessmentdata'] = $this->studentAccountsAssessmentModel->where('said', $studentaccountno)->where('isdel', 0)->findAll();
        $data['coadata'] = $this->coaModel->where('isdel', 0)->findAll();

        $data['allfeestructuredata'] = $this->feeStructureModel
            ->where('isdel', 0)
            ->findAll();

        $assessments = $this->studentAccountsAssessmentModel
            ->select('feestructure.*, studentassessment.*')
            ->join('feestructure', 'feestructure.feeid = studentassessment.feeid', 'left')
            ->where('studentassessment.said', $studentaccountno)
            ->where('studentassessment.isdel', 0)
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
        //STUDENT OTHER BILLS
        $data['studentotherbillsdata'] = $this->studentOtherBillsModel->where('studno', $STUDENTNO)->where('isdel', 0)->findAll();
        
        return view('accounting/studentaccountassessmentview', $data);
    }
    public function viewnemo($id=null){
        if($this->request->is('post')) {
            // $FEES = $this->feeStructureModel->where('feeid', $feeid)->findAll();
            
            $NEMOFINDNA = $this->studentAccountsAssessmentModel->where('sadid', $id)->findAll();
            foreach($NEMOFINDNA as $NEMOF){
                $STUDNO = $NEMOF['studentno'];
                $SAIDNEMO = $NEMOF['said'];
            }
            
            $STUDENTACCOUNT = $this->studentAccountsModel->where('said', $SAIDNEMO)->findAll();
            foreach($STUDENTACCOUNT as $account) {
                $TOTALASSESSMENT = $account['totalassessment'];
                $TOTALBALANCE = $account['totalbalance'];
            }
            
            $data = [
                'amount' => $this->request->getVar('ttfnemo'),
                'netamount' => $this->request->getVar('ttfnemo'),
                'balance' => $this->request->getVar('ttfnemo'),
            ];
            
            $studAccData = [
                'totalassessment' => $TOTALASSESSMENT + $this->request->getVar('ttfnemo'),
                'totalbalance' => $TOTALBALANCE + $this->request->getVar('ttfnemo'),
                'updateddate' => date('Y-m-d'),
            ];
            
            $this->studentAccountsModel->where('said', $SAIDNEMO)->set($studAccData)->update();

            $this->studentAccountsAssessmentModel->where('sadid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."student-accounts/view/details/".$STUDNO."/".$SAIDNEMO);
        }
    }
    public function viewStudentAccountsDetailsAdd($ttf=null){
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
                    'debit' => $amount, //Dating credit. Sa School Ledger pasok sa debit
                    'createddate' => date('Y-m-d'),
                    'createdby' => $FULLNAME,
                ];
                $schoolLedgerData = [
                    'said' => $studentaccountno,
                    'transactiondate' => date('Y-m-d'),
                    'transactiontype' => 'Assessment',
                    'description' => $FEENAME,
                    'credit' => $amount,
                    'createdby' => $FULLNAME,
                ];

                $this->studentAccountsAssessmentModel->save($data);
                $this->studentAccountsModel->where('said', $studentaccountno)->set($studAccData)->update();
                $this->studentsLedgerModel->save($studentLedgerData);
                $this->schoolLedgerModel->save($schoolLedgerData);
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
            $ASSBALANCE = $SAAD['balance'];
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
            'balance' => $ASSBALANCE - $AMOUNTPAID,
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
            'credit' => $AMOUNTPAID, //Dating debit. Sa School Ledger pasok sa debit
            'createddate' => date('Y-m-d'),
            'createdby' => $FULLNAME,
        ];

        $schoolLedgerData = [
            'said' => $SAID,
            'transactiondate' => date('Y-m-d'),
            'transactiontype' => 'Payment',
            'description' => $FEENAME,
            'debit' => $AMOUNTPAID,
            'createdby' => $FULLNAME,
        ];

        $this->paymentAllocationModel->save($allocatedata);
        $this->paymentransactionsModel->where('paymentid', $paymenttransid)->update($paymenttransid, $paymenttransdata);
        $this->studentAccountsAssessmentModel->where('sadid', $studaccountassessid)->update($studaccountassessid, $studentaccassessdata);
        $this->studentAccountsModel->where('said', $SAID)->update($SAID, $studentaccountsdata);
        $this->studentsLedgerModel->save($studentLedgerData);
        $this->schoolLedgerModel->save($schoolLedgerData);
        session()->setTempdata('message','Fee added successfully', 3);
        return redirect()->to(base_url()."student-accounts/view/details/".$STUDNO."/".$SAID);
        // print_r($studentaccassessdata);
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
                $DISCOUNT = $ASSESSMENTAMOUNT * ($DISCOUNTPERCENTAGE / 100);
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
            'credit' => $DISCOUNT, //Dating debit. Sa School Ledger pasok sa debit
            'createddate' => date('Y-m-d'),
            'createdby' => $FULLNAME,
        ];
        $schoolLedgerData = [
            'said' => $SAID,
            'transactiondate' => date('Y-m-d'),
            'transactiontype' => 'Discount',
            'description' => $dd['discountname'],
            'debit' => $DISCOUNT,
            'createdby' => $FULLNAME,
        ];

        $this->studentAccountsModel->where('said', $SAID)->update($SAID, $studentaccountdata);
        $this->studentAccountsAssessmentModel->where('sadid', $studaccountassessid)->update($studaccountassessid, $studentaccassdata);
        $this->studentsLedgerModel->save($studentLedgerData);
        $this->schoolLedgerModel->save($schoolLedgerData);
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
    public function booksSetup() {
        $data = [
            'page_title' => 'Holy Cross College | Books Setup Year',
            'page_heading' => 'BOOKS SETUP YEAR! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['booksdata'] = $this->booksModel->where('isdel', 0)->findAll();
        $data['clusterdata'] = $this->clustersModel->where('isdel', 0)->findAll();
        if($this->request->is('post')) {
            $rules = [
                'title' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Title is required.',
                    ],
                ],
                'price' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Price is required.',
                    ],
                ],
                'level' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Level is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                $data = [
                    'name' => $this->request->getVar('title'),
                    'price' => $this->request->getVar('price'),
                    'level' => $this->request->getVar('level'),
                    'cluster' => $this->request->getVar('cluster'),
                ];
                $this->booksModel->save($data);
                session()->setTempdata('addsuccess','Book added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('accounting/bookssetupview', $data);
    }
    public function deleteBooks($id=null) {
        $data = [
            'isdel' => '1',
        ];

        $this->booksModel->where('bookid', $id)->update($id, $data);
        session()->setTempdata('deletesuccess', 'Book is deleted!', 2);
        return redirect()->to(base_url()."books-setup");
    }
    public function booksAssessment($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | Books Assessment',
            'page_heading' => 'BOOKS ASSESSMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['bookassessmentdata'] = $this->booksAssessmentModel
        ->select('*, SUM(price) as total')
        ->where('studno', $id)
        ->where('isdel', 0)
        ->groupBy('transactionno')
        ->findAll();

        $checkStudent = $this->studentAccountsModel->where('studentno', $id)->findAll();
        if(!$checkStudent) {
            session()->setTempdata('message', 'Student does not have an student number yet. Please create an student number first.', 3);
            return redirect()->to(base_url()."student-accounts/view/".$id);
        } else {
            foreach($checkStudent as $cs) {
                $studentlevel = $cs['level'];
                $studentcluster = $cs['cluster'];
            }
        }
        // if($studentcluster == 0) {
        //     $STUDCLUSTER = 0;
        // }else{
        //     $STUDCLUSTER = $studentcluster;
        // }
        $querybooks = $this->booksModel;

        $querybooks->where('level', $studentlevel);
        $querybooks->where('isdel', 0);

        if($studentlevel == 'Grade 12') {
        $querybooks->Where('cluster', 'General');
        $querybooks->orwhere('cluster', $studentcluster);
        }

        $data['booksdata'] = $querybooks->findAll();
        
        $shsStudents = $this->shsStudentsModel->where('studentno', $id)->findAll();
        $ibedStudents = $this->ibedStudentsModel->where('studentno', $id)->findAll();
        $data['studentdata'] = array_merge($shsStudents, $ibedStudents);
        $data['booksassessmentdata'] = $this->booksAssessmentModel
        ->select('booksassessment.*, books.*')
        ->join('books', 'books.bookid = booksassessment.bookid', 'left')
        ->where('booksassessment.status', 'Assessed')
        ->where('booksassessment.studno', $id)
        ->where('booksassessment.isdel', 0)
        ->findAll();

        return view('accounting/booksassessmentview', $data);
    }
    public function addBooksAssessment($id=null, $bookid=null) {

        $bookdata= $this->booksModel->where('bookid', $bookid)->findAll();

        foreach ($bookdata as $bd) {
            
            $price = $bd['price'];
        }

        $data = [
            'studno' => $id,
            'bookid' => $bookid,
            'price' => $price,
            'status' => 'Assessed',
            'isdel' => 0,
        ];
        $this->booksAssessmentModel->save($data);
        session()->setTempdata('addsuccess','Book added successfully', 3);
        return redirect()->to(base_url()."books-assessment/".$id);
    }
    public function addallBooksAssessment($id=null, $level=null) {

        $bookdata= $this->booksModel->where('level', $level)->findAll();

        foreach ($bookdata as $bd) {
            
    
        $data = [
            'studno' => $id,
            'bookid' => $bd['bookid'],
            'price' => $bd['price'],
            'status' => 'Assessed',
            'isdel' => 0,
        ];

        $this->booksAssessmentModel->save($data);

        }
        session()->setTempdata('addsuccess','All Books added successfully', 3);
        return redirect()->to(base_url()."books-assessment/".$id);
    }
    public function deleteBooksAssessment($id=null) {
        $BAID = $this->booksAssessmentModel->where('baid', $id)->findAll();

        foreach($BAID as $baid) {
            $STUDNO = $baid['studno'];
        }

        $data = [
            'isdel' => '1',
        ];
        
        $this->booksAssessmentModel->where('baid', $id)->update($id, $data);
        session()->setTempdata('addsuccess', 'Book is deleted!', 2);
        return redirect()->to(base_url()."books-assessment/".$STUDNO);
    }
    public function processBooksAssessment($id=null) {
        
        $BAID = $this->booksAssessmentModel->where('studno', $id)->where('status', 'Assessed')->where('isdel', 0)->findAll();
        $GETTRANSACTIONNO = $this->booksAssessmentModel
        ->where('studno', $id)
        ->groupBy('transactionno')
        ->where('isdel', 0)->findAll();
        foreach($GETTRANSACTIONNO as $GTN) {
            $TRANSACTIONNO = $GTN['transactionno'];
        }
        if($GETTRANSACTIONNO==0) {
            $TRANNO = 0;
        }else{
            $TRANNO = $TRANSACTIONNO + 1;
        }

        $TOTAL = 0;

        foreach($BAID as $baid) {

            $TOTAL += $baid['price'];
            
        }

        $data = [
            'studno' => $id,
            'name' => 'Books Assessment',
            'totalamount' => $TOTAL,
            'tablename' => 'booksassessment',
            'id' => 0,
            'status' => 'Payment',
            'isdel' => 0,

        ];

        $bookassessmentdata = [
            'status' => 'Payment',
            'transactionno' => $TRANNO,
        ];

        $this->studentOtherBillsModel->save($data);
        $this->booksAssessmentModel->where('studno', $id)->where('status', 'Assessed')->where('isdel', 0)->set($bookassessmentdata)->update();
        session()->setTempdata('addsuccess', 'Book is deleted!', 2);
        return redirect()->to(base_url()."student-accounts/view/".$id);
    }
    public function submitSOB($sadid = null, $sobid = null){
        
            // $FEES = $this->feeStructureModel->where('feeid', $feeid)->findAll();

            $STUDOTHERBILLS = $this->studentOtherBillsModel->where('sobid', $sobid)->findAll();

            foreach($STUDOTHERBILLS as $sob){

                $STUDNO = $sob['studno'];
                $NAME = $sob['name'];
                $BOOKTOTALAMOUNT = $sob['totalamount'];
            }
            
            $NEMOFINDNA = $this->studentAccountsAssessmentModel->where('sadid', $sadid)->findAll();
            foreach($NEMOFINDNA as $NEMOF){
                $STUDNO = $NEMOF['studentno'];
                $SAIDNEMO = $NEMOF['said'];
            }
            
            $STUDENTACCOUNT = $this->studentAccountsModel->where('said', $SAIDNEMO)->findAll();
            foreach($STUDENTACCOUNT as $account) {
                $TOTALASSESSMENT = $account['totalassessment'];
                $TOTALBALANCE = $account['totalbalance'];
            }
            
            $data = [
                'amount' => $BOOKTOTALAMOUNT,
                'netamount' => $BOOKTOTALAMOUNT,
                'balance' => $BOOKTOTALAMOUNT,
            ];
            
            $studAccData = [
                'totalassessment' => $TOTALASSESSMENT + $BOOKTOTALAMOUNT,
                'totalbalance' => $TOTALBALANCE + $BOOKTOTALAMOUNT,
                'updateddate' => date('Y-m-d'),
            ];
            
            $this->studentAccountsModel->where('said', $SAIDNEMO)->set($studAccData)->update();

            $this->studentAccountsAssessmentModel->where('sadid', $sadid)->update($sadid, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."student-accounts/view/details/".$STUDNO."/".$SAIDNEMO);
    }
    public function bookassessmentPrint($id=null) {
        $pageSize = array(216, 330);
        $pdf = new TCPDF('P', 'mm', $pageSize, true, 'UTF-8', false);
        // Load TCPDF library
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetCreator('Holy Cross College');
        $pdf->SetAuthor('TRS Department');
        $pdf->SetTitle('Assessment of Fees');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(5,40,5,0);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->AddPage();

        $imagePath = FCPATH .'public/uploads/hccheader3.png';
        $pdf->Image($imagePath, $x = 5, $y = 0, $w = 201, $h = 36); 
        $pdf->Line(5, 37, 206, 37);

        $shsStudents = $this->shsStudentsModel->where('studentno', $id)->findAll();
        $ibedStudents = $this->ibedStudentsModel->where('studentno', $id)->findAll();
        $studentdata = array_merge($shsStudents, $ibedStudents);
        foreach($studentdata as $sd) {
            $STUDFULLNAME = $sd['studfullname'];
            $STUDNO = $sd['studentno'];
        }
        
        $bookassessementd = $this->booksAssessmentModel
        ->select('booksassessment.*, books.*')
        ->join('books', 'books.bookid = booksassessment.bookid', 'left')
        // ->join('students_shs', 'students_shs.studentno = booksassessment.studno', 'left')
        // ->join('students_ibed', 'students_ibed.studentno = booksassessment.studno', 'left')
        ->where('booksassessment.studno', $id)
        ->where('booksassessment.isdel', 0)
        ->where('booksassessment.status', 'Assessed')
        ->findAll();

        foreach($bookassessementd as $bookassd) {
            // $STUDFULLNAME = $bookassd['studfullname'];
            // $STUDNO = $bookassd['studno'];
            $BOOKTITLE = $bookassd['name'];
            $BOOKLEVEL = $bookassd['level'];
            $BOOKPRICE = $bookassd['price'];
        }

        $html = '
            <style>        
                    .evaluation {
                    border: 1px solid black;
                }
                table td{
                    font-size: 12px;
                    font-family: Verdana, Geneva, Tahoma, sans-serif;
                }
                .misctbl{
                    display: inline-block;
                }
                .wrap-title {
                word-wrap: break-word;      /* Allow words to break if needed */
                white-space: normal;        /* Allow wrapping */
                max-width: 250px;           /* Optional: set a max width */
                }
            </style>

            <table>
                <tr>
                    <td style="background-color: #b5b5b5; font-size: 25px; font-weight: bold; text-align: center;">STUDENTS COPY</td>
                </tr>
            </table><br><br>

            <table>
                <tr>
                    <td style="width: 65%;">STUDENT No.: <strong>'. strtoupper($STUDNO) .' </strong></td>
                    <td>LEVEL: <strong>'. strtoupper($BOOKLEVEL) .'</strong></td>
                </tr>
                <tr>
                    <td>STUDENT: <strong>'. strtoupper($STUDFULLNAME) .'</strong></td>
                </tr>
            </table><br><br>

            <table style="width: 100%; font-size: 10px;">
                <thead>
                    <tr>
                        <th style="width: 10%;text-align: center; font-weight: bold;">#</th>
                        <th style="width: 50%;text-align: center; font-weight: bold;">BOOK TITLE</th>
                        <th style="width: 20%;text-align: center; font-weight: bold;">BOOK LEVEL</th>
                        <th style="width: 20%;text-align: center; font-weight: bold;">BOOK PRICE</th>
                    </tr>
                </thead>
                <tbody>
                <br><br>
        ';
        $counter = 1;
        $totalPrice = 0;
        foreach($bookassessementd as $bookassd) {
            $STUDFULLNAME = $bookassd['studfullname'];
            $STUDNO = $bookassd['studno'];
            $BOOKTITLE = $bookassd['name'];
            $BOOKLEVEL = $bookassd['level'];
            $BOOKPRICE = $bookassd['price'];
            $totalPrice += $BOOKPRICE;
                $html .= '
                    <tr>
                        <td style="width: 10%;text-align: center;">'.$counter++.'</td>
                        <td style="text-align: left; word-wrap: break-word; max-width: 250px; width: 50%;">'.strtoupper($BOOKTITLE).'</td>
                        <td style="width: 20%;text-align: center;">'.strtoupper($BOOKLEVEL).'</td>
                        <td style="width: 20%;text-align: center;">'.number_format($BOOKPRICE, 2).'</td>
                    </tr>
                        
                    ';
        }
        $html .= '
                </tbody>
                <tfoot>
                    <tr>
                        <td style="width: 10%;"></td>
                        <td style="width: 50%;"></td>
                        <td style="text-align: center; width: 20%; font-weight: bold;">TOTAL:</td>
                        <td style="text-align: center; font-weight: bold; width: 20%;">'.number_format($totalPrice, 2).'</td>
                    </tr>
                </tfoot>
            </table>
            <br><br>'
            ;
            

        $html .= '<table style="width: 100%;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <table style="width: 100%;">
                            <tbody>
                            <br><br><br><br><br><br><br>
                                <tr>
                                    <td style="width: 70%; text-align: left; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 70%; text-align: left;"><p style="font-size: 10px;">SIGNATURE OVER STUDENTS PRINTED NAME</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; vertical-align: top;">
                        <table  style="width: 100%;">
                            <tbody>
                            <br><br><br>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center;"><p style="font-size: 12px;">BOOKSTORE</p></td>
                                </tr>
                            </tbody>
                        </table>
                        <table  style="width: 100%;">
                            <tbody>
                            <br><br><br>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center;"><p style="font-size: 12px;">CASHIER</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
            <br><br><br><br><br><br><br><br><br><br><br>';
            
            $html .= '
            <style>        
                    .evaluation {
                    border: 1px solid black;
                }
                table td{
                    font-size: 12px;
                    font-family: Verdana, Geneva, Tahoma, sans-serif;
                }
                .misctbl{
                    display: inline-block;
                }
                .wrap-title {
                word-wrap: break-word;      /* Allow words to break if needed */
                white-space: normal;        /* Allow wrapping */
                max-width: 250px;           /* Optional: set a max width */
                }
            </style>

            <table>
                <tr>
                    <td style="background-color: #b5b5b5; font-size: 25px; font-weight: bold; text-align: center;">BOOKSTORE COPY</td>
                </tr>
            </table><br><br>

            <table>
                <tr>
                    <td style="width: 65%;">STUDENT No.: <strong>'. strtoupper($STUDNO) .' </strong></td>
                    <td>LEVEL: <strong>'. strtoupper($BOOKLEVEL) .'</strong></td>
                </tr>
                <tr>
                    <td>STUDENT: <strong>'. strtoupper($STUDFULLNAME) .'</strong></td>
                </tr>
            </table><br><br>

            <table style="width: 100%; font-size: 10px;">
                <thead>
                    <tr>
                        <th style="width: 10%;text-align: center; font-weight: bold;">#</th>
                        <th style="width: 50%;text-align: center; font-weight: bold;">BOOK TITLE</th>
                        <th style="width: 20%;text-align: center; font-weight: bold;">BOOK LEVEL</th>
                        <th style="width: 20%;text-align: center; font-weight: bold;">BOOK PRICE</th>
                    </tr>
                </thead>
                <tbody>
                <br><br>
        ';
        $counter = 1;
        $totalPrice = 0;
        foreach($bookassessementd as $bookassd) {
            $STUDFULLNAME = $bookassd['studfullname'];
            $STUDNO = $bookassd['studno'];
            $BOOKTITLE = $bookassd['name'];
            $BOOKLEVEL = $bookassd['level'];
            $BOOKPRICE = $bookassd['price'];
            $totalPrice += $BOOKPRICE;
                $html .= '
                    <tr>
                        <td style="width: 10%;text-align: center;">'.$counter++.'</td>
                        <td style="text-align: left; word-wrap: break-word; max-width: 250px; width: 50%;">'.strtoupper($BOOKTITLE).'</td>
                        <td style="width: 20%;text-align: center;">'.strtoupper($BOOKLEVEL).'</td>
                        <td style="width: 20%;text-align: center;">'.number_format($BOOKPRICE, 2).'</td>
                    </tr>
                        
                    ';
        }
        $html .= '
                </tbody>
                <tfoot>
                    <tr>
                        <td style="width: 10%;"></td>
                        <td style="width: 50%;"></td>
                        <td style="text-align: center; width: 20%; font-weight: bold;">TOTAL:</td>
                        <td style="text-align: center; font-weight: bold; width: 20%;">'.number_format($totalPrice, 2).'</td>
                    </tr>
                </tfoot>
            </table>
            <br><br>'
            ;
            

        $html .= '<table style="width: 100%;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <table style="width: 100%;">
                            <tbody>
                            <br><br><br><br><br><br><br>
                                <tr>
                                    <td style="width: 70%; text-align: left; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 70%; text-align: left;"><p style="font-size: 10px;">SIGNATURE OVER STUDENTS PRINTED NAME</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; vertical-align: top;">
                        <table  style="width: 100%;">
                            <tbody>
                            <br><br><br>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center;"><p style="font-size: 12px;">BOOKSTORE</p></td>
                                </tr>
                            </tbody>
                        </table>
                        <table  style="width: 100%;">
                            <tbody>
                            <br><br><br>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center;"><p style="font-size: 12px;">CASHIER</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>';
        
        $pdf->writeHTML($html, true, false, false, false, '');
        $filename = strtoupper($STUDFULLNAME).'.pdf';
        $pdfContent = $pdf->Output($filename, 'S');
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody($pdfContent);
    }
    public function submitOR($studno=null, $transactionno=null){
        if($this->request->is('post')) {
            // $GETSTUDNO = $this->booksAssessmentModel->where('transactionno', $id)->findAll();
            // foreach($GETSTUDNO as $GSN) {
            //     $STUDNO = $GSN['studno'];
            // }

            $bookassessmentdata = [
                'ornumber' => $this->request->getVar('ornumber'),
                'status' => 'Paid',
            ];

            $this->booksAssessmentModel->where('status', 'Payment')->where('studno', $studno)->where('transactionno', $transactionno)->set($bookassessmentdata)->update();
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."books-assessment/".$studno);
        }
    }
    public function releaseBooksAssessment($id=null, $ornumber=null){
        $GETSTUDNO = $this->booksAssessmentModel->where('transactionno', $id)->findAll();
        foreach($GETSTUDNO as $GSN) {
            $STUDNO = $GSN['studno'];
        }

        $bookassessmentdata = [
            'status' => 'Released',
        ];

        $this->booksAssessmentModel->where('transactionno', $id)->where('status', 'Paid')->set($bookassessmentdata)->update();
        session()->setTempdata('updatesuccess', 'Update Successful!', 2);
        return redirect()->to(base_url()."books-assessment/".$STUDNO);
    }
    public function uniformSetup() {
        $data = [
            'page_title' => 'Holy Cross College | Uniform Setup',
            'page_heading' => 'UNIFORM SETUP',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['uniformsdata'] = $this->uniformsModel->where('isdel', 0)->findAll();
        if($this->request->is('post')) {
            $rules = [
                'name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Name is required.',
                    ],
                ],
                'price' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Price is required.',
                    ],
                ],
            ];
            if($this->validate($rules)){
                $data = [
                    'name' => $this->request->getVar('name'),
                    'size' => $this->request->getVar('size'),
                    'price' => $this->request->getVar('price'),
                ];
                $this->uniformsModel->save($data);
                session()->setTempdata('addsuccess','Uniform added successfully', 3);
                return redirect()->to(current_url());
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('accounting/uniformsetupview', $data);
    }
    public function uniformsAssessment($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | Uniforms Assessment',
            'page_heading' => 'UNIFORMS ASSESSMENT! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['uniformassessmentdata'] = $this->uniformsAssessmentModel
        ->select('*, SUM(totalamount) as total')
        ->where('studentno', $id)
        ->where('isdel', 0)
        ->groupBy('transactionno')
        ->findAll();

        $checkStudent = $this->studentAccountsModel->where('studentno', $id)->findAll();
        if(!$checkStudent) {
            session()->setTempdata('message', 'Student does not have an student number yet. Please create an student number first.', 3);
            return redirect()->to(base_url()."student-accounts/view/".$id);
        } else {
            foreach($checkStudent as $cs) {
                $studentlevel = $cs['level'];
                $studentcluster = $cs['cluster'];
            }
        }
        // if($studentcluster == 0) {
        //     $STUDCLUSTER = 0;
        // }else{
        //     $STUDCLUSTER = $studentcluster;
        // }
        // $querybooks = $this->booksModel;

        // $querybooks->where('level', $studentlevel);
        // $querybooks->where('isdel', 0);

        // if($studentlevel == 'Grade 12') {
        // $querybooks->Where('cluster', 'General');
        // $querybooks->orwhere('cluster', $studentcluster);
        // }

        // $data['booksdata'] = $querybooks->findAll();

        $data['uniformsdata'] = $this->uniformsModel->where('isdel', 0)->findAll();
        
        $shsStudents = $this->shsStudentsModel->where('studentno', $id)->findAll();
        $ibedStudents = $this->ibedStudentsModel->where('studentno', $id)->findAll();
        $colStudents = $this->colStudentsModel->where('studentno', $id)->findAll();
        
        $data['studentdata'] = array_merge($shsStudents, $ibedStudents, $colStudents);

        foreach($data['studentdata'] as $sd){
            $STUDNO = $sd['studentno'];
        }
        
        $data['uniformsassessmentdata'] = $this->uniformsAssessmentModel
        ->select('uniformsassessment.*, uniforms.*')
        ->join('uniforms', 'uniforms.uniformid = uniformsassessment.uniformid', 'left')
        ->where('uniformsassessment.status', 'Assessed')
        ->where('uniformsassessment.studentno', $STUDNO)
        ->where('uniformsassessment.isdel', 0)
        ->findAll();

        return view('accounting/uniformsassessmentview', $data);
    }
    public function addUniformsAssessment($id=null, $uniformid=null) {

        $uniformdata= $this->uniformsModel->where('uniformid', $uniformid)->findAll();

        foreach ($uniformdata as $ud) {

            $price = $ud['price'];

        }

        $data = [
            'studentno' => $id,
            'uniformid' => $uniformid,
            'status' => 'Assessed',
            'isdel' => 0,
        ];

        $this->uniformsAssessmentModel->save($data);
        session()->setTempdata('addsuccess','Uniform added successfully', 3);
        return redirect()->to(base_url()."uniforms-assessment/".$id);
    }
    public function updateUniformsAssessmentQty($uniformaid=null) {
        if($this->request->is('post')) {
            $QUANTITY = $this->request->getVar('qty');
            $uniformadata= $this->uniformsAssessmentModel->where('uniaid', $uniformaid)->findAll();
            foreach ($uniformadata as $uad) {
                $UNID = $uad['uniformid'];
                $STUDNO = $uad['studentno'];
            }
            $uniformdata= $this->uniformsModel->where('uniformid', $UNID)->findAll();
            foreach ($uniformdata as $ud){
                $PRICE = $ud['price'];
            }
            $data = [
                'qty' => $QUANTITY,
                'totalamount' => $QUANTITY * $PRICE,
            ];

            $this->uniformsAssessmentModel->where('uniaid', $uniformaid)->update($uniformaid, $data);
            session()->setTempdata('addsuccess','Uniform added successfully', 3);
            return redirect()->to(base_url()."uniforms-assessment/".$STUDNO);
        }
    }
    public function processUniformsAssessment($id=null) {

        $UAID = $this->uniformsAssessmentModel->where('studentno', $id)->where('status', 'Assessed')->where('isdel', 0)->findAll();
        
        $GETTRANSACTIONNO = $this->uniformsAssessmentModel
        ->where('studentno', $id)
        ->groupBy('transactionno')
        ->where('isdel', 0)->findAll();
        
        foreach($GETTRANSACTIONNO as $GTN) {
            $TRANSACTIONNO = $GTN['transactionno'];
        }
        if($GETTRANSACTIONNO==0) {
            $TRANNO = 0;
        }else{
            $TRANNO = $TRANSACTIONNO + 1;
        }

        $TOTAL= 0;

        foreach($UAID as $uaid) {

            $TOTAL += $uaid['totalamount'];
            
        }

        $data = [
            'studno' => $id,
            'name' => 'Uniforms Assessment',
            'totalamount' => $TOTAL,
            'tablename' => 'uniformsassessment',
            'status' => 'Payment',
            'isdel' => 0,

        ];

        $uniformassessmentdata = [
            'status' => 'Payment',
            'transactionno' => $TRANNO,
        ];

        $this->studentOtherBillsModel->save($data);
        $this->uniformsAssessmentModel->where('studentno', $id)->where('status', 'Assessed')->where('isdel', 0)->set($uniformassessmentdata)->update();
        session()->setTempdata('addsuccess', 'Book is deleted!', 2);
        return redirect()->to(base_url()."student-accounts/view/".$id);
    }
    public function uniformsassessmentPrint($id=null) {
        $pageSize = array(216, 330);
        $pdf = new TCPDF('P', 'mm', $pageSize, true, 'UTF-8', false);
        // Load TCPDF library
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetCreator('Holy Cross College');
        $pdf->SetAuthor('TRS Department');
        $pdf->SetTitle('Assessment of Fees');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(5,40,5,0);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->AddPage();

        $imagePath = FCPATH .'public/uploads/hccheader3.png';
        $pdf->Image($imagePath, $x = 5, $y = 0, $w = 201, $h = 36); 
        $pdf->Line(5, 37, 206, 37);

        $shsStudents = $this->shsStudentsModel->where('studentno', $id)->findAll();
        $ibedStudents = $this->ibedStudentsModel->where('studentno', $id)->findAll();
        $colStudents = $this->colStudentsModel->where('studentno', $id)->findAll();
        $studentdata = array_merge($shsStudents, $ibedStudents, $colStudents);
        
        foreach($studentdata as $sd) {
            $STUDFULLNAME = $sd['studfullname'];
            $STUDNO = $sd['studentno'];
        }
        
        $uniformsassessment = $this->uniformsAssessmentModel
        ->select('uniformsassessment.*, uniforms.*')
        ->join('uniforms', 'uniforms.uniformid = uniformsassessment.uniformid', 'left')
        ->join('students_shs', 'students_shs.studentno = uniformsassessment.studentno', 'left')
        ->join('students_ibed', 'students_ibed.studentno = uniformsassessment.studentno', 'left')
        ->join('students_col', 'students_col.studentno = uniformsassessment.studentno', 'left')
        ->where('uniformsassessment.studentno', $STUDNO)
        ->where('uniformsassessment.isdel', 0)
        ->where('uniformsassessment.status', 'Assessed')
        ->findAll();

        foreach($uniformsassessment as $uniassd) {
            $STUDNO = $uniassd['studentno'];
            $SIZE = $uniassd['size'];
            $UNIFORMNAME = $uniassd['name'];
            $QUANTITY = $uniassd['qty'];
            $TOTAL = $uniassd['totalamount'];
        }

        $html = '
            <style>        
                    .evaluation {
                    border: 1px solid black;
                }
                table td{
                    font-size: 12px;
                    font-family: Verdana, Geneva, Tahoma, sans-serif;
                }
                .misctbl{
                    display: inline-block;
                }
                .wrap-title {
                word-wrap: break-word;      /* Allow words to break if needed */
                white-space: normal;        /* Allow wrapping */
                max-width: 250px;           /* Optional: set a max width */
                }
            </style>

            <table>
                <tr>
                    <td style="background-color: #b5b5b5; font-size: 25px; font-weight: bold; text-align: center;">STUDENTS COPY</td>
                </tr>
            </table><br><br>

            <table>
                <tr>
                    <td style="width: 65%;">STUDENT No.: <strong>'. strtoupper($STUDNO) .' </strong></td>
                    
                </tr>
                <tr>
                    <td>STUDENT: <strong>'. strtoupper($STUDFULLNAME) .'</strong></td>
                </tr>
            </table><br><br>

            <table style="width: 100%; font-size: 10px;">
                <thead>
                    <tr>
                        <th style="width: 10%;text-align: center; font-weight: bold;">#</th>
                        <th style="width: 50%;text-align: left; font-weight: bold;">NAME</th>
                        <th style="width: 10%;text-align: center; font-weight: bold;">QTY</th>
                        <th style="width: 10%;text-align: center; font-weight: bold;">PRICE</th>
                        <th style="width: 20%;text-align: center; font-weight: bold;">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                <br><br>
        ';
        $counter = 1;
        $totalPrice = 0;
        foreach($uniformsassessment as $uniassd) {
            $STUDNO = $uniassd['studentno'];
            $UNIFORMNAME = $uniassd['name'];
            $QUANTITY = $uniassd['qty'];
            $TOTAL = $uniassd['totalamount'];

            $totalPrice += $TOTAL;
                $html .= '
                    <tr>
                        <td style="width: 10%;text-align: center;">'.$counter++.'</td>
                        <td style="text-align: left; word-wrap: break-word; max-width: 250px; width: 50%;">'.strtoupper($UNIFORMNAME).' - '.strtoupper($SIZE).'</td>
                        <td style="width: 10%;text-align: center;">'.strtoupper($QUANTITY).'</td>
                        <td style="width: 10%;text-align: center;">'.number_format($uniassd['price'], 2).'</td>
                        <td style="width: 20%;text-align: center;">'.number_format($TOTAL, 2).'</td>
                    </tr>
                        
                    ';
        }
        $html .= '
                </tbody>
                <tfoot>
                    <tr>
                        <td style="width: 10%;"></td>
                        <td style="width: 50%;"></td>
                        <td style="text-align: center; width: 20%; font-weight: bold;">GRAND TOTAL:</td>
                        <td style="text-align: center; font-weight: bold; width: 20%;">'.number_format($totalPrice, 2).'</td>
                    </tr>
                </tfoot>
            </table>
            <br><br>'
            ;
            

        $html .= '<table style="width: 100%;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <table style="width: 100%;">
                            <tbody>
                            <br><br><br><br><br><br><br>
                                <tr>
                                    <td style="width: 70%; text-align: left; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 70%; text-align: left;"><p style="font-size: 10px;">SIGNATURE OVER STUDENTS PRINTED NAME</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; vertical-align: top;">
                        <table  style="width: 100%;">
                            <tbody>
                            <br><br><br>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center;"><p style="font-size: 12px;">BOOKSTORE</p></td>
                                </tr>
                            </tbody>
                        </table>
                        <table  style="width: 100%;">
                            <tbody>
                            <br><br><br>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center;"><p style="font-size: 12px;">CASHIER</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
            <br><br><br><br><br><br><br><br><br><br><br>';
            
            $html .= '
            <style>        
                    .evaluation {
                    border: 1px solid black;
                }
                table td{
                    font-size: 12px;
                    font-family: Verdana, Geneva, Tahoma, sans-serif;
                }
                .misctbl{
                    display: inline-block;
                }
                .wrap-title {
                word-wrap: break-word;      /* Allow words to break if needed */
                white-space: normal;        /* Allow wrapping */
                max-width: 250px;           /* Optional: set a max width */
                }
            </style>

            <table>
                <tr>
                    <td style="background-color: #b5b5b5; font-size: 25px; font-weight: bold; text-align: center;">BOOKSTORE COPY</td>
                </tr>
            </table><br><br>

            <table>
                <tr>
                    <td style="width: 65%;">STUDENT No.: <strong>'. strtoupper($STUDNO) .' </strong></td>
                    
                </tr>
                <tr>
                    <td>STUDENT: <strong>'. strtoupper($STUDFULLNAME) .'</strong></td>
                </tr>
            </table><br><br>

            <table style="width: 100%; font-size: 10px;">
                <thead>
                    <tr>
                        <th style="width: 10%;text-align: center; font-weight: bold;">#</th>
                        <th style="width: 50%;text-align: left; font-weight: bold;">NAME</th>
                        <th style="width: 10%;text-align: center; font-weight: bold;">QTY</th>
                        <th style="width: 10%;text-align: center; font-weight: bold;">PRICE</th>
                        <th style="width: 20%;text-align: center; font-weight: bold;">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                <br><br>
        ';
        $counter = 1;
        $totalPrice = 0;
        foreach($uniformsassessment as $uniassd) {
            $STUDNO = $uniassd['studentno'];
            $UNIFORMNAME = $uniassd['name'];
            $QUANTITY = $uniassd['qty'];
            $TOTAL = $uniassd['totalamount'];

            $totalPrice += $TOTAL;
                $html .= '
                    <tr>
                        <td style="width: 10%;text-align: center;">'.$counter++.'</td>
                        <td style="text-align: left; word-wrap: break-word; max-width: 250px; width: 50%;">'.strtoupper($UNIFORMNAME).' - '.strtoupper($SIZE).'</td>
                        <td style="width: 10%;text-align: center;">'.strtoupper($QUANTITY).'</td>
                        <td style="width: 10%;text-align: center;">'.number_format($uniassd['price'], 2).'</td>
                        <td style="width: 20%;text-align: center;">'.number_format($TOTAL, 2).'</td>
                    </tr>
                        
                    ';
        }
        $html .= '
                </tbody>
                <tfoot>
                    <tr>
                        <td style="width: 10%;"></td>
                        <td style="width: 50%;"></td>
                        <td style="text-align: center; width: 20%; font-weight: bold;">GRAND TOTAL:</td>
                        <td style="text-align: center; font-weight: bold; width: 20%;">'.number_format($totalPrice, 2).'</td>
                    </tr>
                </tfoot>
            </table>
            <br><br>'
            ;
            

        $html .= '<table style="width: 100%;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <table style="width: 100%;">
                            <tbody>
                            <br><br><br><br><br><br><br>
                                <tr>
                                    <td style="width: 70%; text-align: left; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 70%; text-align: left;"><p style="font-size: 10px;">SIGNATURE OVER STUDENTS PRINTED NAME</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width: 50%; vertical-align: top;">
                        <table  style="width: 100%;">
                            <tbody>
                            <br><br><br>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center;"><p style="font-size: 12px;">BOOKSTORE</p></td>
                                </tr>
                            </tbody>
                        </table>
                        <table  style="width: 100%;">
                            <tbody>
                            <br><br><br>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center; border-bottom: 1px solid black"></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; text-align: center;"></td>
                                    <td style="width: 70%; text-align: center;"><p style="font-size: 12px;">CASHIER</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>';
        
        $pdf->writeHTML($html, true, false, false, false, '');
        $filename = strtoupper($STUDFULLNAME).'.pdf';
        $pdfContent = $pdf->Output($filename, 'S');
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody($pdfContent);
    }
    public function submitORUniform($studno=null, $transactionno=null){
        if($this->request->is('post')) {

            // $GETSTUDNO = $this->booksAssessmentModel->where('transactionno', $id)->findAll();
            // foreach($GETSTUDNO as $GSN) {
            //     $STUDNO = $GSN['studno'];
            // }

            $uniformassessmentdata = [
                'ornumber' => $this->request->getVar('ornumber'),
                'status' => 'Paid',
            ];

            $this->uniformsAssessmentModel->where('status', 'Payment')->where('studentno', $studno)->where('transactionno', $transactionno)->set($uniformassessmentdata)->update();
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."uniforms-assessment/".$studno);
        }
    }
    public function releaseUniformsAssessment($id=null, $ornumber=null){
        
        $GETSTUDNO = $this->uniformsAssessmentModel->where('transactionno', $id)->findAll();
        foreach($GETSTUDNO as $GSN) {
            $STUDNO = $GSN['studentno'];
        }

        $uniformassessmentdata = [
            'status' => 'Released',
        ];

        $this->uniformsAssessmentModel->where('transactionno', $id)->where('status', 'Paid')->set($uniformassessmentdata)->update();
        session()->setTempdata('updatesuccess', 'Update Successful!', 2);
        return redirect()->to(base_url()."uniforms-assessment/".$STUDNO);
    }
}