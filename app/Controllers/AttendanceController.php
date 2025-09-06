<?php

namespace App\Controllers;
use App\Models\EmployeesModel;
use App\Models\AttendancesModel;
use App\Models\SYModel;
use App\Models\UsersModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\I18n\Time;
class AttendanceController extends BaseController
{
    public $employeesModel;
    public $attendancesModel;
    public $syModel;
    public $usersModel;
    public $session;
    public function __construct() {
        helper('form');
        $this->employeesModel = new EmployeesModel();
        $this->attendancesModel = new AttendancesModel();
        $this->syModel = new SYModel();
        $this->usersModel = new UsersModel();
        $this->session = session();
    }
    public function index()
    {
        $DATETODAY = date('Y-m-d');
        $data['attdata'] = $this->attendancesModel->where('date', $DATETODAY)->orderBy('attid', 'DESC')->findall();
        $data['empdata'] = $this->employeesModel->findall();
        $data['attendancedata'] = $this->attendancesModel->where('date', $DATETODAY)->orderBy('attid', 'DESC')->first();
        $LastAttendance = $this->attendancesModel->where('date', $DATETODAY)->orderBy('attid', 'DESC')->first();
        if(empty($LastAttendance)){

        } else {
            $EMPNUM = $LastAttendance['employeeno'];
            $data['employeedata'] = $this->employeesModel->where('empnum', $EMPNUM)->first();
        }
        
        
        
        if($this->request->is('post')) {
            $RFID = $this->request->getVar('rfidno');
            $CheckSY = $this->syModel->where('systatus', 0)->first();

            $CHECKRFIDIFEXIST = $this->attendancesModel->where('rfid', $RFID)->findAll();
            
            // print_r($CHECKRFIDIFEXIST);
            if(empty($CHECKRFIDIFEXIST)) {
                $CHECKEMPLOYEERFID = $this->employeesModel->where('rfidno', $RFID)->findAll();
                if(empty($CHECKEMPLOYEERFID)) {
                    session()->setTempdata('message', 'RFID DO NOT EXIST!', 2);
                    return redirect()->to(base_url()."biometrics");
                } else {
                    foreach($CHECKEMPLOYEERFID as $CER) {
                        $EMPNUM = $CER['empnum'];
                        $EMPRFID = $CER['rfidno'];
                    }
                    $data = [
                        'employeeno' => $EMPNUM,
                        'rfid' => $EMPRFID,
                        'sy' => $CheckSY['syname'],
                        'date' => date('Y-m-d'),
                        'timein' => date('H:i:s'),
                    ];
                    $this->attendancesModel->save($data);
                    return redirect()->to(current_url());
                }
            } else {
                $RFIDDATA = $this->attendancesModel->where('rfid', $RFID)->orderBy('attid', 'DESC')->first();
                $RFIDATE = $RFIDDATA['date'];
                $RFIDATTID = $RFIDDATA['attid'];
                $RFIDTIMEIN = $RFIDDATA['timein'];
                $RFIDTIMEOUT = $RFIDDATA['timeout'];

                if($RFIDATE == date('Y-m-d')) {
                    $PLUSONEHOUR = date('H:i:s', strtotime($RFIDTIMEIN . ' +1 hour'));
                    if(date('H:i:s') <= $PLUSONEHOUR) {
                        session()->setTempdata('message', 'You are already tapped in. Please wait for one hour before tapping out again!', 2);
                        return redirect()->to(current_url());
                    } else {
                        if(empty($RFIDTIMEOUT) || $RFIDTIMEOUT == '00:00:00') {
                            $data = [
                                'timeout' => date('H:i:s'),
                            ];
                            $this->attendancesModel->where('attid', $RFIDATTID)->update($RFIDATTID, $data);
                            return redirect()->to(base_url()."biometrics-out/".$RFIDATTID);
                        } else {
                            session()->setTempdata('message', 'Already tapped out.', 2);
                            return redirect()->to(current_url());
                        }
                    }
                } else {
                    $CHECKEMPLOYEERFID = $this->employeesModel->where('rfidno', $RFID)->findAll();
                    foreach($CHECKEMPLOYEERFID as $CER) {
                        $EMPNUM = $CER['empnum'];
                        $EMPRFID = $CER['rfidno'];
                    }
                    $data = [
                        'employeeno' => $EMPNUM,
                        'rfid' => $EMPRFID,
                        'sy' => $CheckSY['syname'],
                        'date' => date('Y-m-d'),
                        'timein' => date('H:i:s'),
                    ];
                    $this->attendancesModel->save($data);
                    return redirect()->to(current_url());
                }
            } 
        }
        return view('biometricsview', $data);
    }
    public function biometricsoout($id=null) {
        $DATETODAY = date('Y-m-d');
        $data['attdata'] = $this->attendancesModel->where('date', $DATETODAY)->orderBy('attid', 'DESC')->findall();
        $data['empdata'] = $this->employeesModel->findall();
        
        $data['attendancedata'] = $this->attendancesModel->where('date', $DATETODAY)->where('attid', $id)->first();
        $LastAttendance = $this->attendancesModel->where('date', $DATETODAY)->where('attid', $id)->first();
        if(empty($LastAttendance)){

        } else {
            $EMPNUM = $LastAttendance['employeeno'];
            $data['employeedata'] = $this->employeesModel->where('empnum', $EMPNUM)->first();
        }
        return view('biometricsoutview', $data);
    }
    public function biometricsblank() {
        $DATETODAY = date('Y-m-d');
        $data['attdata'] = $this->attendancesModel->where('date', $DATETODAY)->orderBy('attid', 'DESC')->findall();
        $data['empdata'] = $this->employeesModel->findall();
        $data['attendancedata'] = $this->attendancesModel->where('date', $DATETODAY)->orderBy('attid', 'DESC')->first();
        $LastAttendance = $this->attendancesModel->where('date', $DATETODAY)->orderBy('attid', 'DESC')->first();
        if(empty($LastAttendance)){

        } else {
            $EMPNUM = $LastAttendance['employeeno'];
            $data['employeedata'] = $this->employeesModel->where('empnum', $EMPNUM)->first();
        }

        return view('biometricsblankview', $data);
    }
    public function attendanceview() {
        $data = [
            'page_title' => 'Holy Cross College | Attendance',
            'page_heading' => 'ATTENDANCE! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();

        if($this->request->is('post')) {
            $rules = [
                'startdate' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Starting date is required.',
                    ],
                ],
                'enddate' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Ending date is required.',
                    ],
                ],
            ];
            if($this->validate($rules)) {
                $STARTINGDATE = $this->request->getVar('startdate');
                $ENDINGDATE = $this->request->getVar('enddate');
                $this->session->set('selected_startingdate', $STARTINGDATE);
                $this->session->set('selected_endingdate', $ENDINGDATE);
                return redirect()->to(base_url().'hrd-attendance-generate');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('attendanceview', $data);
    }
    public function attendancegenerate() {
        $data = [
            'page_title' => 'Holy Cross College | Attendance',
            'page_heading' => 'ATTENDANCE! ',
            'page_p' => 'Welcome to Holy Cross College School Management System.',
        ];
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url());
        }
        $uid = session()->get('logged_user');
        $data['userdata'] = $this->usersModel->getLoggedInUserData($uid);
        $data['usersaccess'] = $this->usersModel->where('uid', $uid)->findAll();
        $data['empdata'] = $this->employeesModel->findall();
        $STARTDATE = session()->get('selected_startingdate');
        $ENDDATE = session()->get('selected_endingdate');
        $data['DATESTART'] = $STARTDATE;
        $data['DATEEND'] = $ENDDATE;
        $data['attendancedata'] = $this->attendancesModel
                ->where('date >=', $STARTDATE)
                ->where('date <=', $ENDDATE)->findAll();

        return view('attendancegenerateview', $data);
    }
    public function downloadExcel($start=null, $end=null) {
        $EMPDATA = $this->employeesModel->findall();
        $STARTDATE = $start;
        $ENDDATE = $end;
        $ATTDATA = $this->attendancesModel
                ->where('date >=', $STARTDATE)
                ->where('date <=', $ENDDATE)->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()->setCreator('MIS Department')
            ->setTitle('Exported Attendance Data');

        // Add data to sheet
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Date');
        $sheet->setCellValue('D1', 'Time In');
        $sheet->setCellValue('E1', 'Time Out');
        $sheet->setCellValue('F1', 'Rendered Hours');

        $row = 2;

        foreach ($ATTDATA as $ATTD) {
            $formattedDate = date('F j, Y', strtotime($ATTD['date']));
            $formattedTimeIn = date('h:i A', strtotime($ATTD['timein']));
            if(empty($ATTD['timeout']) || $ATTD['timeout'] == '00:00:00') {
                $formattedTimeOut = "--:-- --";
            } else {
                $formattedTimeOut = date('h:i A', strtotime($ATTD['timeout']));
            }

            $start = Time::parse($ATTD['timein']);
            $end   = Time::parse($ATTD['timeout']);
            if(empty($ATTD['timeout']) || $ATTD['timeout'] == '00:00:00')  {
                $formattedDiffHours = '0';
            } else {
                $diffHours = ($end->getTimestamp() - $start->getTimestamp()) / 3600;
                $formattedDiffHours = number_format($diffHours, 3);
            }
            

            
            foreach ($EMPDATA as $EMPD) {
                if($ATTD['employeeno'] == $EMPD['empnum']){
                    $sheet->setCellValue('A' . $row, $ATTD['employeeno']);
                    $sheet->setCellValue('B' . $row, $EMPD['empfullname']);
                    $sheet->setCellValue('C' . $row, $formattedDate);
                    $sheet->setCellValue('D' . $row, $formattedTimeIn);
                    $sheet->setCellValue('E' . $row, $formattedTimeOut);
                    $sheet->setCellValue('F' . $row, $formattedDiffHours);
                    $row++;
                }
            }
        }
        // Write the file to output
        $writer = new Xlsx($spreadsheet);
        $filename = 'attendance_export.xlsx';

        // Set headers for download
        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', "attachment; filename=\"$filename\"")
            ->setHeader('Cache-Control', 'max-age=0')
            ->setBody($this->generateOutput($writer));
    }
    private function generateOutput($writer)
    {
        // Capture output in memory
        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_contents();
        ob_end_clean();

        return $excelOutput;
    }
}