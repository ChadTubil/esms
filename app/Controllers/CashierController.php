<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\EmployeesModel;
use App\Models\StudentsModel;
use App\Models\SYModel;
use App\Models\SemesterModel;
use App\Models\LevelsModel;
use App\Models\CoursesModel;
use App\Models\SchoolRecordModel;
use App\Models\AssessmentModel;
use App\Models\PermanentRecordModel;
use App\Models\EnrollmentTempDataModel;
use App\Models\FamilyBackgroundModel;
use App\Models\CurriculumsModel;
use App\Models\CurriculumDataModel;
use App\Models\StudentCurriculumModel;
use App\Models\CollegeGradesModel;
use App\Models\SectionsModel;
use App\Models\SubjectsModel;
use App\Models\SchedulesModel;
use App\Models\RatesModel;
use App\Models\RateOtherFeesModel;
use App\Models\RateDuesModel;
use App\Models\RoomsModel;
use App\Models\PaymentTransactionsModel;
use App\Models\RegStudentsModel;
use App\Models\IBEDStudentsModel;
use App\Models\PaymentAllocationModel;
use App\Models\StudentAccountAssessmentModel;
use App\Models\StudentAccountsModel;
use App\Models\FeeStructureModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\I18n\Time;
use TCPDF;
use NumberFormatter; // Add this line
class CashierController extends BaseController
{ 
    public $usersModel;
    public $empModel;
    public $studentsModel;
    public $syModel;
    public $semModel;
    public $levelsModel;
    public $coursesModel;
    public $srModel;
    public $assModel;
    public $prModel;
    public $etdModel;
    public $fbModel;
    public $curriModel;
    public $currdataModel;
    public $studcurriModel;
    public $colgradesModel;
    public $sectionsModel;
    public $subjectsModel;
    public $schedulesModel;
    public $rofModel;
    public $ratesModel;
    public $rateDuesModel;
    public $roomsModel;
    public $paymentransactionsModel;
    public $regstudentsModel;
    public $ibedstudentsModel;
    public $paymentallocationModel;
    public $studentaccountassessmentModel;
    public $studentsaccountsModel;
    public $feestructureModel;
    
    public $session;
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->empModel = new EmployeesModel();
        $this->studentsModel = new StudentsModel();
        $this->syModel = new SYModel();
        $this->semModel = new SemesterModel();
        $this->levelsModel = new LevelsModel();
        $this->coursesModel = new CoursesModel();
        $this->srModel = new SchoolRecordModel();
        $this->assModel = new AssessmentModel();
        $this->prModel = new PermanentRecordModel();
        $this->etdModel = new EnrollmentTempDataModel();
        $this->fbModel = new FamilyBackgroundModel();
        $this->curriModel = new CurriculumsModel();
        $this->currdataModel = new CurriculumDataModel();
        $this->studcurriModel = new StudentCurriculumModel();
        $this->colgradesModel = new CollegeGradesModel();
        $this->sectionsModel = new SectionsModel();
        $this->subjectsModel = new SubjectsModel();
        $this->schedulesModel = new SchedulesModel();
        $this->ratesModel = new RatesModel();
        $this->rofModel = new RateOtherFeesModel();
        $this->rateDuesModel = new RateDuesModel();
        $this->roomsModel = new RoomsModel();
        $this->paymentransactionsModel = new PaymentTransactionsModel();
        $this->regstudentsModel = new RegStudentsModel();
        $this->ibedstudentsModel = new IBEDStudentsModel();
        $this->paymentallocationModel = new PaymentAllocationModel();
        $this->studentaccountassessmentModel = new StudentAccountAssessmentModel();
        $this->studentsaccountsModel = new StudentAccountsModel();
        $this->feestructureModel = new FeeStructureModel();
        
