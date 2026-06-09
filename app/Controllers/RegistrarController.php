<?php

namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\PaymentTransactionsModel;
use App\Models\RegStudentsModel;
use App\Models\SYModel;
use App\Models\SemesterModel;
use App\Models\StudentSubjectsModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\I18n\Time;
use TCPDF;

class RegistrarController extends BaseController
{
    public $usersModel;
    public $paymentransactionsModel;
    public $regstudentsModel;
    public $syModel;
    public $semModel;
    public $studentSubjectsModel;
    public $session;
    
    public function __construct() {
        helper('form');
        $this->usersModel = new UsersModel();
        $this->paymentransactionsModel = new PaymentTransactionsModel();
        $this->regstudentsModel = new RegStudentsModel();
        $this->syModel = new SYModel();
        $this->semModel = new SemesterModel();
        $this->studentSubjectsModel = new StudentSubjectsModel();
        $this->session = session();
    }

    public function onlineregreports() {
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
    public function exportPDF() {
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
    private function getFilteredData($from_date = null, $to_date = null) {
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
    public function enrollmentListCollege() {
        $data = [
            'page_title' => 'Holy Cross College | College Enrollment List Report',
            'page_heading' => 'COLLEGE ENROLLMENT LIST REPORT',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['schoolyeardata'] = $this->syModel->where('syisdel',0)->findAll();
        $data['semesterdata'] = $this->semModel->where('semisdel',0)->findAll();
        
        if($this->request->is('post')) {
            
            $SY = $this->request->getVar('schoolyear');
            $SEM = $this->request->getVar('semester');

            // Get all enrolled students with their subjects
            $ELCOLDATA = $this->studentSubjectsModel
                ->select('students_col.*, subjects.*, studentsaccounts.*')
                ->join('students_col', 'students_col.studid = student_subjects.studid')
                ->join('studentsaccounts', 'studentsaccounts.studentno = students_col.studentno')
                ->join('currdata', 'currdata.cdid = student_subjects.cdid')
                ->join('subjects', 'subjects.subid = currdata.subid')
                ->where('studentsaccounts.sy', $SY)
                ->where('studentsaccounts.sem', $SEM)
                ->where('student_subjects.isdel', 0)
                ->orderBy('students_col.studfullname', 'ASC')
                ->findAll();

            // Group subjects by student
            $studentsData = [];

            foreach($ELCOLDATA as $row) {
                $studentId = $row['studid'];
                if (!isset($studentsData[$studentId])) {
                    $studentsData[$studentId] = [
                        'student' => $row,
                        'subjects' => []
                    ];
                }

                // Check if subject already exists to avoid duplicates
                $subjectExists = false;
                foreach($studentsData[$studentId]['subjects'] as $existingSubject) {
                    if($existingSubject['subcode'] == $row['subcode']) {
                        $subjectExists = true;
                        break;
                    }
                }
                if(!$subjectExists) {
                    $studentsData[$studentId]['subjects'][] = [
                        'subcode' => $row['subcode'],
                        'units' => $row['units']
                    ];
                }
            }

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $spreadsheet->getProperties()->setCreator('MIS Department')
                ->setTitle('Enrollment List College');

            // ========== INSERT SCHOOL HEADER (Rows 1-4) ==========
            $sheet->setCellValue('A1', 'HOLY CROSS COLLEGE');
            $sheet->getStyle('A1')->getFont()->setBold(true);
            $sheet->getStyle('A1')->getFont()->setSize(14);
            $sheet->mergeCells('A1:V1');
            
            $sheet->setCellValue('A2', 'Sta. Lucia, Sta. Ana, Pampanga');
            $sheet->mergeCells('A2:V2');
            
            $sheet->setCellValue('A3', '09975576145, 09975574794');
            $sheet->mergeCells('A3:V3');
            
            // Semester and School Year (Row 4)
            $sheet->setCellValue('A4', $SEM . ', AY ' . $SY);
            $sheet->mergeCells('A4:V4');
            
            // Empty row for spacing (Row 5)
            $sheet->setCellValue('A5', '');
            
            // ========== MAIN TABLE HEADERS (Starting Row 6) ==========
            // ROW 6 - Main headers
            $sheet->setCellValue('A6', 'EL #');
            $sheet->setCellValue('B6', 'Name of Students');
            $sheet->setCellValue('C6', 'Sex');
            $sheet->setCellValue('D6', '');
            $sheet->setCellValue('E6', 'Course');
            $sheet->setCellValue('F6', 'Year');
            $sheet->setCellValue('G6', 'Major/Area of Specialization');
            
            // Subject columns (7 subject pairs = 14 columns H to U)
            $colIndex = 'H';
            for($i = 1; $i <= 7; $i++) {
                $sheet->setCellValue($colIndex++ . '6', 'Subject');
                $sheet->setCellValue($colIndex++ . '6', 'Unit');
            }
            $sheet->setCellValue('V6', 'Total');
            
            // ROW 7 - Sub-headers
            $sheet->setCellValue('A7', '');
            $sheet->setCellValue('B7', '(Last Name, First Name, Middle Name)');
            $sheet->setCellValue('C7', 'M');
            $sheet->setCellValue('D7', 'F');
            $sheet->setCellValue('E7', '');
            $sheet->setCellValue('F7', '');
            $sheet->setCellValue('G7', '');
            
            $colIndex = 'H';
            for($i = 1; $i <= 7; $i++) {
                $sheet->setCellValue($colIndex++ . '7', 'Code');
                $sheet->setCellValue($colIndex++ . '7', '');
            }
            $sheet->setCellValue('V7', 'Units');
            
            // ROW 8 - Empty row for alignment
            for($col = 'A'; $col <= 'V'; $col++) {
                $sheet->setCellValue($col . '8', '');
            }
            
            // ========== APPLY ALL MERGES ==========
            $sheet->mergeCells('A6:A8');      // EL #
            $sheet->mergeCells('B6:B8');      // Name of Students
            $sheet->mergeCells('C6:D6');      // Sex header
            $sheet->mergeCells('C7:C8');      // M
            $sheet->mergeCells('D7:D8');      // F
            $sheet->mergeCells('E6:E8');      // Course
            $sheet->mergeCells('F6:F8');      // Year
            $sheet->mergeCells('G6:G8');      // Major
            
            // Subject columns - each pair (Code + Unit)
            $startCol = 'H';
            for($i = 1; $i <= 7; $i++) {
                $codeCol = $startCol;
                $unitCol = chr(ord($startCol) + 1);
                
                $sheet->mergeCells($codeCol . '6:' . $codeCol . '7');
                $sheet->mergeCells($unitCol . '6:' . $unitCol . '7');
                
                $startCol = chr(ord($startCol) + 2);
            }
            
            $sheet->mergeCells('V6:V8');      // Total
            
            // ========== APPLY STYLES TO HEADERS ==========
            $sheet->getStyle('A6:V8')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A6:V8')->getAlignment()->setVertical('center');
            $sheet->getStyle('A6:V6')->getFont()->setBold(true);
            
            // Apply borders to header area
            $headerBorderStyle = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];
            $sheet->getStyle('A6:V8')->applyFromArray($headerBorderStyle);
            
            // Wrap text for B7
            $sheet->getStyle('B7')->getAlignment()->setWrapText(true);
            
            // ========== POPULATE STUDENT DATA ==========
            $row = 9;
            $counter = 1;

            foreach($studentsData as $studentData) {
                $student = $studentData['student'];
                $subjects = $studentData['subjects'];
                
                // Determine Year Level Roman Numeral
                $yearLevel = '';
                switch($student['level']) {
                    case '1st Year': $yearLevel = 'I'; break;
                    case '2nd Year': $yearLevel = 'II'; break;
                    case '3rd Year': $yearLevel = 'III'; break;
                    case '4th Year': $yearLevel = 'IV'; break;
                    default: $yearLevel = $student['level'];
                }
                
                // Determine Sex
                $maleSex = '';
                $femaleSex = '';
                if(strtoupper($student['studgender']) == 'MALE') {
                    $maleSex = '/';
                } elseif(strtoupper($student['studgender']) == 'FEMALE') {
                    $femaleSex = '/';
                }
                
                // ========== FIX MAJOR COLUMN ==========
                // Determine Major based on Course
                $major = '';
                $course = $student['course'];
                
                if($course == 'BSBA-MM') {
                    $major = 'Marketing Management';
                } elseif($course == 'BSBA-FM') {
                    $major = 'Financial Management';
                } elseif($course == 'BSEd-ENGLISH') {
                    $major = 'English';
                } elseif($course == 'BSEd-SCIENCE') {
                    $major = 'Science';
                } elseif($course == 'BSEd-FILIPINO') {
                    $major = 'Filipino';
                } elseif($course == 'BSEd-MATHEMATICS') {
                    $major = 'Mathematics';
                } else {
                    $major = ''; // Blank for non-BSBA courses
                }
                
                // Calculate total units
                $totalUnits = 0;
                foreach($subjects as $subject) {
                    $totalUnits += $subject['units'];
                }
                
                // Process subjects in chunks of 7
                $subjectChunks = array_chunk($subjects, 7);
                $chunkCount = count($subjectChunks);
                
                $isFirstRow = true;
                
                // Loop through each chunk of subjects (max 7 per row)
                for($chunkIndex = 0; $chunkIndex < $chunkCount; $chunkIndex++) {
                    $chunk = $subjectChunks[$chunkIndex];
                    
                    // Set basic student info (ONLY on first row)
                    if($isFirstRow) {
                        $sheet->setCellValue('A' . $row, $counter);
                        $sheet->setCellValue('B' . $row, $student['studfullname']);
                        $sheet->setCellValue('C' . $row, $maleSex);
                        $sheet->setCellValue('D' . $row, $femaleSex);
                        $sheet->setCellValue('E' . $row, $student['course']);
                        $sheet->setCellValue('F' . $row, $yearLevel);
                        $sheet->setCellValue('G' . $row, $major);  // Fixed: gamit ang $major variable
                        $isFirstRow = false;
                    } else {
                        // Blank student info for additional rows
                        $sheet->setCellValue('A' . $row, '');
                        $sheet->setCellValue('B' . $row, '');
                        $sheet->setCellValue('C' . $row, '');
                        $sheet->setCellValue('D' . $row, '');
                        $sheet->setCellValue('E' . $row, '');
                        $sheet->setCellValue('F' . $row, '');
                        $sheet->setCellValue('G' . $row, '');
                    }
                    
                    // Add subjects for this chunk
                    $colIndex = 'H';
                    foreach($chunk as $subject) {
                        $sheet->setCellValue($colIndex++ . $row, $subject['subcode']);
                        $sheet->setCellValue($colIndex++ . $row, $subject['units']);
                    }
                    
                    // Fill remaining columns (kung kulang ng subjects para sa 7 pairs)
                    $subjectsInChunk = count($chunk);
                    for($i = $subjectsInChunk; $i < 7; $i++) {
                        $sheet->setCellValue($colIndex++ . $row, '');
                        $sheet->setCellValue($colIndex++ . $row, '');
                    }
                    
                    // Add total units (ONLY on the last row of this student)
                    if($chunkIndex == $chunkCount - 1) {
                        $sheet->setCellValue('V' . $row, $totalUnits);
                    } else {
                        $sheet->setCellValue('V' . $row, '');
                    }
                    
                    $row++;
                }
                
                // ========== ADD ONE BLANK ROW AFTER STUDENT (ONCE ONLY) ==========
                // Punan ng blanko ang buong row
                for($col = 'A'; $col <= 'V'; $col++) {
                    $sheet->setCellValue($col . $row, '');
                }
                $row++; // Move to next row
                
                $counter++;
            }
            
            // ========== APPLY BORDERS TO DATA ROWS ==========
            if($row > 9) {
                $dataBorderStyle = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];
                $sheet->getStyle('A9:V' . ($row - 1))->applyFromArray($dataBorderStyle);
            }
            
            // ========== ADD SIGNATURES AT THE BOTTOM ==========
            $lastRow = $row - 1;
            $signatureRow = $lastRow + 3;
            
            $sheet->setCellValue('A' . $signatureRow, 'Prepared by:');
            $sheet->mergeCells('A' . $signatureRow . ':F' . $signatureRow);
            $sheet->setCellValue('M' . $signatureRow, 'Noted by:');
            $sheet->mergeCells('M' . $signatureRow . ':V' . $signatureRow);
            
            $sheet->setCellValue('A' . ($signatureRow + 2), 'BENJIE B. NOLASCO, MAEd.');
            $sheet->mergeCells('A' . ($signatureRow + 2) . ':F' . ($signatureRow + 2));
            $sheet->setCellValue('M' . ($signatureRow + 2), 'AIDA P. DIZON');
            $sheet->mergeCells('M' . ($signatureRow + 2) . ':V' . ($signatureRow + 2));
            
            $sheet->setCellValue('A' . ($signatureRow + 3), 'Dean, SASD');
            $sheet->mergeCells('A' . ($signatureRow + 3) . ':F' . ($signatureRow + 3));
            $sheet->setCellValue('M' . ($signatureRow + 3), 'President');
            $sheet->mergeCells('M' . ($signatureRow + 3) . ':V' . ($signatureRow + 3));
            
            $sheet->setCellValue('A' . ($signatureRow + 4), 'Acting Registrar');
            $sheet->mergeCells('A' . ($signatureRow + 4) . ':F' . ($signatureRow + 4));
            
            // ========== AUTO-SIZE COLUMNS ==========
            foreach(range('A','V') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }
            
            $sheet->getColumnDimension('B')->setWidth(40);
            $sheet->getColumnDimension('G')->setWidth(25);
            
            // Freeze pane
            $sheet->freezePane('A9');
            
            // ========== GENERATE OUTPUT ==========
            $writer = new Xlsx($spreadsheet);
            $filename = 'Enrollment List ' . $SEM . ' AY ' . $SY . '.xlsx';
            
            return $this->response
                ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheet.sheet')
                ->setHeader('Content-Disposition', "attachment; filename=\"$filename\"")
                ->setHeader('Cache-Control', 'max-age=0')
                ->setBody($this->generateOutput($writer));
        }

        return view('registrar/enrollmentlistcolview', $data);
    }
    private function generateOutput($writer) {
        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_contents();
        ob_end_clean();

        return $excelOutput;
    }
}