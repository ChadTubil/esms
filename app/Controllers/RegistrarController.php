<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\PaymentTransactionsModel;
use App\Models\RegStudentsModel;
use TCPDF;

class RegistrarController extends BaseController
{
    public $usersModel;
    public $paymentransactionsModel;
    public $regstudentsModel;
    public $session;
    
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->paymentransactionsModel = new PaymentTransactionsModel();
        $this->regstudentsModel = new RegStudentsModel();
        $this->session = session();
    }

    public function onlineregreports()
    {
        $data = [
            'page_title' => 'Holy Cross College | Online Registration Reports',
            'page_heading' => 'ONLINE REGISTRATION REPORTS',
            'page_p' => 'View and filter online registration transactions by date range.',
        ];
        
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        
        // Get today's date in Y-m-d format
        $today = date('Y-m-d');
        
        // Get date range from query parameters, default to today if not provided
        $from_date = $this->request->getGet('from_date') ?? $today;
        $to_date = $this->request->getGet('to_date') ?? $today;
        
        // Pass dates back to view for preserving filter values
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        
        // Build query with date filtering
        $query = $this->paymentransactionsModel->select('paymenttransactions.*, regstudents.*')
            ->join('regstudents', 'regstudents.studfullname = paymenttransactions.studfullname')
            ->where('paymenttransactions.isdel', 0);
        
        // Apply date filters
        // Adjust to_date to include the entire day
        $to_date_end = $to_date . ' 23:59:59';
        $query->where('paymenttransactions.paymentdate >=', $from_date)
            ->where('paymenttransactions.paymentdate <=', $to_date_end);
        
        $data['paymenttransactiondata'] = $query->findAll();
        
        // Calculate totals by department
        $total_gs = 0;
        $total_shs = 0;
        $total_college = 0;
        
        foreach($data['paymenttransactiondata'] as $transaction) {
            if(isset($transaction['studstatus'])) {
                if($transaction['studstatus'] == 'GS') {
                    $total_gs++;
                } elseif($transaction['studstatus'] == 'SHS') {
                    $total_shs++;
                } elseif($transaction['studstatus'] == 'COL') {
                    $total_college++;
                }
            }
        }
        
        $data['total_gs'] = $total_gs;
        $data['total_shs'] = $total_shs;
        $data['total_college'] = $total_college;
        
        return view('registrar/onlineregreportsview', $data);
    }
    /**
     * Export to PDF
     */
    public function exportPDF()
    {
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        
        // Get date range from query parameters
        $from_date = $this->request->getGet('from_date');
        $to_date = $this->request->getGet('to_date');
        
        // Get filtered data
        $data = $this->getFilteredData($from_date, $to_date);
        
        // Calculate totals
        $total_gs = 0;
        $total_shs = 0;
        $total_college = 0;
        $total_students = count($data);
        $total_amount = 0;
        
        foreach($data as $transaction) {
            if(isset($transaction['studstatus'])) {
                if($transaction['studstatus'] == 'GS') {
                    $total_gs++;
                } elseif($transaction['studstatus'] == 'SHS') {
                    $total_shs++;
                } elseif($transaction['studstatus'] == 'COL') {
                    $total_college++;
                }
            }
            
            // Sum up amount paid
            if(isset($transaction['amountpaid'])) {
                $total_amount += floatval($transaction['amountpaid']);
            }
        }
        
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetCreator('Holy Cross College');
        $pdf->SetAuthor('TRS Department');
        $pdf->SetTitle('Online Registration Report');
        $pdf->SetSubject('Registration Transactions');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(5,40,5,0);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        
        
        $pdf->AddPage();

        // HEADER
        $imagePath = FCPATH .'public/uploads/hccheader.png';
        $pdf->Image($imagePath, $x = 5, $y = 0, $w = 206, $h = 36); 
        $pdf->Line(5, 37, 211, 37);

        if(!empty($from_date) && !empty($to_date)) {
            $date_text = 'Date Range: ' . date('F d, Y', strtotime($from_date)) . ' to ' . date('F d, Y', strtotime($to_date));
        } elseif(!empty($from_date)) {
            $date_text = 'From: ' . date('F d, Y', strtotime($from_date));
        } elseif(!empty($to_date)) {
            $date_text = 'Until: ' . date('F d, Y', strtotime($to_date));
        } else {
            $date_text = 'Date Range: All Records';
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
            </style>

            <table>
                <tr>
                    <td style="width: 75%;"></td>
                    <td><h3>REGISTRAR</h3></td>
                </tr>   
            </table><br><br>

            <table>
                <tr>
                    <td style="background-color: #b5b5b5; font-size: 25px; font-weight: bold; text-align: center;">ONLINE REGISTRATION REPORT</td>
                </tr>
            </table><br><br>

            <table>
                <tr>
                    <td style="width: 100%; text-align: center;">'. $date_text .'</td>
                </tr>
            </table>
            <br><br><br>
            <table>
                <tr>
                    <td style="width: 100%; text-align: left; font-size: 15px; font-weight: bold;">SUMMARY</td>
                </tr>
                <tr>
                    
                    <td style="width: 30%; font-weight: bold;">IBED: '. $total_gs .' students</td>
                    <td style="width: 30%; font-weight: bold;">SHS: '. $total_shs .' students</td>
                    <td style="width: 30%; font-weight: bold;">COLLEGE: '. $total_college .' students</td>
                    <td style="width: 10%;"></td>
                </tr>
            </table>
            <br><br>
            <table border="1" style="width: 100%;">
                <thead>
                    <tr style="background-color: #b5b5b5; font-weight: bold;">
                        <th style="width: 50%;">STUDENT NAME</th>
                        <th style="width: 50%;">DEPARTMENT</th>
                    </tr>
                </thead>
                <tbody>';
                foreach($data as $row) {
                    // Get department
                    $dept = '';
                    if(isset($row['studstatus'])) {
                        if($row['studstatus'] == 'GS') {
                            $dept = 'Grade School';
                        } elseif($row['studstatus'] == 'SHS') {
                            $dept = 'Senior High';
                        } else {
                            $dept = 'College';
                        }
                    }
                    
                    // Student name
                    $student_name = isset($row['studfullname']) ? $row['studfullname'] : 'N/A';

                    $html .= '<tr>
                        <td style="width: 50%;">'. $student_name .'</td>
                        <td style="width: 50%;">'. $dept .'</td>
                    </tr>';
                    
                }

                $html .= '</tbody>
            </table><br><br>
            <table>
                <tr>
                    <td style="width: 100%; text-align: right;">Report Generated: '. date('F d, Y h:i A') .'</td>
                </tr>
            </table>
        ';
    
        $pdf->writeHTML($html, true, false, false, false, '');
        $filename = 'Online_Registration_Report_' . date('Ymd_His') . '.pdf';
        $pdfContent = $pdf->Output($filename, 'S'); 
        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody($pdfContent);
    }
    
    /**
     * Get filtered data based on date range
     */
    private function getFilteredData($from_date = null, $to_date = null)
    {
        $query = $this->paymentransactionsModel->select('paymenttransactions.*, regstudents.*')
            ->join('regstudents', 'regstudents.studfullname = paymenttransactions.studfullname')
            ->where('paymenttransactions.isdel', 0);
        
        // Apply date filters if provided
        if(!empty($from_date) && !empty($to_date)) {
            // Adjust to_date to include the entire day
            $to_date_end = $to_date . ' 23:59:59';
            $query->where('paymenttransactions.paymentdate >=', $from_date)
                ->where('paymenttransactions.paymentdate <=', $to_date_end);
        } elseif(!empty($from_date)) {
            $query->where('paymenttransactions.paymentdate >=', $from_date);
        } elseif(!empty($to_date)) {
            // If only to_date is provided, get all records up to that date
            $to_date_end = $to_date . ' 23:59:59';
            $query->where('paymenttransactions.paymentdate <=', $to_date_end);
        }
        
        return $query->findAll();
    }
    public function registrarOnlineRegUpdate($id=null) {
        if($this->request->is('post')) {
            $FULLNAME = $this->request->getVar('fullname');
            $LN = $this->request->getVar('ln');
            $FN = $this->request->getVar('fn');
            $MN = $this->request->getVar('mn');
            $EXT = $this->request->getVar('extension');
            
            $SEARCHSTUDENT = $this->regstudentsModel->where('studfullname', $FULLNAME)->findAll();
            foreach($SEARCHSTUDENT as $searchs){
                $STUDID = $searchs['studid'];
            }
            $REGSTATUS = $this->request->getVar('departmentedit');
            $rdata = [
                'studln' => $LN,
                'studfn' => $FN,
                'studmn' => $MN,
                'studextension' => $EXT,
                'studfullname' => $LN .', '. $FN .' '. $MN .' '. $EXT,
            ];
            $this->regstudentsModel->where('studid', $STUDID)->update($STUDID, $rdata);
            $pdata = [
                'studfullname' => $LN .', '. $FN .' '. $MN .' '. $EXT,
            ];
            $this->paymentransactionsModel->where('paymentid', $id)->update($id, $pdata);
            session()->setTempdata('updatesuccess', 'Update Successful!', 2);
            return redirect()->to(base_url()."registrar-onlineregistration-reports");
        }
    }
}