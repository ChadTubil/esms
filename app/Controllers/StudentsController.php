<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\StudentsModel;
use App\Models\COLStudentsModel;
use App\Models\StudentAccountsModel;
use App\Models\SHSStudentsModel;
use App\Models\IBEDStudentsModel;
use App\Models\PaymentTransactionsModel;
use App\Models\StudentAccountAssessmentModel;
use App\Models\FeeStructureModel;
class StudentsController extends BaseController
{
    public $usersModel;
    public $studentsModel;
    public $colstudentsModel;
    public $studentAccountsModel;
    public $shsStudentsModel;
    public $ibedStudentsModel;
    public $paymentransactionsModel;
    public $studentAccountsAssessmentModel;
    public $feeStructureModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->studentsModel = new StudentsModel();
        $this->colstudentsModel = new COLStudentsModel();
        $this->studentAccountsModel = new StudentAccountsModel();
        $this->shsStudentsModel = new SHSStudentsModel();
        $this->ibedStudentsModel = new IBEDStudentsModel();
        $this->paymentransactionsModel = new PaymentTransactionsModel();
        $this->studentAccountsAssessmentModel = new StudentAccountAssessmentModel();
        $this->feeStructureModel = new FeeStructureModel();
        $this->session = session();
    }
    public function index() {
        $data = [
            'page_title' => 'Holy Cross College | Students',
            'page_heading' => 'STUDENTS! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        // $StudentsCondition = array('studisdel' => 0);
        // $students = $this->studentsModel->where($StudentsCondition)->findAll();
        // $colStudents = $this->colstudentsModel->where('studisdel', 0)->findAll();
        // $data['studentdata'] = array_merge($students, $colStudents);

        if($this->request->is('post')){
            $searchStudent = $this->request->getVar('searchstud');

            if($searchStudent == ''){
                $StudentsCondition = array('studisdel' => 0);
                // $students = $this->studentsModel->where($StudentsCondition)->findAll();
                // $colStudents = $this->colstudentsModel->where('studisdel', 0)->findAll();
                // $data['resultStudent'] = array_merge($students, $colStudents);
                $data['resultStudent'] = $this->colstudentsModel->where($StudentsCondition)->findAll();
                return view('studentsviewsearchresult', $data);
            }
            else{
                $StudentsCondition = array('studisdel' => 0);
                // $students = $this->studentsModel->where($StudentsCondition)
                // ->like('studentno', $searchStudent)
                // ->orLike('studln', $searchStudent)
                // ->orLike('studfn', $searchStudent)
                // ->orLike('studfullname', $searchStudent)
                // ->findAll();
                // $colStudents = $this->colstudentsModel->where('studisdel', 0)
                // ->like('studentno', $searchStudent)
                // ->orLike('studln', $searchStudent)
                // ->orLike('studfn', $searchStudent)
                // ->orLike('studfullname', $searchStudent)
                // ->findAll();
                // $data['resultStudent'] = array_merge($students, $colStudents);
                $data['resultStudent'] = $this->colstudentsModel->where($StudentsCondition)
                ->like('studentno', $searchStudent)
                ->orLike('studln', $searchStudent)
                ->orLike('studfn', $searchStudent)
                ->orLike('studfullname', $searchStudent)
                ->findAll();
                return view('studentsviewsearchresult', $data);
            }
        }

        return view('studentsview', $data);
    }
    public function activateStudent($id=null) {
        $data = [
            'studstatus' => '1',
        ];

        $this->colstudentsModel->where('studid', $id)->update($id, $data);
        session()->setTempdata('activatesuccess', 'Account is activated!', 2);
        return redirect()->to(base_url()."students");
    }
    public function activateStudentM($id=null) {
        $data = [
            'studstatus' => '2',
        ];

        $this->colstudentsModel->where('studid', $id)->update($id, $data);
        session()->setTempdata('activatesuccess', 'Account is activated!', 2);
        return redirect()->to(base_url()."students");
    }
    public function activateStudentF($id=null) {
        $data = [
            'studstatus' => '3',
        ];

        $this->colstudentsModel->where('studid', $id)->update($id, $data);
        session()->setTempdata('activatesuccess', 'Account is activated!', 2);
        return redirect()->to(base_url()."students");
    }
    public function deactivateStudent($id=null) {
        $data = [
            'studstatus' => '0',
        ];

        $this->colstudentsModel->where('studid', $id)->update($id, $data);
        session()->setTempdata('activatesuccess', 'Account is deactivated!', 2);
        return redirect()->to(base_url()."students");
    }
    public function resetpasswordStudent($id=null) {

        $data = [
            'upassword' => '123456',
        ];

        $this->usersModel
        ->set('upassword', 123456)
        ->where('uaccountid', $id)
        ->update();
        session()->setTempdata('activatesuccess', 'Password has been reset!', 2);

        return redirect()->to(base_url()."students");
    }
    public function deleteStudent($id=null) {
        $data = [
            'studisdel' => '1',
        ];

        $this->colstudentsModel->where('studid', $id)->update($id, $data);
        session()->setTempdata('activatesuccess', 'Student is deleted!', 2);
        return redirect()->to(base_url()."students");
    }
    public function studentInfo($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | Students Information',
            'page_heading' => 'STUDENTS INFORMATION',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $StudentsCondition = array('studid' => $id);
        $data['studentdata'] = $this->colstudentsModel->where($StudentsCondition)->findAll();

        return view('studentsinfo', $data);
    }
    public function studentInfoUpdate($id=null) {
        if($this->request->is('post')) {
            $LN = $this->request->getVar('lname');
            $FN = $this->request->getVar('fname');
            $MN = $this->request->getVar('mname');
            $EXT = $this->request->getVar('extname');
            $FULL = $LN.', '.$FN.' '.$EXT.' '.$MN;
            $data = [
                'studln' => $LN,
                'studfn' => $FN,
                'studmn' => $MN,
                'studextension' => $EXT,
                'studfullname' => $FULL,
                'studbirthday' => $this->request->getVar('birthdate'),
                'studage' => $this->request->getVar('age'),
                'studgender' => $this->request->getVar('gender'),
                'studstbarangay' => $this->request->getVar('barangay'),
                'studcity' => $this->request->getVar('city'),
                'studprovince' => $this->request->getVar('province'),
                'studcontact' => $this->request->getVar('contact'),
                'studcitizenship' => $this->request->getVar('citizenship'),
                'studreligion' => $this->request->getVar('religion'),
                'studemail' => $this->request->getVar('email'),
                'studbirthplace' => $this->request->getVar('birthplace'),
                'studcreatedat' => $this->request->getVar('section'),
            ];

            $this->colstudentsModel->where('studid', $id)->update($id, $data);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."students");
        }
    }
    public function createaccount($id=null) {
        $checkStudentUserAccount = $this->usersModel->where('uaccountid', $id)->where('uisdel', '0')->findAll();
        if(empty($checkStudentUserAccount)){
            $data = [
                'uaccountid' => $id,
                'username' => $id,
                'upassword' => '123456',
                'ustudent' => '1'
            ];
            $this->usersModel->save($data);
            session()->setTempdata('updatesuccess', 'Student Credentials Created Successfully!', 2);
            return redirect()->to(base_url()."students");
        } else {
            session()->setTempdata('updatesuccess', 'Student Credentials already exist!', 2);
            return redirect()->to(base_url()."students");
        }
        
    }
    public function studentaccounts() {
        $data = [
            'page_title' => 'Holy Cross College | Student Accounts',
            'page_heading' => 'STUDENT ACCOUNTS! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        foreach($data['usersaccess'] as $uaccess) {
            $STUDENTNO = $uaccess['uaccountid'];
        }
        $data['studentaccountdata'] = $this->studentAccountsModel
        ->where('studentno', $STUDENTNO)
        ->where('isdel', '0')
        ->findAll();
        return view('students/studentaccountsview', $data);
    }
    public function studentaccountsdetails($said=null) {
        $data = [
            'page_title' => 'Holy Cross College | Student Accounts',
            'page_heading' => 'STUDENT ACCOUNTS! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        foreach($data['usersaccess'] as $uaccess) {
            $STUDENTNO = $uaccess['uaccountid'];
        }

        $shsStudents = $this->shsStudentsModel->where('studentno', $STUDENTNO)->findAll();
        $ibedStudents = $this->ibedStudentsModel->where('studentno', $STUDENTNO)->findAll();
        $colStudents = $this->colstudentsModel->where('studentno', $STUDENTNO)->findAll();
        $data['studentdata'] = array_merge($colStudents, $shsStudents, $ibedStudents);
        foreach($data['studentdata'] as $allstd){
            $STUDENTFULLNAME = $allstd['studfullname'];
            $STUDENTNO = $allstd['studentno'];

        }

        $data['studentaccountdata'] = $this->studentAccountsModel
        ->where('studentno', $STUDENTNO)
        ->where('isdel', '0')
        ->findAll();

        $data['accountdetailsdata'] = $this->studentAccountsModel
        ->where('said', $said)
        ->findAll();

        $data['paymenthistorydata'] = $this->paymentransactionsModel
        ->where('paymenttransactions.studfullname', $STUDENTFULLNAME)
        ->orWhere('paymenttransactions.studfullname', $STUDENTNO)
        ->where('paymenttransactions.paymentstatus', 'Paid')
        ->findAll();

        $assessments = $this->studentAccountsAssessmentModel
            ->select('feestructure.*, studentassessment.*')
            ->join('feestructure', 'feestructure.feeid = studentassessment.feeid', 'left')
            ->where('studentassessment.said', $said)
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
        ->where('studentassessment.said', $said)->findAll();

        return view('students/studentaccountsdetailsview', $data);
    }
}