        $this->session = session();
    }
    // public function index(){
    //     $data = [
    //         'page_title' => 'Holy Cross College | Cashier Transaction',
    //         'page_heading' => 'CASHIER TRANSACTION! ',
    //         'page_p' => 'Welcome to Holy Cross College School Management System.',
    //     ];
    //     if(!session()->has('logged_user'))
    //     {
    //         return redirect()->to(base_url());
    //     }
    //     $uid = session()->get('logged_user');
    //     $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
    //     $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

    //     if($this->request->is('post')) {
    //         $searchStudent = $this->request->getVar('searchstud');

    //         if($searchStudent == ''){
    //             $StudentsCondition = array('studisdel' => 0);
    //             $data['resultStudent'] = $this->studentsModel->where($StudentsCondition)->findAll();
    //             return view('cashierviewresult', $data);
    //         }
    //         else{
    //             $StudentsCondition = array('studisdel' => 0);
    //             $data['resultStudent'] = $this->studentsModel->where($StudentsCondition)
    //             ->like('studentno', $searchStudent)
    //             ->orLike('studln', $searchStudent)
    //             ->orLike('studfn', $searchStudent)
    //             ->orLike('studfullname', $searchStudent)
    //             ->findAll();
    //             return view('cashierviewresult', $data);
    //         }
    //     }

    //     return view('cashierview', $data);
    // }
    // public function transactionView($id=null){
    //     $data = [
    //         'page_title' => 'Holy Cross College | Cashier Transaction View',
    //         'page_heading' => 'CASHIER TRANSACTION! ',
    //         'page_p' => 'Welcome to Holy Cross College School Management System.',
    //     ];
    //     if(!session()->has('logged_user'))
    //     {
    //         return redirect()->to(base_url());
    //     }
    //     $uid = session()->get('logged_user');
    //     $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
    //     $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

    //     $data['assessmentData'] = $this->assModel->where('studentno', $id)->findAll();

    //     return view('cashiertransactionview', $data);
    // }
    // public function transactionViewOpen($id=null) {
    //     $data = [
    //         'page_title' => 'Holy Cross College | Cashier Transaction View Open',
    //         'page_heading' => 'CASHIER TRANSACTION! ',
    //         'page_p' => 'Welcome to Holy Cross College School Management System.',
    //     ];
    //     if(!session()->has('logged_user'))
    //     {
    //         return redirect()->to(base_url());
    //     }
    //     $uid = session()->get('logged_user');
    //     $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
    //     $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

    //     $assessmentInfo = $this->assModel->where('assid', $id)->findAll();
    //     foreach($assessmentInfo as $assinfo){
    //         $studentNo = $assinfo['studentno'];
    //     }

    //     $data['assessmentData'] = $this->assModel->where('studentno', $studentNo)->findAll();
    //     $data['studentInfo'] = $this->studentsModel->where('studid', $studentNo)->findAll();
    //     $data['courseInfo'] = $this->coursesModel->findAll();

    //     $data['assessment'] = $this->assModel->where('studentno', $studentNo)
    //     ->where('status', 'Finalized')->findAll();
    //     foreach($data['assessment'] as $ass) {
    //         $ASSID = $ass['assid'];
    //         $SECTION = $ass['section'];
    //         $SY = $ass['sy'];
    //         $SEM = $ass['sem'];
    //         $LEVEL = $ass['level'];
    //         $COURSE = $ass['course'];
    //     }
    //     $data['students'] = $this->studentsModel->where('studid', $studentNo)->findAll();
    //     $data['colgradesdata'] = $this->colgradesModel->where('assid', $ASSID)->findAll();
    //     $data['subject'] = $this->subjectsModel->findAll();
    //     $data['schedule'] = $this->schedulesModel->findAll();
    //     $COURSEData = $this->coursesModel->where('courid', $COURSE)->findAll();
    //     foreach($COURSEData as $courd) {    
    //         $COURCODE = $courd['courcode'];
    //     }
    //     $data['ratesData'] = $this->ratesModel
    //     ->where('sy', $SY)
    //     ->where('sem', $SEM)
    //     ->where('year', $LEVEL)
    //     ->where('course', $COURCODE)->findAll();
    //     foreach($data['ratesData'] as $ratesD) {
    //         $RATESID = $ratesD['rateid'];
    //     }
    //     $data['rofdata'] = $this->rofModel->where('rateid', $RATESID)->findAll();
    //     $data['duedata'] = $this->rateDuesModel->where('rateid', $RATESID)->findAll();

    //     $data['totalmajorunits'] = $this->colgradesModel->select('
    //         SUM(subjects.units) as totalmajorunits, SUM(subjects.hours) as totalmajorhours
    //         ')->join('subjects', 'subjects.subid = collegegrades.subid')
    //         ->where('collegegrades.assid', $ASSID)
    //         ->where('subjects.major', 1)
    //         ->where('subjects.subcode !=', "NSTP01")
    //         ->where('subjects.subcode !=', "NSTP02")
    //         ->findAll();

    //     $data['totalminorunits'] = $this->colgradesModel->select('
    //         SUM(subjects.units) as totalminorunits, SUM(subjects.hours) as totalminorhours
    //         ')->join('subjects', 'subjects.subid = collegegrades.subid')
    //         ->where('collegegrades.assid', $ASSID)
    //         ->where('subjects.major', 0)
    //         ->where('subjects.subcode !=', "NSTP01")
    //         ->where('subjects.subcode !=', "NSTP02")
    //         ->findAll();

    //     return view('cashiertransactionviewopen', $data);
    // }
    public function cashierOnlineRegistration() {
        $data = [
            'page_title' => 'Holy Cross College | Cashier Online Registration Transaction',
            'page_heading' => 'CASHIER ONLINE REGISTRATION TRANSACTION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['paymenttransactionsdata'] = $this->paymentransactionsModel
        ->SELECT('paymenttransactions.paymentid, paymenttransactions.paymentreference, paymenttransactions.studfullname, 
        paymenttransactions.paymentstatus, regstudents.studstatus')
        ->JOIN('regstudents', 'regstudents.studfullname = paymenttransactions.studfullname')
        ->where('paymenttransactions.paymentstatus', 'Pending')
        ->findAll();

        return view('cashier/cashiertransactionviewopen', $data);
    }
    public function cashierOnlineRegistrationPayment($id=null) {
        $data = [
            'page_title' => 'Holy Cross College | Cashier Online Registration Transaction',
            'page_heading' => 'CASHIER ONLINE REGISTRATION TRANSACTION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['usersdata'] = $this->usersModel->findAll();

        $data['paymenttransactionsdata'] = $this->paymentransactionsModel->where('paymentid', $id)->findAll();

        return view('cashier/cashiertransactionviewpayment', $data);
    }
    public function cashierOnlineRegistrationprocessPayment($id=null) {
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
            $data = [
                'paymentmethod' => $this->request->getVar('paymentmethod'),
                'paymentdate' => $this->request->getVar('paymentdate'),
                'paymenttime' => $this->request->getVar('paymenttime'),
                'amountpaid' => $this->request->getVar('amountpaid'),
                'checknumber' => $this->request->getVar('checknumber'),
                'checkdate' => $this->request->getVar('checkdate'),
                'bankname' => $this->request->getVar('bankname'),
                'particulars' => $this->request->getVar('particulars'),
                'receivedby' => $FULLNAME,
                'ornumber' => $this->request->getVar('ornumber'),
                'paymentstatus' => "Paid",
            ];

            $this->paymentransactionsModel->where('paymentid', $id)->update($id, $data);
            session()->setTempdata('success', 'Payment Successful!', 2);
            return redirect()->to(base_url()."cashier-onlineregistration-payment/".$id);
        }
    }
    public function onlineregPrint($id=null) {
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
    public function cashierDailyTransactions() {
        $data = [
            'page_title' => 'Holy Cross College | Cashier Reports',
            'page_heading' => 'CASHIER DAILY TRANSACTION REPORTS! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['userheadcashier'] = $this->usersModel->findAll();

        $data['cashierdata'] = $this->usersModel
        ->select('users.*, employees.*')
        ->join('employees', 'employees.empnum = users.uaccountid')
        ->where('ucashier', 1)
        ->where('uisdel', 0)
        ->findAll();

        $data['loggedcashierdata'] = $this->usersModel
        ->select('users.*, employees.*')
        ->join('employees', 'employees.empnum = users.uaccountid')
        ->where('uid', $uid)
        ->where('uisdel', 0)
        ->findAll();

        if($this->request->is('post')) {
            $STARTDATE = $this->request->getVar('start_date');
            $ENDDATE = $this->request->getVar('end_date');
            $STARTTIME = $this->request->getVar('start_time')   ;
            $ENDTIME = $this->request->getVar('end_time');
            $CASHIER = $this->request->getVar('cashier');
            // $CASHIER = 'CORTEZ , SUSAN E.';

            session()->set('start_date', $STARTDATE);
            session()->set('end_date', $ENDDATE);
            session()->set('start_time', $STARTTIME);
            session()->set('end_time', $ENDTIME);
            session()->set('cashier', $CASHIER);

            return redirect()->to(base_url()."cashier-dailytransactions-2");
        }


        return view('cashier/cashierdailytransreportview', $data);
    }
    public function cashierDailyTransactions2() {
        $data = [
            'page_title' => 'Holy Cross College | Cashier Reports',
            'page_heading' => 'CASHIER DAILY TRANSACTION REPORTS! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['userheadcashier'] = $this->usersModel->findAll();

        $data['cashierdata'] = $this->usersModel
        ->select('users.*, employees.*')
        ->join('employees', 'employees.empnum = users.uaccountid')
        ->where('ucashier', 1)
        ->where('uisdel', 0)
        ->findAll();

        $data['loggedcashierdata'] = $this->usersModel
        ->select('users.*, employees.*')
        ->join('employees', 'employees.empnum = users.uaccountid')
        ->where('uid', $uid)
        ->where('uisdel', 0)
        ->findAll();

        $STARTDATE = session()->get('start_date');
        $ENDDATE = session()->get('end_date');
        $STARTTIME = session()->get('start_time');
        $ENDTIME = session()->get('end_time');
        $CASHIER = session()->get('cashier');

        if($STARTTIME == ''){
            $TIMESTART = '00:01';
        }else{
            $TIMESTART = $STARTTIME;
        }
        if($ENDTIME == ''){
            $TIMEEND = '23:01';
        }else{
            $TIMEEND = $ENDTIME;
        }

        // print_r($STARTTIME);

        // Combine date and time into datetime strings
            $startDatetime = $STARTDATE . ' ' . $TIMESTART;
            $endDatetime = $ENDDATE . ' ' . $TIMEEND;

        if($CASHIER == 'ALL') {
            $data['transactionsdata'] = $this->paymentallocationModel
            ->select('paymentallocation.*, paymenttransactions.*, 
            studentassessment.said, 
            studentsaccounts.said, studentsaccounts.course, studentsaccounts.cluster, studentsaccounts.level,
            feestructure.feeid, feestructure.feecode, feestructure.istf')
            ->join('paymenttransactions',   'paymenttransactions.paymentid = paymentallocation.paymentid', 'left')
            ->join('studentassessment',   'studentassessment.sadid = paymentallocation.sadid', 'left')
            ->join('studentsaccounts', 'studentsaccounts.said = studentassessment.said', 'left')
            ->join('feestructure', 'feestructure.feeid = studentassessment.feeid', 'left')
            ->where('paymenttransactions.isdel', 0)
            ->where("CONCAT(paymenttransactions.paymentdate, ' ', paymenttransactions.paymenttime) >=", $startDatetime)
            ->where("CONCAT(paymenttransactions.paymentdate, ' ', paymenttransactions.paymenttime) <=", $endDatetime)
            ->findAll();
        }else{
            $data['transactionsdata'] = $this->paymentallocationModel
            ->select('paymentallocation.*, paymenttransactions.*, 
            studentassessment.said, 
            studentsaccounts.said, studentsaccounts.course, studentsaccounts.cluster, studentsaccounts.level,
            feestructure.feeid, feestructure.feecode, feestructure.istf')
            ->join('paymenttransactions',   'paymenttransactions.paymentid = paymentallocation.paymentid', 'left')
            ->join('studentassessment',   'studentassessment.sadid = paymentallocation.sadid', 'left')
            ->join('studentsaccounts', 'studentsaccounts.said = studentassessment.said', 'left')
            ->join('feestructure', 'feestructure.feeid = studentassessment.feeid', 'left')
            ->where('paymenttransactions.isdel', 0)
            ->where("CONCAT(paymenttransactions.paymentdate, ' ', paymenttransactions.paymenttime) >=", $startDatetime)
            ->where("CONCAT(paymenttransactions.paymentdate, ' ', paymenttransactions.paymenttime) <=", $endDatetime)
            ->where('paymenttransactions.receivedby', $CASHIER)
            ->findAll();
        }
        $uniqueFeecodes = [];
        foreach($data['transactionsdata'] as $td) {
            $feedata = $this->feestructureModel->where('isdel', 0)
            ->groupBy('feecode')
            ->findAll();
        }
        if(empty($feedata)){
            session()->setTempdata('error','Please check the filter. No fees data available!', 3);
            return redirect()->to(base_url()."cashier-dailytransactions");
        }else{
            
            $data['feedata'] = $this->feestructureModel->where('isdel', 0)
            ->groupBy('feecode')
            ->findAll();
        }

        
        return view('cashier/cashierdailytransreportview2', $data);
    }
    public function cashierDailyTransactionsPDF() {
        if($this->request->is('post')) {
            $STARTDATE = $this->request->getVar('start_date');
            $ENDDATE = $this->request->getVar('end_date');
            $STARTTIME = $this->request->getVar('start_time');
            $ENDTIME = $this->request->getVar('end_time');
            $CASHIER = $this->request->getVar('cashier');
            
            if($STARTTIME == ''){
                $TIMESTART = '00:01';
            }else{
                $TIMESTART = $STARTTIME;
            }
            if($ENDTIME == ''){
                $TIMEEND = '23:01';
            }else{
                $TIMEEND = $ENDTIME;
            }

            // Combine date and time into datetime strings
            $startDatetime = $STARTDATE . ' ' . $TIMESTART;
            $endDatetime = $ENDDATE . ' ' . $TIMEEND;

            if($CASHIER == 'ALL') {
                $TRANSACTIONSDATA = $this->paymentallocationModel
                ->select('paymentallocation.*, paymenttransactions.*, 
                studentassessment.said, 
                studentsaccounts.said, studentsaccounts.course, studentsaccounts.cluster, studentsaccounts.level,
                feestructure.feeid, feestructure.feecode, feestructure.istf')
                ->join('paymenttransactions',   'paymenttransactions.paymentid = paymentallocation.paymentid', 'left')
                ->join('studentassessment',   'studentassessment.sadid = paymentallocation.sadid', 'left')
                ->join('studentsaccounts', 'studentsaccounts.said = studentassessment.said', 'left')
                ->join('feestructure', 'feestructure.feeid = studentassessment.feeid', 'left')
                ->where('paymenttransactions.isdel', 0)
                ->where("CONCAT(paymenttransactions.paymentdate, ' ', paymenttransactions.paymenttime) >=", $startDatetime)
                ->where("CONCAT(paymenttransactions.paymentdate, ' ', paymenttransactions.paymenttime) <=", $endDatetime)
                ->findAll();
            }else{
                $TRANSACTIONSDATA = $this->paymentallocationModel
                ->select('paymentallocation.*, paymenttransactions.*, 
                studentassessment.said, 
                studentsaccounts.said, studentsaccounts.course, studentsaccounts.cluster, studentsaccounts.level,
                feestructure.feeid, feestructure.feecode, feestructure.istf')
                ->join('paymenttransactions',   'paymenttransactions.paymentid = paymentallocation.paymentid', 'left')
                ->join('studentassessment',   'studentassessment.sadid = paymentallocation.sadid', 'left')
                ->join('studentsaccounts', 'studentsaccounts.said = studentassessment.said', 'left')
                ->join('feestructure', 'feestructure.feeid = studentassessment.feeid', 'left')
                ->where('paymenttransactions.isdel', 0)
                ->where("CONCAT(paymenttransactions.paymentdate, ' ', paymenttransactions.paymenttime) >=", $startDatetime)
                ->where("CONCAT(paymenttransactions.paymentdate, ' ', paymenttransactions.paymenttime) <=", $endDatetime)
                ->where('paymenttransactions.receivedby', $CASHIER)
                ->findAll();
            }
            
            // Separate ISTF and regular fees
            $regularFeecodes = [];
            $istfData = [];
            
            foreach ($TRANSACTIONSDATA as $data) {
                if ($data['istf'] == 1) {
                    // Collect ISTF data for FEE and TF columns
                    $istfData[] = $data;
                } else {
                    // Regular fees for headers
                    if (!empty($data['feecode']) && !in_array($data['feecode'], $regularFeecodes)) {
                        $regularFeecodes[] = $data['feecode'];
                    }
                }
            }

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $spreadsheet->getProperties()->setCreator('MIS Department')
                ->setTitle('Cashier Daily Transactions');

            // Calculate the range for regular feecode columns
            $feecodeCount = count($regularFeecodes);
            
            // Set row 2 headers
            $colIndex2 = 'A';
            $sheet->setCellValue($colIndex2++ . '1', 'STUDENT NUMBER');
            $sheet->setCellValue($colIndex2++ . '1', 'STUDENT NAME');
            $sheet->setCellValue($colIndex2++ . '1', 'LEVEL');
            $sheet->setCellValue($colIndex2++ . '1', 'OR NUMBER');
            $sheet->setCellValue($colIndex2++ . '1', 'FEE'); // ISTF feecode will appear here
            $sheet->setCellValue($colIndex2++ . '1', 'TF');  // ISTF amount will appear here
            
            $feeColumns = [];
            foreach ($regularFeecodes as $feecode) {
                $currentCol = $colIndex2;
                $sheet->setCellValue($colIndex2++ . '1', $feecode);
                $feeColumns[$feecode] = $currentCol;
            }
            
            $sheet->setCellValue($colIndex2++ . '1', 'PAYMENT METHOD');
            $sheet->setCellValue($colIndex2++ . '1', 'PARTICULARS');
            $sheet->setCellValue($colIndex2++ . '1', 'PAYMENT DATE');
            $sheet->setCellValue($colIndex2++ . '1', 'PAYMENT TIME');
            $sheet->setCellValue($colIndex2++ . '1', 'CASHIER');
            
            // Initialize totals array
            $totals = [
                'TF' => 0,  // For TF column (ISTF amounts)
                'FEE' => 0  // For FEE column (ISTF amounts - actually just count, not sum)
            ];
            
            // Initialize totals for regular fee columns
            foreach ($regularFeecodes as $feecode) {
                $totals[$feecode] = 0;
            }
            
            // Write data rows - start from row 3
            $row = 2;
            foreach ($TRANSACTIONSDATA as $TRANSD) {
                $colIndex = 'A';
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['studentno']);
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['studfullname']);
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['level']);
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['ornumber'] ?? '');
                
                // Handle FEE column (ISTF feecode)
                if ($TRANSD['istf'] == 1) {
                    $sheet->setCellValue($colIndex++ . $row, $TRANSD['feecode'] ?? '');
                    // Handle TF column (ISTF amount)
                    $tfAmount = $TRANSD['amountpaid'] ?? 0;
                    $sheet->setCellValue($colIndex++ . $row,$tfAmount);
                    // Add to TF total
                    $totals['TF'] += $tfAmount;
                } else {
                    $sheet->setCellValue($colIndex++ . $row, ''); // Empty FEE column
                    $sheet->setCellValue($colIndex++ . $row, ''); // Empty TF column
                }
                
                // Place payment amount under the corresponding regular feecode column
                foreach ($regularFeecodes as $feecode) {
                    if ($TRANSD['istf'] == 0 && $TRANSD['feecode'] == $feecode) {
                        $feeAmount = $TRANSD['amountpaid'] ?? 0;
                        $sheet->setCellValue($feeColumns[$feecode] . $row, $feeAmount);
                        // Add to regular fee column total
                        $totals[$feecode] += $feeAmount;
                    } else {
                        $sheet->setCellValue($feeColumns[$feecode] . $row, '');
                    }
                    $colIndex++;
                }
                
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['paymentmethod'] ?? '');
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['particulars'] ?? '');
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['paymentdate'] ?? '');
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['paymenttime'] ?? '');
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['receivedby'] ?? '');
                $row++;
            }
            
            // Add total row
            $totalRow = $row + 1;
            
            // Calculate grand total (sum of all amounts)
            $grandTotal = array_sum(array_column($TRANSACTIONSDATA, 'amountpaid'));
            
            // Reset column index for total row
            $colIndexTotal = 'A';
            $sheet->setCellValue($colIndexTotal++ . $totalRow, '');
            $sheet->setCellValue($colIndexTotal++ . $totalRow, '');
            $sheet->setCellValue($colIndexTotal++ . $totalRow, '');
            $sheet->setCellValue($colIndexTotal++ . $totalRow, '');
            $sheet->setCellValue($colIndexTotal++ . $totalRow, 'TOTAL:');
            $sheet->getStyle($colIndexTotal . $totalRow)->getFont()->setBold(true);
            
            // Add TF total (this is in column E, after FEE column)
            // Since FEE column is D and TF column is E
            $sheet->setCellValue('F' . $totalRow, $totals['TF']);
            $sheet->getStyle('F' . $totalRow)->getFont()->setBold(true);
            
            // Add totals for regular fee columns
            $feeColumnsTotal = $feeColumns; // Get the starting columns for each fee
            foreach ($regularFeecodes as $feecode) {
                $colLetter = $feeColumns[$feecode];
                if ($totals[$feecode] > 0) {
                    $sheet->setCellValue($colLetter . $totalRow, $totals[$feecode]);
                    $sheet->getStyle($colLetter . $totalRow)->getFont()->setBold(true);
                } else {
                    $sheet->setCellValue($colLetter . $totalRow, '-');
                }
            }
            
            // Add grand total in a separate row below
            $grandTotalRow = $totalRow + 1;
            $sheet->setCellValue('E' . $grandTotalRow, 'GRAND TOTAL:');
            $sheet->getStyle('E' . $grandTotalRow)->getFont()->setBold(true);
            $sheet->setCellValue('F' . $grandTotalRow, $grandTotal);
            $sheet->getStyle('F' . $grandTotalRow)->getFont()->setBold(true);
            
            // Optionally, add a summary row that shows totals by payment method
            $summaryRow = $grandTotalRow + 1;
            $sheet->setCellValue('A' . $summaryRow, 'Number of Transactions: ' . count($TRANSACTIONSDATA));
            $sheet->getStyle('A' . $summaryRow)->getFont()->setItalic(true);
            
            // Calculate payment method totals
            $paymentMethodTotals = [];
            foreach ($TRANSACTIONSDATA as $TRANSD) {
                $method = $TRANSD['paymentmethod'] ?? 'Unknown';
                if (!isset($paymentMethodTotals[$method])) {
                    $paymentMethodTotals[$method] = 0;
                }
                $paymentMethodTotals[$method] += ($TRANSD['amountpaid'] ?? 0);
            }
            
            // Add payment method summary
            $summaryRow++;
            $sheet->setCellValue('A' . $summaryRow, 'Payment Method Summary:');
            $sheet->getStyle('A' . $summaryRow)->getFont()->setBold(true);
            
            foreach ($paymentMethodTotals as $method => $total) {
                $summaryRow++;
                $sheet->setCellValue('A' . $summaryRow, $method . ':');
                $sheet->setCellValue('B' . $summaryRow, $total);
            }
            
            // Auto-size columns
            $lastColumn = $colIndex2;
            $lastColumnLetter = chr(ord('A') + count(range('A', $lastColumn)) - 1);
            
            $columns = range('A', $lastColumnLetter);
            foreach ($columns as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
            
            // Protect sheet
            $password = "misis10mb";
            $sheet->getProtection()->setPassword($password);
            $sheet->getProtection()->setSheet(true);
            
            $writer = new Xlsx($spreadsheet);
            $filename = 'cashier_daily_transactions_' . date('Y-m-d') . '.xlsx';
            
            return $this->response
                ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheet.sheet')
                ->setHeader('Content-Disposition', "attachment; filename=\"$filename\"")
                ->setHeader('Cache-Control', 'max-age=0')
                ->setBody($this->generateOutput($writer));
        }    
    }
    public function cashierDailyTransactionsExport() {
        if($this->request->is('post')) {
            $STARTDATE = $this->request->getVar('start_date');
            $ENDDATE = $this->request->getVar('end_date');
            $STARTTIME = $this->request->getVar('start_time');
            $ENDTIME = $this->request->getVar('end_time');
            $CASHIER = $this->request->getVar('cashier');
            
            if($STARTTIME == ''){
                $TIMESTART = '00:01';
            }else{
                $TIMESTART = $STARTTIME;
            }
            if($ENDTIME == ''){
                $TIMEEND = '23:01';
            }else{
                $TIMEEND = $ENDTIME;
            }

            // Combine date and time into datetime strings
            $startDatetime = $STARTDATE . ' ' . $TIMESTART;
            $endDatetime = $ENDDATE . ' ' . $TIMEEND;

            if($CASHIER == 'ALL') {
                $TRANSACTIONSDATA = $this->paymentallocationModel
                ->select('paymentallocation.*, paymenttransactions.*, 
                studentassessment.said, 
                studentsaccounts.said, studentsaccounts.course, studentsaccounts.cluster, studentsaccounts.level,
                feestructure.feeid, feestructure.feecode, feestructure.istf')
                ->join('paymenttransactions',   'paymenttransactions.paymentid = paymentallocation.paymentid', 'left')
                ->join('studentassessment',   'studentassessment.sadid = paymentallocation.sadid', 'left')
                ->join('studentsaccounts', 'studentsaccounts.said = studentassessment.said', 'left')
                ->join('feestructure', 'feestructure.feeid = studentassessment.feeid', 'left')
                ->where('paymenttransactions.isdel', 0)
                ->where("CONCAT(paymenttransactions.paymentdate, ' ', paymenttransactions.paymenttime) >=", $startDatetime)
                ->where("CONCAT(paymenttransactions.paymentdate, ' ', paymenttransactions.paymenttime) <=", $endDatetime)
                ->findAll();
            }else{
                $TRANSACTIONSDATA = $this->paymentallocationModel
                ->select('paymentallocation.*, paymenttransactions.*, 
                studentassessment.said, 
                studentsaccounts.said, studentsaccounts.course, studentsaccounts.cluster, studentsaccounts.level,
                feestructure.feeid, feestructure.feecode, feestructure.istf')
                ->join('paymenttransactions',   'paymenttransactions.paymentid = paymentallocation.paymentid', 'left')
                ->join('studentassessment',   'studentassessment.sadid = paymentallocation.sadid', 'left')
                ->join('studentsaccounts', 'studentsaccounts.said = studentassessment.said', 'left')
                ->join('feestructure', 'feestructure.feeid = studentassessment.feeid', 'left')
                ->where('paymenttransactions.isdel', 0)
                ->where("CONCAT(paymenttransactions.paymentdate, ' ', paymenttransactions.paymenttime) >=", $startDatetime)
                ->where("CONCAT(paymenttransactions.paymentdate, ' ', paymenttransactions.paymenttime) <=", $endDatetime)
                ->where('paymenttransactions.receivedby', $CASHIER)
                ->findAll();
            }
            
            // Separate ISTF and regular fees
            $regularFeecodes = [];
            $istfData = [];
            
            foreach ($TRANSACTIONSDATA as $data) {
                if ($data['istf'] == 1) {
                    // Collect ISTF data for FEE and TF columns
                    $istfData[] = $data;
                } else {
                    // Regular fees for headers
                    if (!empty($data['feecode']) && !in_array($data['feecode'], $regularFeecodes)) {
                        $regularFeecodes[] = $data['feecode'];
                    }
                }
            }

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $spreadsheet->getProperties()->setCreator('MIS Department')
                ->setTitle('Cashier Daily Transactions');

            // Calculate the range for regular feecode columns
            $feecodeCount = count($regularFeecodes);
            
            // Set row 2 headers
            $colIndex2 = 'A';
            $sheet->setCellValue($colIndex2++ . '1', 'STUDENT NUMBER');
            $sheet->setCellValue($colIndex2++ . '1', 'STUDENT NAME');
            $sheet->setCellValue($colIndex2++ . '1', 'LEVEL');
            $sheet->setCellValue($colIndex2++ . '1', 'OR NUMBER');
            $sheet->setCellValue($colIndex2++ . '1', 'FEE'); // ISTF feecode will appear here
            $sheet->setCellValue($colIndex2++ . '1', 'TF');  // ISTF amount will appear here
            
            $feeColumns = [];
            foreach ($regularFeecodes as $feecode) {
                $currentCol = $colIndex2;
                $sheet->setCellValue($colIndex2++ . '2', $feecode);
                $feeColumns[$feecode] = $currentCol;
            }
            
            $sheet->setCellValue($colIndex2++ . '1', 'PAYMENT METHOD');
            $sheet->setCellValue($colIndex2++ . '1', 'PARTICULARS');
            $sheet->setCellValue($colIndex2++ . '1', 'PAYMENT DATE');
            $sheet->setCellValue($colIndex2++ . '1', 'PAYMENT TIME');
            $sheet->setCellValue($colIndex2++ . '1', 'CASHIER');
            
            // Initialize totals array
            $totals = [
                'TF' => 0,  // For TF column (ISTF amounts)
                'FEE' => 0  // For FEE column (ISTF amounts - actually just count, not sum)
            ];
            
            // Initialize totals for regular fee columns
            foreach ($regularFeecodes as $feecode) {
                $totals[$feecode] = 0;
            }
            
            // Write data rows - start from row 3
            $row = 3;
            foreach ($TRANSACTIONSDATA as $TRANSD) {
                $colIndex = 'A';
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['studentno']);
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['studfullname']);
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['level']);
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['ornumber'] ?? '');
                
                // Handle FEE column (ISTF feecode)
                if ($TRANSD['istf'] == 1) {
                    $sheet->setCellValue($colIndex++ . $row, $TRANSD['feecode'] ?? '');
                    // Handle TF column (ISTF amount)
                    $tfAmount = $TRANSD['amountpaid'] ?? 0;
                    $sheet->setCellValue($colIndex++ . $row, $tfAmount);
                    // Add to TF total
                    $totals['TF'] += $tfAmount;
                } else {
                    $sheet->setCellValue($colIndex++ . $row, ''); // Empty FEE column
                    $sheet->setCellValue($colIndex++ . $row, ''); // Empty TF column
                }
                
                // Place payment amount under the corresponding regular feecode column
                foreach ($regularFeecodes as $feecode) {
                    if ($TRANSD['istf'] == 0 && $TRANSD['feecode'] == $feecode) {
                        $feeAmount = $TRANSD['amountpaid'] ?? 0;
                        $sheet->setCellValue($feeColumns[$feecode] . $row, $feeAmount);
                        // Add to regular fee column total
                        $totals[$feecode] += $feeAmount;
                    } else {
                        $sheet->setCellValue($feeColumns[$feecode] . $row, '');
                    }
                    $colIndex++;
                }
                
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['paymentmethod'] ?? '');
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['particulars'] ?? '');
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['paymentdate'] ?? '');
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['paymenttime'] ?? '');
                $sheet->setCellValue($colIndex++ . $row, $TRANSD['receivedby'] ?? '');
                $row++;
            }
            
            // Add total row
            $totalRow = $row + 1;
            
            // Calculate grand total (sum of all amounts)
            $grandTotal = array_sum(array_column($TRANSACTIONSDATA, 'amountpaid'));
            
            // Reset column index for total row
            $colIndexTotal = 'A';
            $sheet->setCellValue($colIndexTotal++ . $totalRow, '');
            $sheet->setCellValue($colIndexTotal++ . $totalRow, '');
            $sheet->setCellValue($colIndexTotal++ . $totalRow, '');
            $sheet->setCellValue($colIndexTotal++ . $totalRow, '');
            $sheet->setCellValue($colIndexTotal++ . $totalRow, 'TOTAL:');
            $sheet->getStyle($colIndexTotal . $totalRow)->getFont()->setBold(true);
            
            // Add TF total (this is in column E, after FEE column)
            // Since FEE column is D and TF column is E
            $sheet->setCellValue('F' . $totalRow, $totals['TF']);
            $sheet->getStyle('F' . $totalRow)->getFont()->setBold(true);
            
            // Add totals for regular fee columns
            $feeColumnsTotal = $feeColumns; // Get the starting columns for each fee
            foreach ($regularFeecodes as $feecode) {
                $colLetter = $feeColumns[$feecode];
                if ($totals[$feecode] > 0) {
                    $sheet->setCellValue($colLetter . $totalRow, $totals[$feecode]);
                    $sheet->getStyle($colLetter . $totalRow)->getFont()->setBold(true);
                } else {
                    $sheet->setCellValue($colLetter . $totalRow, '-');
                }
            }
            
            // Add grand total in a separate row below
            $grandTotalRow = $totalRow + 1;
            $sheet->setCellValue('E' . $grandTotalRow, 'GRAND TOTAL:');
            $sheet->getStyle('E' . $grandTotalRow)->getFont()->setBold(true);
            $sheet->setCellValue('F' . $grandTotalRow, $grandTotal);
            $sheet->getStyle('F' . $grandTotalRow)->getFont()->setBold(true);
            
            // Optionally, add a summary row that shows totals by payment method
            $summaryRow = $grandTotalRow + 1;
            $sheet->setCellValue('A' . $summaryRow, 'Number of Transactions: ' . count($TRANSACTIONSDATA));
            $sheet->getStyle('A' . $summaryRow)->getFont()->setItalic(true);
            
            // Calculate payment method totals
            $paymentMethodTotals = [];
            foreach ($TRANSACTIONSDATA as $TRANSD) {
                $method = $TRANSD['paymentmethod'] ?? 'Unknown';
                if (!isset($paymentMethodTotals[$method])) {
                    $paymentMethodTotals[$method] = 0;
                }
                $paymentMethodTotals[$method] += ($TRANSD['amountpaid'] ?? 0);
            }
            
            // Add payment method summary
            $summaryRow++;
            $sheet->setCellValue('A' . $summaryRow, 'Payment Method Summary:');
            $sheet->getStyle('A' . $summaryRow)->getFont()->setBold(true);
            
            foreach ($paymentMethodTotals as $method => $total) {
                $summaryRow++;
                $sheet->setCellValue('A' . $summaryRow, $method . ':');
                $sheet->setCellValue('B' . $summaryRow, $total);
            }
            
            // Auto-size columns
            $lastColumn = $colIndex2;
            $lastColumnLetter = chr(ord('A') + count(range('A', $lastColumn)) - 1);
            
            $columns = range('A', $lastColumnLetter);
            foreach ($columns as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
            
            // // Protect sheet
            // $password = "misis10mb";
            // $sheet->getProtection()->setPassword($password);
            // $sheet->getProtection()->setSheet(true);
            
            $writer = new Xlsx($spreadsheet);
            $filename = 'cashier_daily_transactions_' . date('Y-m-d') . '.xlsx';
            
            return $this->response
                ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheet.sheet')
                ->setHeader('Content-Disposition', "attachment; filename=\"$filename\"")
                ->setHeader('Cache-Control', 'max-age=0')
                ->setBody($this->generateOutput($writer));
        } 
    }
    private function generateOutput($writer) {
        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_contents();
        ob_end_clean();

        return $excelOutput;
    }
    public function cashierDailyTransactionsUpdate($id=null) {
        if($this->request->is('post')) {
            $FULLNAME = $this->request->getVar('fullname');
            
            $data = [
                'paymentdate' => $this->request->getVar('paymentdate'),
                'paymenttime' => $this->request->getVar('paymenttime'),
                'ornumber' => $this->request->getVar('ornumber'),
                'amountpaid' => $this->request->getVar('amount'),
                'particulars' => $this->request->getVar('particulars'),
            ];
            $this->paymentransactionsModel->where('paymentid', $id)->update($id, $data);
            
            // $SEARCHSTUDENT = $this->regstudentsModel->where('studfullname', $FULLNAME)->findAll();
            // foreach($SEARCHSTUDENT as $searchs){
            //     $STUDID = $searchs['studid'];
            // }
            // $REGSTATUS = $this->request->getVar('departmentedit');
            // $rdata = [
            //     'studstatus' => $REGSTATUS,
            // ];
            
            // $this->regstudentsModel->where('studid', $STUDID)->update($STUDID, $rdata);
            
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."cashier-dailytransactions");
        }
    }
}
