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
        $this->session = session();
    }
    public function index()
    {
        $data = [
            'page_title' => 'Holy Cross College | Cashier Transaction',
            'page_heading' => 'CASHIER TRANSACTION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        if($this->request->is('post')) {
            $searchStudent = $this->request->getVar('searchstud');

            if($searchStudent == ''){
                $StudentsCondition = array('studisdel' => 0);
                $data['resultStudent'] = $this->studentsModel->where($StudentsCondition)->findAll();
                return view('cashierviewresult', $data);
            }
            else{
                $StudentsCondition = array('studisdel' => 0);
                $data['resultStudent'] = $this->studentsModel->where($StudentsCondition)
                ->like('studentno', $searchStudent)
                ->orLike('studln', $searchStudent)
                ->orLike('studfn', $searchStudent)
                ->orLike('studfullname', $searchStudent)
                ->findAll();
                return view('cashierviewresult', $data);
            }
        }

        return view('cashierview', $data);
    }
    public function transactionView($id=null)
    {
        $data = [
            'page_title' => 'Holy Cross College | Cashier Transaction View',
            'page_heading' => 'CASHIER TRANSACTION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $data['assessmentData'] = $this->assModel->where('studentno', $id)->findAll();

        return view('cashiertransactionview', $data);
    }
    public function transactionViewOpen($id=null)
    {
        $data = [
            'page_title' => 'Holy Cross College | Cashier Transaction View Open',
            'page_heading' => 'CASHIER TRANSACTION! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user'))
        {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        $assessmentInfo = $this->assModel->where('assid', $id)->findAll();
        foreach($assessmentInfo as $assinfo){
            $studentNo = $assinfo['studentno'];
        }

        $data['assessmentData'] = $this->assModel->where('studentno', $studentNo)->findAll();
        $data['studentInfo'] = $this->studentsModel->where('studid', $studentNo)->findAll();
        $data['courseInfo'] = $this->coursesModel->findAll();

        $data['assessment'] = $this->assModel->where('studentno', $studentNo)
        ->where('status', 'Finalized')->findAll();
        foreach($data['assessment'] as $ass) {
            $ASSID = $ass['assid'];
            $SECTION = $ass['section'];
            $SY = $ass['sy'];
            $SEM = $ass['sem'];
            $LEVEL = $ass['level'];
            $COURSE = $ass['course'];
        }
        $data['students'] = $this->studentsModel->where('studid', $studentNo)->findAll();
        $data['colgradesdata'] = $this->colgradesModel->where('assid', $ASSID)->findAll();
        $data['subject'] = $this->subjectsModel->findAll();
        $data['schedule'] = $this->schedulesModel->findAll();
        $COURSEData = $this->coursesModel->where('courid', $COURSE)->findAll();
        foreach($COURSEData as $courd) {    
            $COURCODE = $courd['courcode'];
        }
        $data['ratesData'] = $this->ratesModel
        ->where('sy', $SY)
        ->where('sem', $SEM)
        ->where('year', $LEVEL)
        ->where('course', $COURCODE)->findAll();
        foreach($data['ratesData'] as $ratesD) {
            $RATESID = $ratesD['rateid'];
        }
        $data['rofdata'] = $this->rofModel->where('rateid', $RATESID)->findAll();
        $data['duedata'] = $this->rateDuesModel->where('rateid', $RATESID)->findAll();

        $data['totalmajorunits'] = $this->colgradesModel->select('
            SUM(subjects.units) as totalmajorunits, SUM(subjects.hours) as totalmajorhours
            ')->join('subjects', 'subjects.subid = collegegrades.subid')
            ->where('collegegrades.assid', $ASSID)
            ->where('subjects.major', 1)
            ->where('subjects.subcode !=', "NSTP01")
            ->where('subjects.subcode !=', "NSTP02")
            ->findAll();

        $data['totalminorunits'] = $this->colgradesModel->select('
            SUM(subjects.units) as totalminorunits, SUM(subjects.hours) as totalminorhours
            ')->join('subjects', 'subjects.subid = collegegrades.subid')
            ->where('collegegrades.assid', $ASSID)
            ->where('subjects.major', 0)
            ->where('subjects.subcode !=', "NSTP01")
            ->where('subjects.subcode !=', "NSTP02")
            ->findAll();

        return view('cashiertransactionviewopen', $data);
    }
    public function cashierOnlineRegistration()
    {
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
    public function cashierOnlineRegistrationPayment($id=null)
    {
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
    public function cashierOnlineRegistrationprocessPayment($id=null)
    {
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
    public function onlineregPrint($id=null)
    {
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
                    <td style="width: 30%;">'.$PAYMENTDATE.'</td>
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
    public function cashierDailyTransactions()
    {
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

        // Get filter parameters
        $dateFilter = $this->request->getGet('date_filter');
        $paymentStatus = $this->request->getGet('payment_status');
        $paymentMethod = $this->request->getGet('payment_method');
        $departmentFilter = $this->request->getGet('department'); // New filter

        $query = $this->paymentransactionsModel
        ->SELECT('paymenttransactions.*, regstudents.*')
        ->JOIN('regstudents', 'regstudents.studfullname = paymenttransactions.studfullname')
        ->WHERE('paymenttransactions.isdel', 0)
        ->orderBy('paymenttransactions.paymentdate', 'DESC')
        ->orderBy('paymenttransactions.paymenttime', 'DESC');

        // Apply filters
        if ($dateFilter) {
            $query->where('DATE(paymenttransactions.paymentdate)', $dateFilter);
            $data['selected_date'] = $dateFilter;
        } else {
            // Default to today's date
            $today = date('Y-m-d');
            $query->where('DATE(paymenttransactions.paymentdate)', $today);
            $data['selected_date'] = $today;
        }

        if ($paymentMethod && $paymentMethod !== 'all') {
            $query->where('paymenttransactions.paymentmethod', $paymentMethod);
        }

        // Apply department filter
        if ($departmentFilter && $departmentFilter !== 'all') {
            $query->where('regstudents.studstatus', $departmentFilter);
            $data['selected_department'] = $departmentFilter;
        } else {
            $data['selected_department'] = 'all';
        }

        // Get unique departments for dropdown
        $data['departments'] = $this->regstudentsModel
            ->select('studstatus')
            ->distinct()
            ->where('studstatus IS NOT NULL')
            ->where('studstatus !=', '')
            ->orderBy('studstatus', 'ASC')
            ->findAll();

        // Get transactions
        $data['paymenttransactiondata'] = $query->findAll();

        // Calculate totals
        $data['total_amount'] = 0;
        $data['total_count'] = count($data['paymenttransactiondata']);
        $data['paid_count'] = 0;
        $data['pending_count'] = 0;
        
        foreach ($data['paymenttransactiondata'] as $transaction) {
            $data['total_amount'] += $transaction['amountpaid'];
            
            if ($transaction['paymentstatus'] == 'Paid') {
                $data['paid_count']++;
            } elseif ($transaction['paymentstatus'] == 'Pending') {
                $data['pending_count']++;
            }
        }
        
        return view('cashier/cashierdailytransreportview', $data);
    }
    // Add this new method after the cashierDailyTransactions() method
    public function cashierDailyTransactionsPDF()
    {
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        
        // Get filter parameters
        $dateFilter = $this->request->getGet('date_filter');
        $paymentMethod = $this->request->getGet('payment_method');
        $departmentFilter = $this->request->getGet('department');
        
        $query = $this->paymentransactionsModel
            ->SELECT('paymenttransactions.*, regstudents.*')
            ->JOIN('regstudents', 'regstudents.studfullname = paymenttransactions.studfullname')
            ->WHERE('paymenttransactions.isdel', 0)
            ->orderBy('paymenttransactions.paymentdate', 'DESC')
            ->orderBy('paymenttransactions.paymenttime', 'DESC');
        
        // Apply filters
        if ($dateFilter) {
            $query->where('DATE(paymenttransactions.paymentdate)', $dateFilter);
            $selected_date = $dateFilter;
        } else {
            $today = date('Y-m-d');
            $query->where('DATE(paymenttransactions.paymentdate)', $today);
            $selected_date = $today;
        }
        
        if ($paymentMethod && $paymentMethod !== 'all') {
            $query->where('paymenttransactions.paymentmethod', $paymentMethod);
        }
        
        if ($departmentFilter && $departmentFilter !== 'all') {
            $query->where('regstudents.studstatus', $departmentFilter);
        }
        
        $transactions = $query->findAll();
        
        // Calculate totals
        $total_amount = 0;
        $total_count = count($transactions);
        $paid_count = 0;
        
        foreach ($transactions as $transaction) {
            $total_amount += $transaction['amountpaid'];
            if ($transaction['paymentstatus'] == 'Paid') {
                $paid_count++;
            }
        }
        
        // Create PDF
        $pageSize = array(216, 330);
        $pdf = new TCPDF('L', 'mm', $pageSize, true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator('HCC Cashier System');
        $pdf->SetAuthor('Holy Cross College');
        $pdf->SetTitle('Daily Transaction Report');
        $pdf->SetSubject('Cashier Transactions');
        
        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        // Set margins
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetAutoPageBreak(TRUE, 15);
        
        // Add a page
        $pdf->AddPage();
        
        // Set font
        $pdf->SetFont('dejavusans', '', 11);

        $html = '
            <table  style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 100%; font-weight: bold;">HOLY CROSS COLLEGE</td>
                    </tr>
                    <tr>
                        <td style="width: 100%; font-weight: bold;">CASHIER DAILY TRANSACTION REPORT</td>
                    </tr>
                    <tr>
                        <td style="width: 100%;">'.date('F d, Y', strtotime($selected_date)).'</td>
                    </tr>  
                    <br>
                    <tr>
                        <td style="width: 100%; font-weight: bold;">REPORT SUMMARY</td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Report Date:</td>
                        <td style="width: 80%; font-weight: bold;">'.date('F d, Y', strtotime($selected_date)).'</td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Generated On:</td>
                        <td style="width: 80%; font-weight: bold;">'. date('F d, Y h:i A').'</td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Total Transactions:</td>
                        <td style="width: 80%; font-weight: bold;">'. number_format($total_count).'</td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Paid Transactions:</td>
                        <td style="width: 80%; font-weight: bold;">'. number_format($paid_count).'</td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">Total Amount Collected:</td>
                        <td style="width: 80%; font-weight: bold;">₱ '. number_format($total_amount, 2).'</td>
                    </tr>
                </tbody>
            </table><br><br>
            <table border="1" style="width: 100%; ">
                <thead>
                    <tr>
                        <td style="width: 10%; text-align: center;">OR</td>
                        <td style="width: 15%; text-align: center;">REFERENCE</td>
                        <td style="width: 20%; text-align: center;">STUDENT</td>
                        <td style="width: 10%; text-align: center;">DEPT</td>
                        <td style="width: 10%; text-align: center;">DATE</td>
                        <td style="width: 10%; text-align: center;">METHOD</td>
                        <td style="width: 10%; text-align: center;">AMOUNT</td>
                        <td style="width: 15%; text-align: center;">RECEIVED</td>
                    </tr>
                </thead>
                <tbody>
                ';
                
                foreach($transactions as $index => $transaction) {
                    // Department display
                    $dept = $transaction['studstatus'];
                    if($dept == 'GS') {
                        $dept_display = 'IBED';
                    } elseif($dept == 'SHS') {
                        $dept_display = 'SHS';
                    } else {
                        $dept_display = 'COLLEGE';
                    }
                    
                    // Payment method
                    $method = $transaction['paymentmethod'];
                    if($method == 'Check') {
                        $method_display = $method . "\n#" . $transaction['checknumber'];
                    } else {
                        $method_display = $method;
                    }
                    
                    // Status with color indicator
                    $status = $transaction['paymentstatus'];
                    $status_display = ($status == 'Paid') ? '✓ PAID' : $status;
                    
                    // Amount
                    $amount = '₱' . number_format($transaction['amountpaid'], 2);
                    
                    $html .= '
                    <tr>
                        <td style="width: 10%;">'.$transaction['ornumber'].'</td>
                        <td style="width: 15%;">'.$transaction['paymentreference'].'</td>
                        <td style="width: 20%;">'.$transaction['studfullname'].'</td>
                        <td style="width: 10%;">'.$dept_display.'</td>
                        <td style="width: 10%;">'.date('m/d/y', strtotime($transaction['paymentdate'])).'</td>
                        <td style="width: 10%;">'. $method_display.'</td>
                        <td style="width: 10%;">'.$amount.'</td>
                        <td style="width: 15%;">'.$transaction['receivedby'].'</td>
                    </tr>';
                }
                
        $html .= '
        </tbody>
            </table>
        ';
        
        $pdf->writeHTML($html, true, false, false, false, '');
        // Output PDF
        $filename = 'Daily_Transactions_' . $selected_date . '.pdf';
        $pdfContent = $pdf->Output($filename, 'S');
        
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody($pdfContent);
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
            
            $SEARCHSTUDENT = $this->regstudentsModel->where('studfullname', $FULLNAME)->findAll();
            foreach($SEARCHSTUDENT as $searchs){
                $STUDID = $searchs['studid'];
            }
            $REGSTATUS = $this->request->getVar('departmentedit');
            $rdata = [
                'studstatus' => $REGSTATUS,
            ];
            
            $this->regstudentsModel->where('studid', $STUDID)->update($STUDID, $rdata);
            
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."cashier-dailytransactions");
        }
    }
}
