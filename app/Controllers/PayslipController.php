<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\PayslipsModel;
use App\Models\PayslipDatasModel;
class PayslipController extends BaseController
{
    public $usersModel;
    public $payslipsModel;
    public $payslipDatasModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->payslipsModel = new PayslipsModel();
        $this->payslipDatasModel = new PayslipDatasModel();
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Payroll',
            'page_heading' => 'PAYROLL! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['payslipdata'] = $this->payslipsModel->where('isdel', 0)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'cutoffdate' => [
                    'rules' => 'required|is_unique[payslip.cutoffdate]',
                    'errors' => [
                        'required' => 'Cut off date is required.',
                        'is_unique' => 'This payroll cut off date is already exists.'
                    ],
                ],
            ];
            if($this->validate($rules)){
                $file = $this->request->getFile('filecsv');
                if ($file->isValid() && !$file->hasMoved()) {
                    if($file->move(FCPATH.'public\csv', $file->getRandomName())) {
                        $imagepath = base_url().'public/csv/'.$file->getName();

                        // if($file->move(FCPATH.'csv', $file->getRandomName())) {
                        // $imagepath = base_url().'csv/'.$file->getName();
                        // Pag sa cloud na. at gawa ng csv folder sa labas ng public


                        $file = fopen($imagepath, 'r');
                        $header = fgetcsv($file);

                        while (($row = fgetcsv($file)) !== FALSE) {
                            $data = array_combine($header, $row);
                            $this->payslipDatasModel->insert([
                                'cutoffdate' => $this->request->getVar('cutoffdate'),
                                'employeeno' => $data['employeeno'],
                                'name' => $data['name'],
                                'basicpay' => $data['basicpay'],
                                'advisoryclass' => $data['advisoryclass'],
                                'specialdesignation' => $data['specialdesignation'],
                                'gs' => $data['gs'],
                                'jhs' => $data['jhs'],
                                'college' => $data['college'],
                                'shs' => $data['shs'],
                                'economic' => $data['economic'],
                                'adjustmentOL' => $data['adjustmentOL'],
                                'makeupclass' => $data['makeupclass'],
                                'cpload' => $data['cpload'],
                                'allowance' => $data['allowance'],
                                'thesis' => $data['thesis'],
                                'ot' => $data['ot'],
                                'grossincome' => $data['grossincome'],
                                'sss' => $data['sss'],
                                'philhealth' => $data['philhealth'],
                                'pagibig' => $data['pagibig'],
                                'peraa' => $data['peraa'],
                                'absences' => $data['absences'],
                                'absencesOL' => $data['absencesOL'],
                                'deductionOL' => $data['deductionOL'],
                                'tax' => $data['tax'],
                                'ssssalary' => $data['ssssalary'],
                                'ssscalamity' => $data['ssscalamity'],
                                'mpl' => $data['mpl'],
                                'pagibigcalamity' => $data['pagibigcalamity'],
                                'peraaloan' => $data['peraaloan'],
                                'advancestoemployees' => $data['advancestoemployees'],
                                'cbsloan' => $data['cbsloan'],
                                'otherdeduction' => $data['otherdeduction'],
                                'grossdeduction' => $data['grossdeduction'],
                                'netpay' => $data['netpay'],
                            ]);
                        }
                        fclose($file);

                        $data = [
                            'cutoffdate' => $this->request->getVar('cutoffdate'),
                            'file' => $imagepath,
                            'description' => $this->request->getVar('description'),
                            'createdat' => date('Y-m-d'),
                        ];
                        $this->payslipsModel->save($data);
                        session()->setTempdata('success','Payslip created successfully', 3);
                        return redirect()->to(current_url());
                    }
                } else {
                    session()->setTempdata('error', 'File upload failed. Please try again.', 3);
                    return redirect()->to(current_url());
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('payslipsview', $data);
    }
    public function payslipView($date=null) {
        $data = [
            'page_title' => 'Holy Cross College | Payroll',
            'page_heading' => 'PAYROLL! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['payslipdata'] = $this->payslipsModel->where('cutoffdate', $date)->findAll();
        $data['payslipdatadata'] = $this->payslipDatasModel->where('cutoffdate', $date)->findAll();

        return view('payrollview', $data);
    }
    public function payslip() {
        $data = [
            'page_title' => 'Holy Cross College | Payslip',
            'page_heading' => 'PAYSLIP! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['payslipdata'] = $this->payslipsModel->where('isdel', 0)->findAll();

        return view('slipview', $data);
    }
    public function payslipviewview($date=null) {
        $data = [
            'page_title' => 'Holy Cross College | Payslip',
            'page_heading' => 'PAYSLIP! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['payslipdata'] = $this->payslipsModel->where('cutoffdate', $date)->findAll();
        $UserData = $this->usersModel->where('uid', $uid)->findAll();
        foreach ($UserData as $user) {
            $UACCOUNTID = $user['uaccountid'];
        }

        $data['payslipdatadata'] = $this->payslipDatasModel->where('cutoffdate', $date)
        ->where('employeeno', $UACCOUNTID)->findAll();

        return view('slipviewview', $data);
    }
}
